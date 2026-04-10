<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StudentBehavior;
use App\Models\StudentPoint;
use App\Models\Behavior;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class StudentBehaviorController extends Controller
{
    public function index(Request $request)
    {
        $classroom = null;
        $query = StudentBehavior::with(['student', 'behavior', 'teacher']);

        if ($request->has('classroom')) {
            $classroom = Classroom::findOrFail($request->classroom);
            $query->where('classroom_id', $classroom->id);
        }

        // Filtrar por aulas del profesor si es profesor
        if (auth()->user()->role === 'teacher') {
            $classroomIds = auth()->user()->classrooms()->pluck('_id')->toArray();
            $query->whereIn('classroom_id', $classroomIds);
        }

        $studentBehaviors = $query->latest()->paginate(20);

        return view('teacher.student-behaviors', compact('studentBehaviors', 'classroom'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|exists:users,_id',
            'behavior_id' => 'required|string|exists:behaviors,_id',
            'classroom_id' => 'required|string|exists:classrooms,_id',
            'notes' => 'nullable|string|max:500'
        ]);

        // Verificar permisos
        $classroom = Classroom::findOrFail($request->classroom_id);
        if ($classroom->teacher_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para esta acción.'], 403);
        }

        // Verificar que el estudiante esté en el aula
        if (!in_array($request->student_id, $classroom->student_ids ?? [])) {
            return response()->json(['success' => false, 'message' => 'El estudiante no pertenece a esta aula.'], 400);
        }

        $behavior = Behavior::findOrFail($request->behavior_id);
        
        // Crear el registro de comportamiento
        $studentBehavior = StudentBehavior::create([
            'student_id' => $request->student_id,
            'behavior_id' => $request->behavior_id,
            'classroom_id' => $request->classroom_id,
            'points_awarded' => $behavior->points,
            'date' => now(),
            'notes' => $request->notes,
            'awarded_by' => auth()->id(),
            'is_approved' => true
        ]);

        // Actualizar puntos del estudiante
        $this->updateStudentPoints($request->student_id, $request->classroom_id, $behavior->points);

        return response()->json([
            'success' => true,
            'message' => 'Comportamiento registrado exitosamente',
            'data' => $studentBehavior->load(['student', 'behavior'])
        ]);
    }

    public function destroy(StudentBehavior $studentBehavior)
    {
        // Verificar permisos
        if ($studentBehavior->awarded_by !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'No tienes permisos para eliminar este registro.');
        }

        // Revertir puntos
        $this->updateStudentPoints(
            $studentBehavior->student_id, 
            $studentBehavior->classroom_id, 
            -$studentBehavior->points_awarded
        );

        $studentBehavior->delete();

        return response()->json([
            'success' => true,
            'message' => 'Registro eliminado y puntos revertidos exitosamente'
        ]);
    }

    /**
     * Mostrar reportes del aula
     */
    public function reports(Request $request, Classroom $classroom)
    {
        // Verificar permisos
        if (auth()->user()->role === 'teacher' && $classroom->teacher_id !== auth()->id()) {
            abort(403, 'No tienes acceso a esta aula.');
        }

        // Obtener estudiantes del aula
        $students = User::whereIn('_id', $classroom->student_ids ?? [])->get();
        
        // Obtener puntos de estudiantes
        $studentPoints = StudentPoint::whereIn('student_id', $classroom->student_ids ?? [])
                                    ->where('classroom_id', $classroom->id)
                                    ->get();
        
        // Obtener comportamientos del aula
        $behaviors = StudentBehavior::where('classroom_id', $classroom->id)
                                   ->with(['student', 'behavior'])
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        
        // Estadísticas generales
        $stats = [
            'total_students' => $students->count(),
            'total_behaviors' => $behaviors->count(),
            'positive_behaviors' => $behaviors->where('points_awarded', '>', 0)->count(),
            'negative_behaviors' => $behaviors->where('points_awarded', '<', 0)->count(),
            'total_points_awarded' => $behaviors->sum('points_awarded'),
            'average_points_per_student' => $studentPoints->avg('total_points') ?? 0
        ];
        
        // Top estudiantes
        $topStudents = $studentPoints->sortByDesc('total_points')->take(10);
        
        // Comportamientos por fecha (últimos 30 días)
        $behaviorsTimeline = $behaviors->where('created_at', '>=', now()->subDays(30))
                                      ->groupBy(function($item) {
                                          return $item->created_at->format('Y-m-d');
                                      });

        return view('teacher.classrooms.reports', compact(
            'classroom', 
            'students', 
            'studentPoints', 
            'behaviors', 
            'stats', 
            'topStudents', 
            'behaviorsTimeline'
        ));
    }

    /**
     * Exportar reportes a Excel
     */
    public function exportReports(Request $request, Classroom $classroom)
    {
        // Verificar permisos
        if (auth()->user()->role === 'teacher' && $classroom->teacher_id !== auth()->id()) {
            abort(403, 'No tienes acceso a esta aula.');
        }

        $type = $request->get('type', 'students'); // students, behaviors, complete
        
        switch ($type) {
            case 'students':
                return $this->exportStudentsReport($classroom);
            case 'behaviors':
                return $this->exportBehaviorsReport($classroom);
            case 'complete':
                return $this->exportCompleteReport($classroom);
            default:
                return back()->with('error', 'Tipo de reporte no válido');
        }
    }

    /**
     * Exportar reporte de estudiantes (Excel XML)
     */
    private function exportStudentsReport(Classroom $classroom)
    {
        $students = User::whereIn('_id', $classroom->student_ids ?? [])->get();
        $studentPoints = StudentPoint::whereIn('student_id', $classroom->student_ids ?? [])
                                    ->where('classroom_id', $classroom->id)
                                    ->get();

        // Crear archivo XML que Excel puede leer
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <?mso-application progid="Excel.Sheet"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:o="urn:schemas-microsoft-com:office:office"
         xmlns:x="urn:schemas-microsoft-com:office:excel"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:html="http://www.w3.org/TR/REC-html40">
         <Styles>
          <Style ss:ID="Header">
           <Font ss:Bold="1" ss:Color="#FFFFFF"/>
           <Interior ss:Color="#3B82F6" ss:Pattern="Solid"/>
           <Alignment ss:Horizontal="Center"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
          <Style ss:ID="Center">
           <Alignment ss:Horizontal="Center"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
          <Style ss:ID="Text">
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
          <Style ss:ID="Gold">
           <Interior ss:Color="#FEF3C7" ss:Pattern="Solid"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
          <Style ss:ID="Silver">
           <Interior ss:Color="#F3F4F6" ss:Pattern="Solid"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
         </Styles>
         <Worksheet ss:Name="Reporte de Estudiantes">
          <Table>
           <Column ss:Width="60"/>
           <Column ss:Width="200"/>
           <Column ss:Width="250"/>
           <Column ss:Width="100"/>
           <Column ss:Width="80"/>
           <Column ss:Width="100"/>
           <Column ss:Width="150"/>
           <Column ss:Width="120"/>
           <Row ss:StyleID="Header" ss:Height="25">
            <Cell><Data ss:Type="String">🏆 Posición</Data></Cell>
            <Cell><Data ss:Type="String">👤 Nombre Completo</Data></Cell>
            <Cell><Data ss:Type="String">📧 Correo Electrónico</Data></Cell>
            <Cell><Data ss:Type="String">🏆 Puntos Totales</Data></Cell>
            <Cell><Data ss:Type="String">⭐ Nivel Actual</Data></Cell>
            <Cell><Data ss:Type="String">🔥 Racha (días)</Data></Cell>
            <Cell><Data ss:Type="String">📅 Última Actividad</Data></Cell>
            <Cell><Data ss:Type="String">🏅 Cant. Logros</Data></Cell>
           </Row>';

        // Ordenar estudiantes por puntos
        $studentsWithPoints = $students->map(function($student) use ($studentPoints) {
            $points = $studentPoints->where('student_id', $student->id)->first();
            $student->total_points = $points->total_points ?? 0;
            $student->level = $points->level ?? 1;
            $student->streak_days = $points->streak_days ?? 0;
            $student->last_activity = $points->last_activity ?? null;
            $student->achievements = $points->achievements ?? [];
            return $student;
        })->sortByDesc('total_points');

        $position = 1;
        foreach ($studentsWithPoints as $student) {
            $style = 'Text';
            if ($position == 1) $style = 'Gold';
            elseif ($position == 2) $style = 'Silver';
            elseif ($position == 3) $style = 'Gold';
            
            $positionText = $position;
            if ($position == 1) $positionText = '🥇 1°';
            elseif ($position == 2) $positionText = '🥈 2°';
            elseif ($position == 3) $positionText = '🥉 3°';
            
            $xml .= '<Row ss:Height="20">
             <Cell ss:StyleID="' . $style . '"><Data ss:Type="String">' . $positionText . '</Data></Cell>
             <Cell ss:StyleID="' . $style . '"><Data ss:Type="String">' . htmlspecialchars($student->name) . '</Data></Cell>
             <Cell ss:StyleID="' . $style . '"><Data ss:Type="String">' . htmlspecialchars($student->email) . '</Data></Cell>
             <Cell ss:StyleID="Center"><Data ss:Type="Number">' . $student->total_points . '</Data></Cell>
             <Cell ss:StyleID="Center"><Data ss:Type="Number">' . $student->level . '</Data></Cell>
             <Cell ss:StyleID="Center"><Data ss:Type="Number">' . $student->streak_days . '</Data></Cell>
             <Cell ss:StyleID="Text"><Data ss:Type="String">' . ($student->last_activity ? $student->last_activity->format('d/m/Y H:i') : 'Sin actividad') . '</Data></Cell>
             <Cell ss:StyleID="Center"><Data ss:Type="Number">' . count($student->achievements) . '</Data></Cell>
            </Row>';
            $position++;
        }

        $xml .= '</Table>
         </Worksheet>
        </Workbook>';

        $filename = "📊_Estudiantes_" . $classroom->slug . "_" . now()->format('Y-m-d_H-i') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        return Response::make($xml, 200, $headers);
    }

    /**
     * Exportar reporte de comportamientos (Excel XML)
     */
    private function exportBehaviorsReport(Classroom $classroom)
    {
        $behaviors = StudentBehavior::where('classroom_id', $classroom->id)
                                   ->with(['student', 'behavior', 'teacher'])
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <?mso-application progid="Excel.Sheet"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:o="urn:schemas-microsoft-com:office:office"
         xmlns:x="urn:schemas-microsoft-com:office:excel"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:html="http://www.w3.org/TR/REC-html40">
         <Styles>
          <Style ss:ID="Header">
           <Font ss:Bold="1" ss:Color="#FFFFFF"/>
           <Interior ss:Color="#10B981" ss:Pattern="Solid"/>
           <Alignment ss:Horizontal="Center"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
          <Style ss:ID="Center">
           <Alignment ss:Horizontal="Center"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
          <Style ss:ID="Text">
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
          <Style ss:ID="Positive">
           <Font ss:Color="#059669" ss:Bold="1"/>
           <Alignment ss:Horizontal="Center"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
          <Style ss:ID="Negative">
           <Font ss:Color="#DC2626" ss:Bold="1"/>
           <Alignment ss:Horizontal="Center"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
         </Styles>
         <Worksheet ss:Name="Reporte de Comportamientos">
          <Table>
           <Column ss:Width="50"/>
           <Column ss:Width="130"/>
           <Column ss:Width="200"/>
           <Column ss:Width="200"/>
           <Column ss:Width="80"/>
           <Column ss:Width="80"/>
           <Column ss:Width="150"/>
           <Column ss:Width="300"/>
           <Row ss:StyleID="Header" ss:Height="25">
            <Cell><Data ss:Type="String">#</Data></Cell>
            <Cell><Data ss:Type="String">📅 Fecha y Hora</Data></Cell>
            <Cell><Data ss:Type="String">👤 Estudiante</Data></Cell>
            <Cell><Data ss:Type="String">⭐ Comportamiento</Data></Cell>
            <Cell><Data ss:Type="String">📊 Tipo</Data></Cell>
            <Cell><Data ss:Type="String">🏆 Puntos</Data></Cell>
            <Cell><Data ss:Type="String">👨‍🏫 Profesor</Data></Cell>
            <Cell><Data ss:Type="String">📝 Notas</Data></Cell>
           </Row>';

        $counter = 1;
        foreach ($behaviors as $behavior) {
            $pointsStyle = ($behavior->points_awarded ?? 0) > 0 ? 'Positive' : 'Negative';
            $pointsText = ($behavior->points_awarded ?? 0) > 0 ? '+' . $behavior->points_awarded : $behavior->points_awarded;
            $typeText = ($behavior->points_awarded ?? 0) > 0 ? '⭐ Positivo' : '⚠️ Negativo';
            
            $xml .= '<Row ss:Height="20">
             <Cell ss:StyleID="Center"><Data ss:Type="Number">' . $counter . '</Data></Cell>
             <Cell ss:StyleID="Center"><Data ss:Type="String">' . $behavior->created_at->format('d/m/Y H:i') . '</Data></Cell>
             <Cell ss:StyleID="Text"><Data ss:Type="String">' . htmlspecialchars($behavior->student->name ?? 'Estudiante eliminado') . '</Data></Cell>
             <Cell ss:StyleID="Text"><Data ss:Type="String">' . htmlspecialchars($behavior->behavior->name ?? 'Comportamiento eliminado') . '</Data></Cell>
             <Cell ss:StyleID="Center"><Data ss:Type="String">' . $typeText . '</Data></Cell>
             <Cell ss:StyleID="' . $pointsStyle . '"><Data ss:Type="String">' . $pointsText . '</Data></Cell>
             <Cell ss:StyleID="Text"><Data ss:Type="String">' . htmlspecialchars($behavior->teacher->name ?? 'Profesor eliminado') . '</Data></Cell>
             <Cell ss:StyleID="Text"><Data ss:Type="String">' . htmlspecialchars($behavior->notes ?? '-') . '</Data></Cell>
            </Row>';
            $counter++;
        }

        $xml .= '</Table>
         </Worksheet>
        </Workbook>';

        $filename = "📊_Comportamientos_" . $classroom->slug . "_" . now()->format('Y-m-d_H-i') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        return Response::make($xml, 200, $headers);
    }

    /**
     * Exportar reporte completo (Excel XML)
     */
    private function exportCompleteReport(Classroom $classroom)
    {
        // Por ahora usa el reporte de estudiantes, pero puedes expandirlo
        return $this->exportStudentsReport($classroom);
    }

    private function updateStudentPoints($studentId, $classroomId, $points)
    {
        $studentPoint = StudentPoint::firstOrCreate([
            'student_id' => $studentId,
            'classroom_id' => $classroomId
        ], [
            'total_points' => 0,
            'level' => 1,
            'experience_points' => 0,
            'points_spent' => 0,
            'streak_days' => 0,
            'achievements' => [],
            'last_activity' => now()
        ]);

        $newTotal = max(0, $studentPoint->total_points + $points); // No permitir puntos negativos
        $newLevel = floor($newTotal / 100) + 1; // Cada 100 puntos = 1 nivel

        // Actualizar racha si es un comportamiento positivo
        $newStreak = $studentPoint->streak_days;
        if ($points > 0) {
            $lastActivity = $studentPoint->last_activity;
            if ($lastActivity && $lastActivity->isToday()) {
                // Ya tuvo actividad hoy, mantener racha
            } elseif ($lastActivity && $lastActivity->isYesterday()) {
                // Actividad ayer, incrementar racha
                $newStreak++;
            } else {
                // Reiniciar racha
                $newStreak = 1;
            }
        }

        $studentPoint->update([
            'total_points' => $newTotal,
            'level' => $newLevel,
            'experience_points' => $newTotal,
            'streak_days' => $newStreak,
            'last_activity' => now()
        ]);

        // Verificar logros
        $this->checkAchievements($studentPoint);

        return $studentPoint;
    }

    private function checkAchievements($studentPoint)
    {
        $achievements = $studentPoint->achievements ?? [];
        $newAchievements = [];

        // Logro por puntos
        if ($studentPoint->total_points >= 100 && !in_array('first_hundred', $achievements)) {
            $newAchievements[] = 'first_hundred';
        }

        if ($studentPoint->total_points >= 500 && !in_array('five_hundred_club', $achievements)) {
            $newAchievements[] = 'five_hundred_club';
        }

        if ($studentPoint->total_points >= 1000 && !in_array('thousand_master', $achievements)) {
            $newAchievements[] = 'thousand_master';
        }

        // Logro por nivel
        if ($studentPoint->level >= 5 && !in_array('level_5', $achievements)) {
            $newAchievements[] = 'level_5';
        }

        if ($studentPoint->level >= 10 && !in_array('level_10', $achievements)) {
            $newAchievements[] = 'level_10';
        }

        // Logro por racha
        if ($studentPoint->streak_days >= 7 && !in_array('week_warrior', $achievements)) {
            $newAchievements[] = 'week_warrior';
        }

        if ($studentPoint->streak_days >= 30 && !in_array('month_champion', $achievements)) {
            $newAchievements[] = 'month_champion';
        }

        // Actualizar logros si hay nuevos
        if (!empty($newAchievements)) {
            $allAchievements = array_merge($achievements, $newAchievements);
            $studentPoint->update(['achievements' => $allAchievements]);

            // Aquí podrías enviar notificaciones o registrar el evento
            // event(new AchievementUnlocked($studentPoint, $newAchievements));
        }
    }
}
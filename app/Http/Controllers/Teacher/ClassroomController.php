<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use App\Models\StudentPoint;
use App\Models\StudentBehavior;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ClassroomController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'teacher') {
            $classrooms = Classroom::where('teacher_id', $user->id)->get();
        } else {
            $classrooms = Classroom::whereIn('_id', $user->classroom_ids ?? [])->get();
        }
            
        return view('teacher.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        // Solo profesores pueden crear aulas
        if (auth()->user()->role !== 'teacher') {
            abort(403, 'Solo los profesores pueden crear aulas.');
        }
        
        return view('teacher.classrooms.create');
    }

    public function store(Request $request)
    {
        // Solo profesores pueden crear aulas
        if (auth()->user()->role !== 'teacher') {
            abort(403, 'Solo los profesores pueden crear aulas.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'subject' => 'required|string|max:100',
            'grade_level' => 'required|string|max:50',
            'settings' => 'nullable|array',
        ]);

        $classroom = Classroom::create([
            'name' => $request->name,
            'description' => $request->description,
            'teacher_id' => auth()->id(),
            'subject' => $request->subject,
            'grade_level' => $request->grade_level,
            'class_code' => $this->generateUniqueClassCode(),
            'school_year' => $this->getCurrentSchoolYear(),
            'student_ids' => [],
            'is_active' => true,
            'settings' => array_merge([
                'allow_student_rewards' => true,
                'public_leaderboard' => false,
                'parent_notifications' => true
            ], $request->settings ?? [])
        ]);

        return redirect()->route('teacher.classrooms.show', $classroom)
                        ->with('success', 'Aula creada exitosamente. Código: ' . $classroom->class_code);
    }

    public function show(Classroom $classroom)
    {
        // Verificar acceso
        $user = auth()->user();
        if ($user->role === 'teacher' && $classroom->teacher_id !== $user->id) {
            abort(403, 'No tienes acceso a esta aula.');
        }
        
        if ($user->role === 'student' && !in_array($classroom->id, $user->classroom_ids ?? [])) {
            abort(403, 'No tienes acceso a esta aula.');
        }

        // Cargar estudiantes con sus puntos
        $students = User::whereIn('_id', $classroom->student_ids ?? [])->get();
        
        // Agregar información de puntos a cada estudiante
        $students = $students->map(function($student) use ($classroom) {
            $studentPoint = StudentPoint::where('student_id', $student->id)
                                      ->where('classroom_id', $classroom->id)
                                      ->first();
            
            $student->studentPoints = $studentPoint ? [$studentPoint->toArray()] : [
                [
                    'classroom_id' => $classroom->id,
                    'total_points' => 0,
                    'level' => 1
                ]
            ];
            
            return $student;
        });

        // Cargar comportamientos y recompensas
        $behaviors = $classroom->behaviors()->where('is_active', true)->get();
        $rewards = $classroom->rewards()->where('is_active', true)->get();
        
        // Cargar actividades recientes
        $recentActivities = StudentBehavior::where('classroom_id', $classroom->id)
                                         ->with(['student', 'behavior'])
                                         ->orderBy('created_at', 'desc')
                                         ->limit(10)
                                         ->get();
        
        // Asegurar que el aula tenga un código de acceso
        if (empty($classroom->class_code)) {
            $classroom->update(['class_code' => $this->generateUniqueClassCode()]);
            $classroom->refresh();
        }
        
        return view('teacher.classrooms.show', compact(
            'classroom', 
            'students', 
            'behaviors', 
            'rewards', 
            'recentActivities'
        ));
    }

    private function generateUniqueClassCode()
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (Classroom::where('class_code', $code)->exists());
        
        return $code;
    }

    private function getCurrentSchoolYear()
    {
        $currentYear = date('Y');
        $currentMonth = date('n');
        
        if ($currentMonth >= 8) {
            return $currentYear . '-' . ($currentYear + 1);
        } else {
            return ($currentYear - 1) . '-' . $currentYear;
        }
    }

    public function edit(Classroom $classroom)
    {
        // Solo el profesor propietario puede editar
        if (auth()->user()->role !== 'teacher' || $classroom->teacher_id !== auth()->id()) {
            abort(403, 'No tienes permisos para editar esta aula.');
        }
        return view('teacher.classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        // Solo el profesor propietario puede actualizar
        if (auth()->user()->role !== 'teacher' || $classroom->teacher_id !== auth()->id()) {
            abort(403, 'No tienes permisos para actualizar esta aula.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'subject' => 'required|string|max:100',
            'grade_level' => 'required|string|max:50',
            'is_active' => 'boolean',
            'settings' => 'nullable|array',
        ]);

        $classroom->update([
            'name' => $request->name,
            'description' => $request->description,
            'subject' => $request->subject,
            'grade_level' => $request->grade_level,
            'is_active' => $request->has('is_active'),
            'settings' => array_merge($classroom->settings ?? [], $request->settings ?? [])
        ]);

        return redirect()->route('teacher.classrooms.show', $classroom)
                        ->with('success', 'Aula actualizada exitosamente.');
    }

    public function destroy(Classroom $classroom)
    {
        // Solo el profesor propietario puede eliminar
        if (auth()->user()->role !== 'teacher' || $classroom->teacher_id !== auth()->id()) {
            abort(403, 'No tienes permisos para eliminar esta aula.');
        }

        // Verificar si tiene estudiantes inscritos
        if (!empty($classroom->student_ids)) {
            return back()->with('error', 'No se puede eliminar un aula con estudiantes inscritos. Remueve a todos los estudiantes primero.');
        }

        $classroom->delete();

        return redirect()->route('teacher.classrooms.index')
                        ->with('success', 'Aula eliminada exitosamente.');
    }

    public function joinByCode(Request $request)
    {
        $request->validate([
            'class_code' => 'required|string|size:6'
        ]);

        $classroom = Classroom::where('class_code', strtoupper($request->class_code))
                             ->where('is_active', true)
                             ->first();
        
        if (!$classroom) {
            return back()->withErrors(['class_code' => 'Código de clase inválido o aula inactiva']);
        }

        $user = auth()->user();
        
        // Solo estudiantes pueden unirse mediante código
        if ($user->role !== 'student') {
            return back()->withErrors(['class_code' => 'Solo los estudiantes pueden unirse mediante código']);
        }

        $classroomIds = $user->classroom_ids ?? [];
        
        // Verificar si ya está inscrito
        if (in_array($classroom->id, $classroomIds)) {
            return redirect()->route('teacher.classrooms.show', $classroom)
                           ->with('info', 'Ya estás inscrito en esta aula');
        }

        // Agregar al estudiante
        $classroomIds[] = $classroom->id;
        $user->update(['classroom_ids' => $classroomIds]);
        
        // Agregar a la lista de estudiantes del aula
        $studentIds = $classroom->student_ids ?? [];
        if (!in_array($user->id, $studentIds)) {
            $studentIds[] = $user->id;
            $classroom->update(['student_ids' => $studentIds]);
        }

        // Crear registro inicial de puntos
        StudentPoint::firstOrCreate([
            'student_id' => $user->id,
            'classroom_id' => $classroom->id
        ], [
            'total_points' => 0,
            'level' => 1,
            'experience_points' => 0,
            'points_spent' => 0,
            'streak_days' => 0,
            'achievements' => [],
            'last_activity' => null
        ]);

        return redirect()->route('teacher.classrooms.show', $classroom)
                        ->with('success', 'Te has unido al aula exitosamente');
    }

    public function regenerateCode(Request $request, Classroom $classroom)
    {
        // Solo el profesor propietario puede regenerar el código
        if (auth()->user()->role !== 'teacher' || $classroom->teacher_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos.'], 403);
        }

        $classroom->update([
            'class_code' => $this->generateUniqueClassCode()
        ]);

        return response()->json([
            'success' => true,
            'new_code' => $classroom->class_code,
            'message' => 'Código regenerado exitosamente'
        ]);
    }

    public function removeStudent(Request $request, Classroom $classroom)
    {
        // Solo el profesor propietario puede remover estudiantes
        if (auth()->user()->role !== 'teacher' || $classroom->teacher_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos.'], 403);
        }

        $request->validate([
            'student_id' => 'required|string|exists:users,_id'
        ]);

        $studentId = $request->student_id;

        // Remover de la lista del aula
        $studentIds = array_filter($classroom->student_ids ?? [], function($id) use ($studentId) {
            return $id !== $studentId;
        });
        $classroom->update(['student_ids' => array_values($studentIds)]);

        // Remover de la lista del estudiante
        $student = User::find($studentId);
        if ($student) {
            $classroomIds = array_filter($student->classroom_ids ?? [], function($id) use ($classroom) {
                return $id !== $classroom->id;
            });
            $student->update(['classroom_ids' => array_values($classroomIds)]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Estudiante removido exitosamente'
        ]);
    }

    /**
     * Mostrar reportes del aula
     */
    public function reports(Classroom $classroom)
    {
        // Verificar permisos
        $user = auth()->user();
        if ($user->role === 'teacher' && $classroom->teacher_id !== $user->id) {
            abort(403, 'No tienes acceso a esta aula.');
        }

        // Redirigir al controlador especializado
        $studentBehaviorController = new \App\Http\Controllers\Teacher\StudentBehaviorController();
        return $studentBehaviorController->reports(request(), $classroom);
    }

    /**
     * Exportar reportes
     */
    public function exportReports(Request $request, Classroom $classroom)
    {
        // Verificar permisos
        $user = auth()->user();
        if ($user->role === 'teacher' && $classroom->teacher_id !== $user->id) {
            abort(403, 'No tienes acceso a esta aula.');
        }

        // Redirigir al controlador especializado
        $studentBehaviorController = new \App\Http\Controllers\Teacher\StudentBehaviorController();
        return $studentBehaviorController->exportReports($request, $classroom);
    }

    /**
     * Mostrar formulario de importación de estudiantes
     */
    public function importStudentsForm(Classroom $classroom)
    {
        // Verificar permisos
        if (auth()->user()->role !== 'teacher' || $classroom->teacher_id !== auth()->id()) {
            abort(403, 'No tienes permisos para importar estudiantes a esta aula.');
        }

        return view('teacher.classrooms.import-students', compact('classroom'));
    }

    /**
     * Procesar importación de estudiantes desde Excel/CSV
     */
    public function importStudents(Request $request, Classroom $classroom)
    {
        // Verificar permisos
        if (auth()->user()->role !== 'teacher' || $classroom->teacher_id !== auth()->id()) {
            abort(403, 'No tienes permisos para importar estudiantes a esta aula.');
        }

        $request->validate([
            'excel_file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ]);
        \Log::info('TEST - Método importStudents iniciado correctamente');

        try {
    file_put_contents(storage_path('logs/laravel.log'), '[' . date('Y-m-d H:i:s') . '] TEST: Importación iniciada' . PHP_EOL, FILE_APPEND);
    $file = $request->file('excel_file');
            
            // Guardar archivo
            
            $fileName = time() . '_estudiantes.' . $file->getClientOriginalExtension();
            $fullPath = storage_path('app/temp/' . $fileName);
            
            // Crear carpeta temp si no existe
            if (!is_dir(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0777, true);
            }
            
            $file->move(storage_path('app/temp'), $fileName);
\Log::emergency('TEST DE LOG - ESTO DEBERÍA APARECER SIEMPRE');
            // Leer archivo (CSV o Excel)
            \Log::info('=== ANTES DE LEER ARCHIVO ===');
            $data = $this->readExcelFileAdvanced($fullPath);
            \Log::info('=== DESPUÉS DE LEER ARCHIVO ===');
            
            if (empty($data)) {
                return back()->with('error', 'No se encontraron datos válidos en el archivo. Verifica que el formato sea correcto: Nombre, Email, Contraseña en columnas separadas.');
            }
            
            // Procesar datos
            $result = $this->processStudentsData($data, $classroom);
            
            // Limpiar archivo temporal
            unlink($fullPath);

            return redirect()->route('teacher.classrooms.show', $classroom)
                            ->with('success', 
                                "✅ Importación completada exitosamente!\n\n" . 
                                "📊 Resumen:\n" .
                                "• Estudiantes agregados: {$result['added']}\n" . 
                                "• Ya existían (saltados): {$result['skipped']}\n" . 
                                "• Errores: {$result['errors']}"
                            );

        } catch (\Exception $e) {
            \Log::error('Error en importación: ' . $e->getMessage());
            return back()->with('error', 'Error al procesar el archivo: ' . $e->getMessage() . '\n\nVerifica que el archivo tenga el formato correcto con columnas: Nombre | Email | Contraseña');
        }
    }

    /**
     * Descargar plantilla de Excel mejorada para estudiantes
     */
    public function downloadStudentsTemplate()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <?mso-application progid="Excel.Sheet"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:o="urn:schemas-microsoft-com:office:office"
         xmlns:x="urn:schemas-microsoft-com:office:excel"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:html="http://www.w3.org/TR/REC-html40">
         <Styles>
          <Style ss:ID="Header">
           <Font ss:Bold="1" ss:Color="#FFFFFF" ss:Size="12"/>
           <Interior ss:Color="#3B82F6" ss:Pattern="Solid"/>
           <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
           </Borders>
          </Style>
          <Style ss:ID="Data">
           <Font ss:Size="11"/>
           <Alignment ss:Vertical="Center"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
          <Style ss:ID="Example">
           <Font ss:Color="#666666" ss:Italic="1" ss:Size="10"/>
           <Interior ss:Color="#F3F4F6" ss:Pattern="Solid"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
         </Styles>
         <Worksheet ss:Name="Estudiantes">
          <Table>
           <Column ss:Width="250"/>
           <Column ss:Width="300"/>
           <Column ss:Width="150"/>
           <Row ss:StyleID="Header" ss:Height="30">
            <Cell><Data ss:Type="String">Nombre Completo</Data></Cell>
            <Cell><Data ss:Type="String">Correo Electrónico</Data></Cell>
            <Cell><Data ss:Type="String">Contraseña</Data></Cell>
           </Row>
           <Row ss:StyleID="Example" ss:Height="25">
            <Cell><Data ss:Type="String">Ana García Martínez</Data></Cell>
            <Cell><Data ss:Type="String">ana.garcia@colegio.edu</Data></Cell>
            <Cell><Data ss:Type="String">ana123</Data></Cell>
           </Row>
           <Row ss:StyleID="Example" ss:Height="25">
            <Cell><Data ss:Type="String">Carlos López Rodríguez</Data></Cell>
            <Cell><Data ss:Type="String">carlos.lopez@colegio.edu</Data></Cell>
            <Cell><Data ss:Type="String">carlos456</Data></Cell>
           </Row>
           <Row ss:StyleID="Example" ss:Height="25">
            <Cell><Data ss:Type="String">María Fernández Silva</Data></Cell>
            <Cell><Data ss:Type="String">maria.fernandez@colegio.edu</Data></Cell>
            <Cell><Data ss:Type="String">maria789</Data></Cell>
           </Row>
           <Row ss:StyleID="Data" ss:Height="25">
            <Cell><Data ss:Type="String"></Data></Cell>
            <Cell><Data ss:Type="String"></Data></Cell>
            <Cell><Data ss:Type="String"></Data></Cell>
           </Row>
           <Row ss:StyleID="Data" ss:Height="25">
            <Cell><Data ss:Type="String"></Data></Cell>
            <Cell><Data ss:Type="String"></Data></Cell>
            <Cell><Data ss:Type="String"></Data></Cell>
           </Row>
           <Row ss:StyleID="Data" ss:Height="25">
            <Cell><Data ss:Type="String"></Data></Cell>
            <Cell><Data ss:Type="String"></Data></Cell>
            <Cell><Data ss:Type="String"></Data></Cell>
           </Row>
           <Row ss:StyleID="Data" ss:Height="25">
            <Cell><Data ss:Type="String"></Data></Cell>
            <Cell><Data ss:Type="String"></Data></Cell>
            <Cell><Data ss:Type="String"></Data></Cell>
           </Row>
           <Row ss:StyleID="Data" ss:Height="25">
            <Cell><Data ss:Type="String"></Data></Cell>
            <Cell><Data ss:Type="String"></Data></Cell>
            <Cell><Data ss:Type="String"></Data></Cell>
           </Row>
          </Table>
         </Worksheet>
        </Workbook>';

        $filename = "📚_Plantilla_Estudiantes_" . now()->format('Y-m-d_H-i') . '.xls';
        
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
     * Leer archivo Excel usando PhpSpreadsheet
     */
    private function readExcelFileAdvanced($filePath)
{
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    \Log::info('=== DEBUGGING EXCEL ===');
    \Log::info('Archivo: ' . $filePath);
    \Log::info('Extensión detectada: ' . $extension);
    \Log::info('Archivo existe: ' . (file_exists($filePath) ? 'SÍ' : 'NO'));
    
    if (strtolower($extension) === 'csv') {
        \Log::info('Usando lector CSV');
        return $this->readCSVFileSimple($filePath);
    }
    
    \Log::info('Intentando usar PhpSpreadsheet para Excel');
    
    try {
        \Log::info('Creando reader...');
        $reader = IOFactory::createReader('Xlsx');
        \Log::info('Reader creado exitosamente');
        
        \Log::info('Cargando archivo...');
        $spreadsheet = $reader->load($filePath);
        \Log::info('Archivo cargado exitosamente');
        
        $worksheet = $spreadsheet->getActiveSheet();
        \Log::info('Worksheet obtenido');
        
        $rows = $worksheet->toArray();
        \Log::info('Excel leído - Total filas: ' . count($rows));
        \Log::info('Primeras 3 filas: ' . json_encode(array_slice($rows, 0, 3)));
        
        $data = [];
        $startRow = 0;
        
        // Detectar encabezados
        if (!empty($rows) && count($rows) > 1) {
            $firstRow = $rows[0];
            if (stripos($firstRow[0] ?? '', 'nombre') !== false || 
                stripos($firstRow[1] ?? '', 'correo') !== false) {
                $startRow = 1;
                \Log::info('Encabezados detectados, empezando desde fila 2');
            }
        }
        
        // Procesar filas
        for ($i = $startRow; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (count($row) >= 2 && !empty(trim($row[0] ?? '')) && !empty(trim($row[1] ?? ''))) {
                $data[] = [
                    'name' => trim($row[0]),
                    'email' => trim($row[1]),
                    'password' => isset($row[2]) && !empty(trim($row[2])) ? trim($row[2]) : 'student123'
                ];
            }
        }
        
        \Log::info('Datos procesados: ' . count($data) . ' estudiantes');
        return $data;
        
    } catch (\Exception $e) {
        \Log::error('Error leyendo Excel: ' . $e->getMessage());
        \Log::info('Fallback a CSV...');
        return $this->readCSVFileSimple($filePath);
    }
}

    /**
     * Leer archivo CSV simple
     */
    private function readCSVFileSimple($filePath)
    {
        $data = [];
        
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($row) >= 2 && !empty(trim($row[0])) && !empty(trim($row[1]))) {
                    $data[] = [
                        'name' => trim($row[0]),
                        'email' => trim($row[1]),
                        'password' => isset($row[2]) && !empty(trim($row[2])) ? trim($row[2]) : 'student123'
                    ];
                }
            }
            fclose($handle);
        }
        
        return $data;
    }

    /**
     * Procesar datos de estudiantes
     */
    private function processStudentsData($data, $classroom)
    {
        $added = 0;
        $skipped = 0;
        $errors = 0;
        
        foreach ($data as $index => $row) {
            try {
                // Validar datos requeridos
                if (empty($row['name']) || empty($row['email'])) {
                    $errors++;
                    continue;
                }
                
                // Verificar si el usuario ya existe
                $existingUser = User::where('email', $row['email'])->first();
                
                if ($existingUser) {
                    // Si ya existe, verificar si está en el aula
                    $classroomIds = $existingUser->classroom_ids ?? [];
                    if (!in_array($classroom->id, $classroomIds)) {
                        // Agregar al aula si no está
                        $classroomIds[] = $classroom->id;
                        $existingUser->update(['classroom_ids' => $classroomIds]);
                        
                        // Agregar a la lista de estudiantes del aula
                        $studentIds = $classroom->student_ids ?? [];
                        if (!in_array($existingUser->id, $studentIds)) {
                            $studentIds[] = $existingUser->id;
                            $classroom->update(['student_ids' => $studentIds]);
                        }
                        
                        // Crear registro inicial de puntos
                        StudentPoint::updateOrCreate([
                            'student_id' => $existingUser->id,
                            'classroom_id' => $classroom->id
                        ], [
                            'total_points' => 0,
                            'level' => 1,
                            'experience_points' => 0,
                            'points_spent' => 0,
                            'streak_days' => 0,
                            'achievements' => [],
                            'last_activity' => now()
                        ]);
                        
                        $added++;
                    } else {
                        $skipped++;
                    }
                    continue;
                }
                
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => bcrypt($row['password']),
                    'role' => 'student',
                    'classroom_ids' => [$classroom->id],
                    'email_verified_at' => now(),
                    'is_active' => true
                ]);
                
                // Agregar a la lista de estudiantes del aula
                $studentIds = $classroom->student_ids ?? [];
                $studentIds[] = $user->id;
                $classroom->update(['student_ids' => $studentIds]);
                
                // Crear registro inicial de puntos
                StudentPoint::create([
                    'student_id' => $user->id,
                    'classroom_id' => $classroom->id,
                    'total_points' => 0,
                    'level' => 1,
                    'experience_points' => 0,
                    'points_spent' => 0,
                    'streak_days' => 0,
                    'achievements' => [],
                    'last_activity' => now()
                ]);
                
                $added++;
                
            } catch (\Exception $e) {
                $errors++;
                \Log::error("Error importing student {$index}: " . $e->getMessage(), [
                    'student_data' => $row,
                    'exception' => $e->getTraceAsString()
                ]);
            }
        }
        
        return [
            'added' => $added,
            'skipped' => $skipped,
            'errors' => $errors
        ];
    }

    /**
     * Agregar/quitar puntos manualmente a un estudiante
     */
    public function adjustStudentPoints(Request $request, Classroom $classroom)
    {
        // Verificar permisos
        if (auth()->user()->role !== 'teacher' || $classroom->teacher_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos.'], 403);
        }

        $request->validate([
            'student_id' => 'required|string|exists:users,_id',
            'points' => 'required|integer|min:-1000|max:1000',
            'reason' => 'nullable|string|max:500'
        ]);

        try {
            // Verificar que el estudiante esté en el aula
            if (!in_array($request->student_id, $classroom->student_ids ?? [])) {
                return response()->json(['success' => false, 'message' => 'El estudiante no pertenece a esta aula.'], 400);
            }

            // Crear registro de comportamiento manual
            $studentBehavior = StudentBehavior::create([
                'student_id' => $request->student_id,
                'behavior_id' => null, // Comportamiento manual
                'classroom_id' => $classroom->id,
                'points_awarded' => $request->points,
                'date' => now(),
                'notes' => $request->reason ?? 'Ajuste manual de puntos por el profesor',
                'awarded_by' => auth()->id(),
                'is_approved' => true,
                'is_manual' => true
            ]);

            // Actualizar puntos del estudiante
            $studentPoint = StudentPoint::where('student_id', $request->student_id)
                                       ->where('classroom_id', $classroom->id)
                                       ->first();

            if ($studentPoint) {
                $newTotal = max(0, $studentPoint->total_points + $request->points);
                $newLevel = floor($newTotal / 100) + 1;

                $studentPoint->update([
                    'total_points' => $newTotal,
                    'level' => $newLevel,
                    'experience_points' => $newTotal,
                    'last_activity' => now()
                ]);
            }

            $student = User::find($request->student_id);

            return response()->json([
                'success' => true,
                'message' => 'Puntos ajustados exitosamente',
                'student_name' => $student->name,
                'points_change' => $request->points,
                'new_total' => $studentPoint->total_points ?? 0
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al ajustar puntos: ' . $e->getMessage()], 500);
        }
    }
}
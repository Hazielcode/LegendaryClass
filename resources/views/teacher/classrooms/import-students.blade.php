@extends('layouts.app')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
    
    .epic-card {
        backdrop-filter: blur(15px);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 50%, rgba(255, 255, 255, 0.95) 100%);
        border: 2px solid rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 0 20px rgba(59, 130, 246, 0.1), inset 0 1px 0 rgba(255, 255, 255, 1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .epic-title {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        color: #1f2937;
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
    }

    .epic-button {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-family: 'Cinzel', serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .epic-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        text-decoration: none;
        color: white;
    }

    .epic-button.green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .epic-button.green:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .epic-button.purple {
        background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
    }

    .epic-button.purple:hover {
        background: linear-gradient(135deg, #5b21b6 0%, #4c1d95 100%);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
        color: white;
    }

    .dashboard-bg {
        background: url('/fondo.png') center/cover;
        min-height: 100vh;
        position: relative;
    }

    .dashboard-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
        z-index: 1;
    }

    .dashboard-content {
        position: relative;
        z-index: 2;
    }

    .upload-zone {
        border: 3px dashed #3b82f6;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        transition: all 0.3s ease;
    }

    .upload-zone:hover {
        border-color: #1d4ed8;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.1) 100%);
    }

    .upload-zone.dragover {
        border-color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.1) 100%);
    }

    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .instructions {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.05) 100%);
        border: 2px solid rgba(245, 158, 11, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="dashboard-bg">
    <div class="dashboard-content py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="epic-card p-6 mb-8">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-4xl font-bold epic-title mb-2" style="font-family: 'Cinzel Decorative', serif;">
                            📊 Importar Estudiantes
                        </h1>
                        <p class="text-lg epic-title text-blue-600">{{ $classroom->name }} • {{ $classroom->subject }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
                           class="epic-button text-sm py-2 px-4">
                            ← Volver al Aula
                        </a>
                    </div>
                </div>
            </div>

            <!-- Instrucciones -->
            <div class="epic-card p-6 mb-8">
                <h2 class="text-2xl font-bold epic-title mb-4 flex items-center">
                    <span class="text-3xl mr-3">📋</span>
                    Instrucciones
                </h2>
                <div class="instructions">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-bold text-lg mb-3 text-yellow-800">📝 Formato del archivo:</h3>
                            <ul class="space-y-2 text-sm">
                                <li>• <strong>Formato:</strong> CSV (.csv)</li>
                                <li>• <strong>Columnas requeridas:</strong></li>
                                <li class="ml-4">- Nombre Completo</li>
                                <li class="ml-4">- Correo Electrónico</li>
                                <li class="ml-4">- Contraseña</li>
                                <li>• <strong>Sin encabezados</strong> en la primera fila</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-3 text-yellow-800">⚠️ Importante:</h3>
                            <ul class="space-y-2 text-sm">
                                <li>• Si el estudiante ya existe, se saltará</li>
                                <li>• Las contraseñas se encriptarán automáticamente</li>
                                <li>• Los estudiantes deberán elegir su personaje al ingresar</li>
                                <li>• Puedes ajustar puntos manualmente después</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('teacher.classrooms.download-template') }}" 
                           class="epic-button purple text-sm py-2 px-4">
                            📥 Descargar Plantilla de Ejemplo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Formulario de carga -->
            <div class="epic-card p-6">
                <h2 class="text-2xl font-bold epic-title mb-6 flex items-center">
                    <span class="text-3xl mr-3">📤</span>
                    Subir Archivo de Estudiantes
                </h2>
                
                <form action="{{ route('teacher.classrooms.import-students', $classroom) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      id="importForm">
                    @csrf
                    
                    <div class="upload-zone mb-6" id="uploadZone">
                        <input type="file" 
                               name="excel_file" 
                               id="excelFile" 
                               class="file-input"
                               accept=".csv,.xlsx,.xls"
                               required>
                        
                        <div class="upload-content">
                            <div class="text-6xl mb-4">📁</div>
                            <h3 class="text-xl font-bold epic-title mb-2">
                                Arrastra tu archivo aquí o haz clic para seleccionar
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Formatos soportados: CSV, Excel (.xlsx, .xls)
                            </p>
                            <div class="epic-button" style="pointer-events: none;">
                                Seleccionar Archivo
                            </div>
                        </div>
                    </div>

                    <div id="fileInfo" class="hidden mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">✅</span>
                            <div>
                                <p class="font-semibold text-green-800">Archivo seleccionado:</p>
                                <p id="fileName" class="text-green-600"></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center gap-4">
                        <button type="submit" 
                                class="epic-button green text-lg py-3 px-8"
                                id="submitBtn"
                                disabled>
                            📊 Importar Estudiantes
                        </button>
                        
                        <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
                           class="epic-button text-lg py-3 px-8">
                            ❌ Cancelar
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('excelFile');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const submitBtn = document.getElementById('submitBtn');

        // Eventos de drag and drop
        uploadZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect();
            }
        });

        // Evento de selección de archivo
        fileInput.addEventListener('change', handleFileSelect);

        function handleFileSelect() {
            const file = fileInput.files[0];
            if (file) {
                fileName.textContent = file.name;
                fileInfo.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50');
            } else {
                fileInfo.classList.add('hidden');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50');
            }
        }

        // Validación del formulario
        document.getElementById('importForm').addEventListener('submit', function(e) {
            if (!fileInput.files[0]) {
                e.preventDefault();
                alert('Por favor selecciona un archivo para importar.');
                return;
            }

            const file = fileInput.files[0];
            const validExtensions = ['csv', 'xlsx', 'xls'];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            if (!validExtensions.includes(fileExtension)) {
                e.preventDefault();
                alert('Por favor selecciona un archivo válido (CSV, Excel).');
                return;
            }

            if (file.size > 2 * 1024 * 1024) { // 2MB
                e.preventDefault();
                alert('El archivo es demasiado grande. Máximo 2MB.');
                return;
            }

            // Mostrar indicador de carga
            submitBtn.textContent = '⏳ Procesando...';
            submitBtn.disabled = true;
        });

        // Inicializar estado del botón
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50');
    });
</script>
@endsection
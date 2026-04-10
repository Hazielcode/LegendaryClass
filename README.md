# 🏰 LegendaryClass - Sistema de Gamificación Educativa Épica

[![Laravel](https://img.shields.io/badge/Laravel-11.0-red?style=for-the-badge&logo=laravel)](https://laravel.com)
[![MongoDB](https://img.shields.io/badge/MongoDB-4.0+-green?style=for-the-badge&logo=mongodb)](https://mongodb.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.2-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![AlpineJS](https://img.shields.io/badge/AlpineJS-3.4-8BC0D0?style=for-the-badge&logo=alpine.js)](https://alpinejs.dev)

## Integrantes del grupo
- **Aguirre Saavedra Juan Alexis**
- **Alfonso Solorzano Samir Haziel**
- **Galvan Morales Luis Enrique**
- **Galvan Guerrero Matias**

## 🎯 Descripción

**LegendaryClass** es un sistema avanzado de gamificación educativa que transforma las aulas tradicionales en experiencias épicas de aprendizaje. Inspirado en plataformas como ClassDojo y Classcraft, permite a los educadores crear ambientes de aprendizaje inmersivos donde los estudiantes se convierten en aventureros en su viaje educativo.

### ✨ Características Principales

- 🎮 **Gamificación Completa**: Sistema de niveles, experiencia, logros y evoluciones
- 👑 **Multi-Role**: Director, Maestros, Estudiantes y Padres
- ⚔️ **Personajes Épicos**: 5 clases de aventureros con habilidades únicas
- 🌟 **Sistema de Evolución**: 4 tiers de evolución con animaciones cinematográficas
- 🏆 **Logros y Recompensas**: Sistema completo de motivación y reconocimiento
- 📊 **Analytics Avanzados**: Reportes detallados y estadísticas en tiempo real
- 🛒 **Tienda Legendaria**: Sistema de puntos y recompensas canjeables
- 📱 **Responsive Design**: Funciona perfectamente en todos los dispositivos
- 📈 **Importación Excel**: Carga masiva de estudiantes desde archivos Excel/CSV
- ⚡ **Experiencia en Tiempo Real**: Sistema dinámico de XP y niveles

---

## 🛠️ Stack Tecnológico

### Backend
- **PHP 8.2+** - Lenguaje principal
- **Laravel 11.0** - Framework PHP moderno
- **MongoDB 4.0+** - Base de datos NoSQL escalable
- **Laravel-MongoDB 4.0** - ODM para integración MongoDB

### Frontend
- **Blade Templates** - Motor de plantillas nativo
- **TailwindCSS 3.2** - Framework CSS utilitario
- **AlpineJS 3.4** - Framework JavaScript reactivo
- **Cinzel & Playfair Display** - Tipografías épicas

### Librerías Especializadas
- **Laravel Breeze** - Sistema de autenticación
- **Intervention Image 3.0** - Manipulación de imágenes
- **PhpSpreadsheet 4.4** - Procesamiento de archivos Excel
- **Maatwebsite/Excel 1.1** - Importación/exportación Excel

---

## ⚙️ Requisitos del Sistema

### Requisitos Mínimos
- **PHP**: 8.2 o superior con extensiones:
  - `mongodb` - Conexión a MongoDB
  - `zip` - Compresión de archivos
  - `curl` - Peticiones HTTP
  - `mbstring` - Manipulación de cadenas
  - `xml` - Procesamiento XML
- **Composer**: 2.0+
- **MongoDB**: 4.0+
- **Node.js**: 18.0+ (para compilar assets)
- **NPM**: 8.0+

### Requisitos Recomendados
- **PHP**: 8.3
- **MongoDB**: 6.0+
- **RAM**: 4GB+ para desarrollo, 8GB+ para producción
- **Almacenamiento**: 2GB libres

### Sistemas Operativos Soportados
- ✅ Windows 10/11 (con XAMPP/Laragon)
- ✅ macOS 10.15+
- ✅ Ubuntu 20.04+
- ✅ Linux (distribuciones principales)

---

## 🚀 Instalación Paso a Paso

### 1. Preparar el Entorno de Desarrollo

#### Windows (XAMPP Recomendado)
```bash
# 1. Descargar XAMPP 8.2+ desde https://www.apachefriends.org/
# 2. Instalar y ejecutar Apache
# 3. Instalar MongoDB siguiendo: https://docs.mongodb.com/manual/tutorial/install-mongodb-on-windows/

# Verificar PHP
php --version
# Debe mostrar PHP 8.2+

# Instalar extensión MongoDB para PHP
# Descargar desde: https://pecl.php.net/package/mongodb
# Agregar a php.ini: extension=mongodb
```

#### Linux/macOS
```bash
# Ubuntu/Debian
sudo apt update
sudo apt install php8.2 php8.2-mongodb php8.2-zip php8.2-curl php8.2-mbstring php8.2-xml

# macOS (con Homebrew)
brew install php@8.2 mongodb/brew/mongodb-community
brew services start mongodb-community

# Instalar Composer globalmente
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 2. Clonar y Configurar el Proyecto
```bash
# Clonar repositorio
git clone https://github.com/tu-usuario/legendaryclass.git
cd legendaryclass

# Instalar dependencias PHP
composer install

# Instalar dependencias Node.js
npm install

# Copiar variables de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 3. Configurar Base de Datos

#### Configuración del .env
```env
APP_NAME="LegendaryClass"
APP_ENV=local
APP_KEY=base64:tu-clave-generada
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de datos MongoDB
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=legendaryclass_db
DB_USERNAME=
DB_PASSWORD=

# Configuraciones de gamificación
GAMIFICATION_POINTS_PER_LEVEL=100
GAMIFICATION_MAX_LEVEL=100
GAMIFICATION_ENABLE_SOUNDS=true
GAMIFICATION_AUTO_APPROVE_REWARDS=false

# Configuraciones de aula
DEFAULT_LEADERBOARD_PUBLIC=false
DEFAULT_STUDENT_REWARDS=true
DEFAULT_PARENT_NOTIFICATIONS=true
```

### 4. Poblar Base de Datos
```bash
# Ejecutar seeders (crea usuarios de prueba)
php artisan db:seed

# Ver credenciales creadas
php artisan db:seed --class=DatabaseSeeder
```

### 5. Compilar Assets
```bash
# Para desarrollo
npm run dev

# Para producción
npm run build

# Limpiar caché (si es necesario)
npm run fresh
```

### 6. Iniciar el Servidor
```bash
# Servidor de desarrollo
php artisan serve

# El sistema estará disponible en: http://localhost:8000
```

---

## 👥 Credenciales de Acceso

### 🎯 **Credenciales Principales**

| Rol | Email | Contraseña | Usuario | Permisos |
|-----|-------|------------|---------|----------|
| 👑 **Director Imperial** | `director@edugamification.com` | `director123` | Juan Aguirre | Control total del sistema |
| 🧙‍♂️ **Maestro Sabio** | `profesor@demo.com` | `password` | Luis Galvan | Gestión de aulas y estudiantes |
| ⚔️ **Estudiante Aventurero** | `samir@demo.com` | `password` | Samir Alfonso | Participación gamificada |
| 🛡️ **Padre Guardián** | `padre1@edugamification.com` | `padre123` | Roberto Sánchez | Seguimiento de hijos |

### 📋 **Credenciales Adicionales**

#### 👨‍🏫 **Otros Profesores**
| Email | Contraseña | Usuario | Especialidad |
|-------|------------|---------|-------------|
| `profesor1@edugamification.com` | `profesor123` | Carlos Ramírez | 5to Grado |
| `profesor2@edugamification.com` | `profesor123` | Ana Flores | 3er Grado |

#### 👩‍🎓 **Otros Estudiantes**
| Email | Contraseña | Usuario | Personaje | Nivel |
|-------|------------|---------|-----------|-------|
| `juan@demo.com` | `password` | Juan Carlos López | Guerrero Valiente ⚔️ | 2 |
| `maria@demo.com` | `password` | María Isabel Torres | Ninja Ágil 🥷 | 3 |
| `carlos@demo.com` | `password` | Carlos Eduardo Ruiz | Arquero Preciso 🏹 | 6 |
| `estudiante1@edugamification.com` | `estudiante123` | Pedro Sánchez | Lanzador Creativo 🪄 | 2 |
| `estudiante2@edugamification.com` | `estudiante123` | Lucía Torres | Mago Sabio 🧙‍♀️ | 5 |

---

## 🎮 Sistema de Gamificación

### ⚔️ **Clases de Personajes**

#### 🧙‍♂️ **Mago Sabio**
- **Bonus**: +20% XP en actividades de conocimiento
- **Especialidad**: Tareas académicas, lecturas, estudios
- **Estadísticas**: Inteligencia ⭐⭐⭐⭐⭐, Sabiduría ⭐⭐⭐⭐⭐
- **Archivo**: `images/characters/mage_tier_1.png` a `mage_tier_4.png`

#### ⚔️ **Guerrero Valiente**
- **Bonus**: +20% XP en proyectos desafiantes
- **Especialidad**: Proyectos difíciles, desafíos, persistencia
- **Estadísticas**: Fuerza ⭐⭐⭐⭐⭐, Resistencia ⭐⭐⭐⭐⭐
- **Archivo**: `images/characters/warrior_tier_1.png` a `warrior_tier_4.png`

#### 🥷 **Ninja Ágil**
- **Bonus**: +20% XP en entregas rápidas
- **Especialidad**: Participación rápida, velocidad, reflejos
- **Estadísticas**: Agilidad ⭐⭐⭐⭐⭐, Precisión ⭐⭐⭐⭐
- **Archivo**: `images/characters/ninja_tier_1.png` a `ninja_tier_4.png`

#### 🏹 **Arquero Preciso**
- **Bonus**: +20% XP en trabajos detallados
- **Especialidad**: Atención al detalle, precisión, perfección
- **Estadísticas**: Precisión ⭐⭐⭐⭐⭐, Concentración ⭐⭐⭐⭐⭐
- **Archivo**: `images/characters/archer_tier_1.png` a `archer_tier_4.png`

#### 🪄 **Lanzador Creativo**
- **Bonus**: +20% XP en proyectos creativos
- **Especialidad**: Arte, innovación, originalidad
- **Estadísticas**: Creatividad ⭐⭐⭐⭐⭐, Innovación ⭐⭐⭐⭐⭐
- **Archivo**: `images/characters/launcher_tier_1.png` a `launcher_tier_4.png`

### 🌟 **Sistema de Evolución**

#### **Tier 1 - Novato** (Nivel 1-24)
- Primera forma del personaje
- Habilidades básicas
- Bonus estándar

#### **Tier 2 - Veterano** (Nivel 25-49)
- 🎬 **Animación épica de evolución** (5 segundos)
- Nueva apariencia visual mejorada
- +50 puntos de bonificación
- Habilidades especiales desbloqueadas

#### **Tier 3 - Épico** (Nivel 50-74)
- 🎬 **Secuencia cinematográfica** con efectos especiales
- Forma avanzada del personaje
- +100 puntos de bonificación
- Nuevas habilidades únicas

#### **Tier 4 - Legendario** (Nivel 75+)
- 🎬 **Evolución legendaria** con partículas y efectos
- Forma final y más poderosa
- +150 puntos de bonificación
- Máximo poder alcanzado

### 📈 **Sistema de Experiencia**

#### **Fórmula de Cálculo**
```php
// Nivel = √(XP / 100) + 1
public function calculateLevel($xp) {
    return (int) floor(sqrt($xp / 100)) + 1;
}
```

#### **Tabla de Progresión**
| Nivel | XP Requerido | XP Acumulado | Tier | Bonus |
|-------|-------------|--------------|------|-------|
| 1 | 0-99 | 0 | Novato | - |
| 5 | 1600-2499 | 1600 | Novato | - |
| 10 | 8100-9999 | 8100 | Novato | - |
| 25 | 57600-67599 | 57600 | **Veterano** 🌟 | +50 pts |
| 50 | 245025-254999 | 245025 | **Épico** ⭐ | +100 pts |
| 75 | 562500-574399 | 562500 | **Legendario** 💎 | +150 pts |

### 💪 **Sistema de Estadísticas Mejorables**

#### **6 Estadísticas Disponibles**
- **💪 Fuerza**: Fortaleza física y mental
- **🧠 Inteligencia**: Capacidad de aprendizaje
- **⚡ Agilidad**: Velocidad y reflejos
- **🎨 Creatividad**: Imaginación y arte
- **👑 Liderazgo**: Capacidad de liderar
- **🛡️ Resistencia**: Perseverancia

#### **Mecánicas de Upgrade**
- **Costo**: 5 puntos 💎 por mejora
- **Incremento**: +1 por upgrade
- **Límite máximo**: 50 por estadística
- **Efectos visuales**: Barras con animación shimmer

---

## 🏛️ Estructura del Proyecto

### 📁 **Arquitectura del Código**

```
LegendaryClass/
├── app/
│   ├── Http/Controllers/
│   │   ├── Director/
│   │   │   └── DirectorController.php       # Panel imperial
│   │   ├── Teacher/
│   │   │   ├── ClassroomController.php      # Gestión de aulas
│   │   │   ├── BehaviorController.php       # Comportamientos
│   │   │   └── RewardController.php         # Recompensas
│   │   ├── Student/
│   │   │   ├── StudentsController.php       # Dashboard épico
│   │   │   └── CharacterController.php      # Personajes
│   │   └── Parent/
│   │       └── ParentController.php         # Panel padres
│   ├── Models/
│   │   ├── User.php                         # Usuario con personajes
│   │   ├── Classroom.php                    # Aulas mágicas
│   │   ├── Behavior.php                     # Comportamientos
│   │   ├── Reward.php                       # Recompensas
│   │   ├── StudentBehavior.php              # Actividades
│   │   └── StudentPoint.php                 # Sistema de puntos
│   └── Http/Middleware/
│       └── CheckRole.php                    # Control de roles
├── resources/views/
│   ├── students/dashboard.blade.php         # Dashboard épico
│   ├── teacher/classrooms/                  # Gestión de aulas
│   ├── director/                            # Panel director
│   └── layouts/app.blade.php               # Layout principal
├── public/images/
│   ├── characters/                          # Personajes por tier
│   ├── escudos/                            # Escudos por clase
│   └── fondo.png                           # Fondo épico
├── database/seeders/
│   ├── DatabaseSeeder.php                  # Seeder principal
│   └── LegendaryClassCompleteSeeder.php    # Datos completos
└── routes/web.php                          # Rutas del sistema
```

### 🗄️ **Modelos Principales**

#### **User (Modelo Principal)**
```php
// Campos del sistema de personajes
'character_class'           // Nombre del personaje
'character_icon'            // Emoji del personaje  
'character_type'            // Tipo interno (mage, warrior, etc.)
'character_bonus_type'      // Tipo de bonus
'experience_points'         // Puntos de experiencia
'level'                     // Nivel actual
'points'                    // Puntos disponibles

// Estadísticas mejorables (1-50)
'strength', 'intelligence', 'agility'
'creativity', 'leadership', 'resilience'

// Contadores de progreso
'achievements_count', 'quests_completed'
'rewards_earned', 'homework_completed'
```

#### **Classroom (Aulas Mágicas)**
```php
'name'          // Nombre del aula
'class_code'    // Código único de acceso
'teacher_id'    // ID del profesor
'student_ids'   // Array de estudiantes
'subject'       // Materia
'grade_level'   // Grado/Nivel
'settings'      // Configuraciones
```

---

## 🚀 Funcionalidades por Rol

### 👑 **Director Imperial**

#### **Dashboard de Control**
- 📊 **Estadísticas Globales**: Usuarios, aulas, actividad
- 📈 **Métricas en Tiempo Real**: Comportamientos, puntos
- 👥 **Gestión de Usuarios**: CRUD completo
- 🏰 **Supervisión de Aulas**: Monitoreo total
- 📋 **Reportes Avanzados**: Analytics completos

#### **Rutas Principales**
```php
Route::prefix('director')->group(function () {
    Route::get('/dashboard', [DirectorController::class, 'dashboard']);
    Route::get('/teachers', [DirectorController::class, 'teachers']);
    Route::get('/students', [DirectorController::class, 'students']);
    Route::get('/user-management', [DirectorController::class, 'userManagement']);
});
```

### 🧙‍♂️ **Maestro Sabio**

#### **Gestión de Aulas**
- 🏰 **Crear Aulas**: Con códigos únicos
- 👥 **Importar Estudiantes**: Desde Excel/CSV
- 📊 **Ver Progreso**: Individual y grupal
- 🎯 **Ajustar Puntos**: Modificación manual

#### **Sistema de Comportamientos**
- ⭐ **Crear Comportamientos**: Personalizados
- 🎨 **Personalización**: Iconos, colores
- 📈 **Otorgar Puntos**: Sistema rápido
- 📋 **Historial**: Seguimiento completo

#### **Importación de Estudiantes**
```php
// Formatos soportados: .xlsx, .xls, .csv
// Plantilla disponible para descarga
// Proceso: Nombre | Email | Contraseña
public function importStudents(Request $request, Classroom $classroom)
```

### ⚔️ **Estudiante Aventurero**

#### **Selección de Personaje**
```php
// 5 clases disponibles con bonus únicos
public function selectCharacter(Request $request) {
    // Validación y asignación de personaje
    // Bonus específicos por tipo de actividad
}
```

#### **Dashboard Épico**
- 📊 **Progreso Visual**: Nivel, XP, estadísticas
- 🏰 **Mis Dominios**: Aulas activas
- 🗡️ **Misiones**: Tareas por completar
- 🏆 **Logros**: Achievements desbloqueados

#### **Sistema de Recompensas**
```php
public function buyReward(Request $request, $rewardId) {
    // Verificación de puntos
    // Procesamiento de compra
    // Aplicación de bonus XP
    // Registro de transacción
}
```

### 🛡️ **Padre Guardián**

#### **Seguimiento de Hijos**
- 👥 **Vincular Hijos**: Por email
- 📊 **Ver Progreso**: Estadísticas detalladas
- 🏰 **Acceso a Aulas**: Visibilidad de actividades
- 📧 **Notificaciones**: Alertas importantes

---

## 🎨 Diseño y UX

### 🎭 **Tema Visual Épico**

#### **Paleta de Colores Personalizada**
```css
/* Dorado Imperial */
--gold-light: #fbbf24;
--gold-medium: #f59e0b; 
--gold-dark: #d97706;

/* Púrpura Mágico */
--purple-light: #8b5cf6;
--purple-medium: #7c3aed;
--purple-dark: #6d28d9;

/* Gradientes Épicos */
background: linear-gradient(135deg, #667eea, #764ba2);
```

#### **Tipografías Épicas**
- **Títulos**: `Cinzel Decorative` - Épico y majestuoso
- **Subtítulos**: `Cinzel` - Elegante y legible
- **Contenido**: `Playfair Display` - Profesional y claro

#### **Efectos Visuales Avanzados**
```css
/* Animaciones de evolución */
@keyframes evolutionGradient {
    0% { background-position: 0% 50%; opacity: 0; }
    50% { background-position: 100% 50%; opacity: 1; }
    100% { background-position: 0% 50%; opacity: 0; }
}

/* Partículas mágicas */
.particle {
    animation: particleFloat 3s ease-out forwards;
}
```

### 📱 **Responsive Design Completo**

#### **Breakpoints Optimizados**
- **Mobile**: 320px - 768px (interfaz táctil)
- **Tablet**: 768px - 1024px (híbrido)
- **Desktop**: 1024px+ (experiencia completa)

#### **Características Móviles**
- ✅ Navegación hamburguesa intuitiva
- ✅ Cards adaptables y legibles
- ✅ Botones touch-friendly (44px mínimo)
- ✅ Scroll suave y natural
- ✅ Carga rápida de imágenes

---

## 📋 Funcionalidades Avanzadas

### 📊 **Sistema de Importación Excel**

#### **Proceso de Importación**
```php
// 1. Subir archivo Excel/CSV
public function importStudents(Request $request, Classroom $classroom)

// 2. Procesamiento con PhpSpreadsheet
private function readExcelFileAdvanced($filePath)

// 3. Validación y creación de usuarios
private function processStudentsData($data, $classroom)
```

#### **Plantilla de Excel**
- 📝 **Columnas**: Nombre Completo | Email | Contraseña
- 🎨 **Formato**: Estilizada con colores y ejemplos
- 📥 **Descarga**: `GET /teacher/download-students-template`

### 🔄 **Sistema de Evolución en Tiempo Real**

#### **Animaciones Cinematográficas**
```javascript
// Animación épica de 6 segundos
function showEvolutionAnimation(data) {
    // Overlay con gradientes animados
    // Partículas mágicas flotantes
    // Sonidos épicos (configurables)
    // Actualización de personaje
}
```

#### **Detección Automática de Evolución**
```php
// Al completar misiones
public function completeQuest(Request $request, $questId) {
    // Calcular XP ganado con bonus
    // Verificar subida de nivel
    // Detectar cambio de tier
    // Activar animación si evoluciona
}
```

### 🛒 **Tienda Legendaria Avanzada**

#### **Tipos de Recompensas**
- **Temporales**: Bonus por tiempo limitado
- **Permanentes**: Mejoras definitivas
- **Físicas**: Objetos reales
- **Privilegios**: Permisos especiales

#### **Sistema de Restricciones**
```php
// Restricciones por nivel
'level_requirement' => 10

// Específicas por personaje
'character_specific' => ['mage', 'wizard']

// Límites de uso
'max_uses_per_student' => 1
```

---

## 🔧 Troubleshooting

### ❗ **Problemas Comunes**

#### **Error de Conexión MongoDB**
```bash
# Verificar servicio MongoDB
sudo systemctl status mongod

# Reiniciar MongoDB
sudo systemctl restart mongod

# Verificar conexión
mongo --eval "db.adminCommand('ismaster')"
```

#### **Error de Dependencias**
```bash
# Limpiar y reinstalar
composer clear-cache
composer install --no-cache

# Regenerar autoload
composer dump-autoload
```

#### **Error de Permisos en Windows**
```bash
# Ejecutar terminal como administrador
# Verificar permisos de carpeta storage/
# Configurar antivirus para excluir carpeta del proyecto
```

#### **Assets no se Compilan**
```bash
# Limpiar caché Node.js
npm cache clean --force

# Reinstalar dependencias
rm -rf node_modules package-lock.json
npm install

# Compilar en modo desarrollo
npm run dev
```

### 🔍 **Logs y Debugging**

#### **Ubicaciones de Logs**
- **Laravel**: `storage/logs/laravel.log`
- **MongoDB**: `/var/log/mongodb/mongod.log`
- **PHP**: Configurado en `php.ini`

#### **Debugging Útil**
```php
// En controllers
\Log::info('Debug info:', ['data' => $variable]);

// Ver queries MongoDB
\Log::info('MongoDB Query executed');

// Debug de sesiones
dd(session()->all());
```

---

## 🚀 Deployment

### 🌐 **Producción en VPS/Servidor**

#### **Requisitos del Servidor**
- **OS**: Ubuntu 20.04+ / CentOS 8+
- **RAM**: 4GB mínimo, 8GB recomendado
- **CPU**: 2 cores mínimo
- **Storage**: 20GB SSD
- **Nginx/Apache**: Servidor web
- **SSL**: Certificado HTTPS

#### **Script de Deployment**
```bash
#!/bin/bash
# deploy.sh

# Actualizar código
git pull origin main

# Instalar dependencias
composer install --optimize-autoloader --no-dev

# Compilar assets
npm ci --production
npm run build

# Limpiar caché
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Reiniciar servicios
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

### ☁️ **Configuración Nginx**
```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /var/www/legendaryclass/public;
    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    
    index index.php;
    
    charset utf-8;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 📚 Documentación de API

### 🔗 **Endpoints Principales**

#### **Autenticación**
```http
POST /login
POST /logout
GET /dashboard (redirección por rol)
```

#### **Estudiantes**
```http
GET /students/dashboard           # Dashboard épico
POST /students/character/select   # Seleccionar personaje
POST /students/quests/{id}/complete  # Completar misión
POST /students/rewards/{id}/buy   # Comprar recompensa
POST /students/upgrade-stat       # Subir estadística
```

#### **Profesores**
```http
GET /teacher/classrooms          # Lista de aulas
POST /teacher/student-behaviors     # Otorgar comportamiento
POST /teacher/rewards            # Crear recompensa
```

#### **Director**
```http
GET /director/dashboard          # Panel imperial
GET /director/user-management    # Gestión de usuarios
POST /director/create-user       # Crear usuario
PATCH /director/users/{user}/role  # Cambiar rol
```

#### **Padres**
```http
GET /parent/dashboard            # Dashboard padres
POST /parent/link-child          # Vincular hijo
GET /parent/child/{child}/progress  # Progreso del hijo
```

### 📊 **Respuestas de API**

#### **Completar Misión (con Evolución)**
```json
{
  "success": true,
  "xp": 120,
  "old_level": 24,
  "new_level": 25,
  "level_up": true,
  "evolution": true,
  "old_tier": 1,
  "new_tier": 2,
  "tier_name": "Veterano",
  "character_image": "/images/characters/mage_tier_2.png",
  "evolution_message": "¡Tu personaje ha evolucionado a Veterano!",
  "evolution_bonus": 50
}
```

#### **Comprar Recompensa**
```json
{
  "success": true,
  "message": "¡Poción de Sabiduría canjeada con éxito! +25 XP ganados!",
  "points_spent": 50,
  "remaining_points": 200,
  "reward_name": "Poción de Sabiduría",
  "xp_gained": 25
}
```

---

## 🎮 Scripts de Automatización

### 🔄 **Scripts de Desarrollo**

#### **Reinicio Completo del Sistema**
```bash
#!/bin/bash
# reset-system.sh

echo "🔄 Reiniciando LegendaryClass..."

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Recompilar assets
npm run dev

# Resetear base de datos (¡CUIDADO!)
php artisan db:seed --force

echo "✅ Sistema reiniciado completamente"
```

#### **Backup de Base de Datos**
```bash
#!/bin/bash
# backup-db.sh

DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="legendaryclass_db"
BACKUP_DIR="./backups"

mkdir -p $BACKUP_DIR

echo "📦 Creando backup de MongoDB..."
mongodump --db $DB_NAME --out $BACKUP_DIR/backup_$DATE

echo "✅ Backup creado: $BACKUP_DIR/backup_$DATE"
```

#### **Actualización de Dependencias**
```bash
#!/bin/bash
# update-deps.sh

echo "📦 Actualizando dependencias..."

# PHP
composer update
composer dump-autoload

# Node.js
npm update
npm audit fix

# Recompilar
npm run build

echo "✅ Dependencias actualizadas"
```

### 🛠️ **Scripts de Mantenimiento**

#### **Limpieza de Logs**
```bash
#!/bin/bash
# clean-logs.sh

echo "🧹 Limpiando logs antiguos..."

# Laravel logs (más de 7 días)
find storage/logs -name "*.log" -mtime +7 -delete

# Logs del sistema (más de 30 días)
find /var/log -name "*.log.*.gz" -mtime +30 -delete

echo "✅ Logs limpiados"
```

#### **Optimización de Performance**
```bash
#!/bin/bash
# optimize.sh

echo "⚡ Optimizando sistema..."

# Cache de configuración
php artisan config:cache

# Cache de rutas
php artisan route:cache

# Cache de vistas
php artisan view:cache

# Optimizar autoloader
composer install --optimize-autoloader --no-dev

# Assets optimizados
npm run build

echo "✅ Sistema optimizado"
```

---

## 🧪 Testing

### 🔬 **Tests Unitarios**

#### **Ejecutar Tests**
```bash
# Todos los tests
php artisan test

# Tests específicos
php artisan test --filter=UserTest

# Con coverage
php artisan test --coverage
```

#### **Test de Ejemplo - Sistema de Experiencia**
```php
// tests/Unit/ExperienceSystemTest.php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class ExperienceSystemTest extends TestCase
{
    public function test_level_calculation()
    {
        $user = User::factory()->create(['experience_points' => 400]);
        
        $this->assertEquals(3, $user->calculateLevel(400));
        $this->assertEquals(1, $user->calculateLevel(50));
        $this->assertEquals(11, $user->calculateLevel(10000));
    }
    
    public function test_character_evolution()
    {
        $user = User::factory()->create(['level' => 24]);
        
        // Subir a nivel 25 (evolución)
        $result = $user->gainExperience(600, 'test');
        
        $this->assertEquals(25, $user->level);
        $this->assertEquals(2, $user->getCharacterTier($user->level));
    }
}
```

### 📊 **Tests de Integración**

#### **Test de Importación Excel**
```php
// tests/Feature/ExcelImportTest.php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Classroom;
use Illuminate\Http\UploadedFile;

class ExcelImportTest extends TestCase
{
    public function test_excel_import_creates_students()
    {
        $classroom = Classroom::factory()->create();
        
        $file = UploadedFile::fake()->createWithContent(
            'students.xlsx',
            file_get_contents(base_path('tests/fixtures/students_example.xlsx'))
        );
        
        $response = $this->post(
            route('teacher.classrooms.import-students', $classroom),
            ['excel_file' => $file]
        );
        
        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }
}
```

---

## 🔐 Seguridad

### 🛡️ **Medidas de Seguridad Implementadas**

#### **Autenticación y Autorización**
```php
// Middleware de roles
Route::middleware(['auth', 'role:teacher'])->group(function () {
    // Rutas protegidas para profesores
});

// Verificación de permisos en controladores
public function canViewStudent($studentId) {
    if ($this->hasAdminAccess()) return true;
    
    if ($this->role === 'parent') {
        return in_array($studentId, $this->children_ids ?? []);
    }
    
    return false;
}
```

#### **Validación de Datos**
```php
// Validación estricta en requests
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:8|confirmed',
    'role' => 'required|in:teacher,student,parent'
]);
```

#### **Protección CSRF**
```html
<!-- Todos los formularios incluyen token CSRF -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- En JavaScript -->
headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
}
```

### 🔒 **Configuraciones de Seguridad**

#### **Variables de Entorno Sensibles**
```env
# Nunca subir al repositorio
APP_KEY=base64:clave-secreta-generada
DB_PASSWORD=contraseña-super-segura
JWT_SECRET=token-secreto-para-api

# Configuraciones de sesión
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
```

#### **Headers de Seguridad**
```php
// En middleware o server config
'X-Frame-Options' => 'SAMEORIGIN',
'X-Content-Type-Options' => 'nosniff',
'X-XSS-Protection' => '1; mode=block',
'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains'
```

---

## 📈 Performance y Optimización

### ⚡ **Optimizaciones Implementadas**

#### **Cache de Laravel**
```php
// Cache de configuración
php artisan config:cache

// Cache de rutas
php artisan route:cache

// Cache de vistas Blade
php artisan view:cache
```

#### **Optimización de Base de Datos**
```php
// Consultas optimizadas con relaciones
$classrooms = Classroom::with(['teacher', 'students'])
    ->where('is_active', true)
    ->get();

// Paginación para listas grandes
$students = User::where('role', 'student')
    ->paginate(20);
```

#### **Lazy Loading de Imágenes**
```html
<!-- Carga diferida de imágenes de personajes -->
<img src="/images/characters/mage_tier_1.png" 
     loading="lazy" 
     alt="Mago Tier 1"
     onerror="this.src='/images/characters/default.png'">
```

### 📊 **Métricas de Performance**

#### **Benchmarks del Sistema**
- **Tiempo de carga inicial**: < 2 segundos
- **Dashboard de estudiante**: < 1.5 segundos
- **Importación Excel (100 usuarios)**: < 10 segundos
- **Evolución de personaje**: 6 segundos (animación)

#### **Optimizaciones Futuras**
- 🚀 Redis para cache de sesiones
- 📦 CDN para imágenes estáticas
- 🗜️ Compresión Gzip/Brotli
- 📱 Service Workers para PWA

---

## 🤝 Contribución

### 👩‍💻 **Guía para Contribuidores**

#### **Estándares de Código**
```php
// PSR-12 Standard
class StudentsController extends Controller
{
    /**
     * Completar misión con sistema de evolución
     */
    public function completeQuest(Request $request, $questId): JsonResponse
    {
        // Lógica clara y documentada
    }
}
```

#### **Convenciones de Naming**
- **Variables**: `$studentBehavior`, `$characterType`
- **Métodos**: `completeQuest()`, `upgradeStatistic()`
- **Clases**: `StudentsController`, `ExperienceLog`
- **Archivos**: `character-evolution.blade.php`

#### **Commits Semánticos**
```bash
# Nuevas características
git commit -m "feat: agregar sistema de evolución de personajes"

# Corrección de bugs
git commit -m "fix: corregir cálculo de XP en misiones"

# Documentación
git commit -m "docs: actualizar README con nuevas funcionalidades"

# Refactoring
git commit -m "refactor: optimizar consultas de base de datos"
```

### 🐛 **Reporte de Bugs**

#### **Template de Issue**
```markdown
**Descripción del Bug**
Descripción clara del problema encontrado.

**Pasos para Reproducir**
1. Ir a '...'
2. Hacer clic en '...'
3. Ver error

**Comportamiento Esperado**
Lo que debería pasar.

**Comportamiento Actual**
Lo que está pasando.

**Información del Sistema**
- OS: [Windows 11 / Ubuntu 20.04]
- PHP: [8.2.1]
- MongoDB: [6.0.3]
- Navegador: [Chrome 110]

**Logs Relevantes**
```
Agregar logs del error aquí
```

### 🎨 **Guía de Diseño**

#### **Agregar Nuevos Personajes**
```php
// 1. Agregar en array de personajes
$characters = [
    'paladin' => [
        'class' => 'Paladín Sagrado',
        'icon' => '🛡️',
        'bonus_type' => 'protection'
    ]
];

// 2. Crear imágenes
// public/images/characters/paladin_tier_1.png -> paladin_tier_4.png
// public/images/escudos/escudopaladin.png

// 3. Actualizar vista de selección
// resources/views/students/character/select.blade.php
```

#### **Agregar Nuevas Recompensas**
```php
// En seeder o admin panel
Reward::create([
    'name' => 'Capa de Invisibilidad',
    'description' => 'Te hace invisible en el ranking por 24h',
    'icon' => '👻',
    'cost_points' => 200,
    'type' => 'temporary',
    'duration_hours' => 24,
    'rarity' => 'epic'
]);
```

---

## 📅 Roadmap

### 🗓️ **Versión 2.0 - Q2 2024**

#### **Nuevas Características**
- 🎵 **Sistema de Audio**: Sonidos épicos y música ambiental
- 📱 **App Móvil**: PWA con notificaciones push
- 🌐 **Multi-idioma**: Español, Inglés, Francés
- 🏆 **Torneos**: Competencias entre aulas
- 📊 **Analytics AI**: Predicciones de rendimiento

#### **Mejoras Técnicas**
- ⚡ **Redis**: Cache distribuido
- 🔄 **WebSockets**: Actualizaciones en tiempo real
- 📦 **Microservicios**: Arquitectura escalable
- 🐳 **Docker**: Containerización completa

### 🗓️ **Versión 3.0 - Q4 2024**

#### **Características Avanzadas**
- 🤖 **IA Adaptativa**: Misiones personalizadas
- 🥽 **Realidad Aumentada**: Visualización de personajes
- 🌍 **Metaverso Educativo**: Mundos virtuales 3D
- 🔗 **Blockchain**: NFTs de logros únicos


---

*"La educación no es preparación para la vida; la educación es la vida en sí misma."* - John Dewey

</div>

*LegendaryClass - Transformando la educación una clase a la vez*

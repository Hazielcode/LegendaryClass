#!/bin/bash

echo "🎮 Instalando Sistema de Gamificación Educativa..."
echo "=============================================="

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Función para mostrar errores
show_error() {
    echo -e "${RED}❌ Error: $1${NC}"
    exit 1
}

# Función para mostrar éxito
show_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

# Función para mostrar advertencias
show_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

# Función para mostrar información
show_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

# Verificar dependencias
echo "🔍 Verificando dependencias..."

# Verificar PHP
if ! command -v php &> /dev/null; then
    show_error "PHP no está instalado. Por favor instala PHP 8.2 o superior."
fi

php_version=$(php -v | head -n 1 | cut -d ' ' -f 2 | cut -d '.' -f 1,2)
if (( $(echo "$php_version < 8.2" | bc -l) )); then
    show_error "Se requiere PHP 8.2 o superior. Versión actual: $php_version"
fi

# Verificar Composer
if ! command -v composer &> /dev/null; then
    show_error "Composer no está instalado. Por favor instala Composer."
fi

# Verificar Node.js
if ! command -v node &> /dev/null; then
    show_error "Node.js no está instalado. Por favor instala Node.js 18 o superior."
fi

# Verificar extensión MongoDB
if ! php -m | grep -q mongodb; then
    show_warning "La extensión MongoDB para PHP no está instalada."
    echo "Para instalarla ejecuta: sudo pecl install mongodb"
    echo "Y agrega 'extension=mongodb' a tu php.ini"
    read -p "¿Continuar sin la extensión MongoDB? (y/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

show_success "Todas las dependencias están disponibles"

# Instalar dependencias PHP
echo ""
echo "📦 Instalando dependencias PHP..."
if ! composer install; then
    show_error "Falló la instalación de dependencias PHP"
fi
show_success "Dependencias PHP instaladas"

# Instalar dependencias Node.js
echo ""
echo "📦 Instalando dependencias Node.js..."
if ! npm install; then
    show_error "Falló la instalación de dependencias Node.js"
fi
show_success "Dependencias Node.js instaladas"

# Configurar archivo .env
echo ""
if [ ! -f .env ]; then
    echo "📝 Creando archivo .env..."
    cp .env.example .env
    show_success "Archivo .env creado"
else
    show_info "El archivo .env ya existe"
fi

# Generar key de aplicación
echo ""
echo "🔑 Generando application key..."
if ! php artisan key:generate; then
    show_error "Falló la generación de la application key"
fi
show_success "Application key generada"

# Configurar storage link
echo ""
echo "🔗 Creando enlace de storage..."
if ! php artisan storage:link; then
    show_warning "No se pudo crear el enlace de storage (es normal en algunos sistemas)"
else
    show_success "Enlace de storage creado"
fi

# Compilar assets
echo ""
echo "🎨 Compilando assets..."
if ! npm run build; then
    show_error "Falló la compilación de assets"
fi
show_success "Assets compilados"

# Configurar base de datos
echo ""
echo "🗄️  Configuración de base de datos"
show_info "Asegúrate de que MongoDB esté ejecutándose en tu sistema"

read -p "¿Deseas configurar la base de datos ahora? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo ""
    echo "Selecciona una opción:"
    echo "1) Instalación con datos de demostración (recomendado)"
    echo "2) Instalación limpia (sin datos)"
    echo "3) Solo crear las tablas"
    read -p "Opción (1-3): " -n 1 -r
    echo
    
    case $REPLY in
        1)
            echo "🎯 Instalando con datos de demostración..."
            if php artisan migrate:fresh --seed; then
                show_success "Base de datos configurada con datos de demostración"
                DEMO_INSTALLED=true
            else
                show_error "Falló la configuración de la base de datos"
            fi
            ;;
        2)
            echo "🔧 Instalación limpia..."
            if php artisan migrate:fresh; then
                show_success "Base de datos configurada (vacía)"
            else
                show_error "Falló la configuración de la base de datos"
            fi
            ;;
        3)
            echo "📋 Creando tablas..."
            if php artisan migrate; then
                show_success "Tablas creadas"
            else
                show_error "Falló la creación de tablas"
            fi
            ;;
        *)
            show_info "Configuración de base de datos omitida"
            ;;
    esac
fi

# Finalización
echo ""
echo "========================================"
echo -e "${GREEN}✅ ¡Instalación completada exitosamente!${NC}"
echo "========================================"
echo ""

if [ "$DEMO_INSTALLED" = true ]; then
    echo -e "${BLUE}📋 Usuarios de demostración creados:${NC}"
    echo "👨‍🏫 Profesor: profesor@demo.com"
    echo "👩‍🎓 Estudiante 1: ana@demo.com"
    echo "👨‍🎓 Estudiante 2: juan@demo.com"
    echo "👩‍🎓 Estudiante 3: maria@demo.com"
    echo "👨‍🎓 Estudiante 4: carlos@demo.com"
    echo "🔒 Contraseña para todos: password"
    echo ""
    echo -e "${BLUE}🏫 Aulas de demostración:${NC}"
    echo "📐 Matemáticas 5° A (Código: DEMO01)"
    echo "🔬 Ciencias Naturales 5° A (Código: DEMO02)"
    echo ""
fi

echo -e "${BLUE}🚀 Para iniciar el servidor de desarrollo:${NC}"
echo "php artisan serve"
echo ""
echo -e "${BLUE}📝 Configuración adicional:${NC}"
echo "• Edita el archivo .env para configurar tu base de datos MongoDB"
echo "• Revisa la documentación en README.md"
echo "• Ejecuta 'php artisan gamification:setup' para configuración interactiva"
echo ""

# Preguntar si iniciar el servidor
read -p "¿Deseas iniciar el servidor de desarrollo ahora? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo ""
    echo "🌐 Iniciando servidor en http://localhost:8000"
    echo "Presiona Ctrl+C para detener el servidor"
    echo ""
    php artisan serve
fi

echo "¡Disfruta del sistema de gamificación educativa! 🎉"
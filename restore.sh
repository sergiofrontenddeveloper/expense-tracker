#!/bin/bash

# --- CONFIGURACIÓN DE RUTAS ---
CARPETA_DESCARGAS="$HOME/Descargas"
RUTA_PROYECTO="$HOME/expense-tracker" # Ajusta si tu carpeta tiene otra ruta absoluta
RUTA_DESTINO="$CARPETA_DESCARGAS/database.sqlite"

echo "🔍 Buscando copias de seguridad en tu carpeta de Descargas..."

# 1. Buscar el archivo de backup .sqlite más reciente en Descargas (que empiece por 'backup-')
ULTIMO_BACKUP=$(ls -t "$CARPETA_DESCARGAS"/backup-*.sqlite 2>/dev/null | head -n 1)

if [ -z "$ULTIMO_BACKUP" ]; then
    echo "❌ Error: No se encontró ningún archivo que empiece por 'backup-' y termine en '.sqlite' en tu carpeta de Descargas."
    exit 1
fi

NOMBRE_BACKUP=$(basename "$ULTIMO_BACKUP")
echo "✅ ¡Encontrado! El archivo más reciente es: $NOMBRE_BACKUP"

# 2. Pedir confirmación al usuario
read -p "¿Quieres restaurar esta copia de seguridad en tu Expense Tracker? (s/n): " CONFIRMACION
if [[ ! "$CONFIRMACION" =~ ^[Ss]$ ]]; then
    echo "⏹️ Restauración cancelada."
    exit 0
fi

echo "• Renombrando archivo y moviéndolo al proyecto..."

# 3. Mover y renombrar el archivo directamente a la carpeta database/ del proyecto Laravel
mv "$ULTIMO_BACKUP" "$RUTA_PROYECTO/database/database.sqlite"

# 4. Limpiar las cachés de Laravel automáticamente
echo "• Limpiando la caché de Laravel..."
cd "$RUTA_PROYECTO" || exit
php artisan config:clear > /dev/null
php artisan cache:clear > /dev/null

echo "🚀 ¡Base de datos restaurada con éxito! Ya puedes arrancar tu servidor."

<?php
// Script de limpieza para finalizar la actualización a CodeIgniter 3.1.13
echo "===== Limpieza de archivos temporales de actualización =====\n\n";

// Lista de archivos temporales a eliminar
$temp_files = [
    'update_config.php',
    'update_database.php',
    'update_routes.php',
    'update_autoload.php',
    'merge_constants.php',
    'diagnosis.php',
    'check_update.php'
];

// Eliminar archivos temporales
foreach ($temp_files as $file) {
    if (file_exists($file)) {
        unlink($file);
        echo "Eliminado: $file\n";
    }
}

// Copiar archivo .htaccess si es necesario
if (file_exists('temp_ci/CodeIgniter-3.1.13/.htaccess') && !file_exists('.htaccess')) {
    copy('temp_ci/CodeIgniter-3.1.13/.htaccess', '.htaccess');
    echo "Copiado: .htaccess\n";
}

// Verificar que la aplicación tenga la estructura correcta
echo "\nVerificando estructura de la aplicación...\n";
$essential_dirs = [
    'application/cache',
    'application/logs'
];

foreach ($essential_dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Creado: $dir\n";
    }
    
    if (!is_writable($dir)) {
        chmod($dir, 0755);
        echo "Permisos corregidos: $dir\n";
    }
}

// Crear archivo de información sobre la actualización
$update_info = <<<EOT
CodeIgniter actualizado a la versión 3.1.13
Fecha de actualización: " . date('Y-m-d H:i:s') . "

La actualización incluyó:
- Reemplazo de la carpeta system
- Actualización de los archivos de configuración principales
- Preservación de configuraciones personalizadas
- Mantenimiento de controladores y modelos existentes

IMPORTANTE: Si encuentra algún problema, puede restaurar los archivos de copia de seguridad con extensión .bak
EOT;

file_put_contents('update_info.txt', $update_info);
echo "Creado archivo de información: update_info.txt\n";

echo "\nLimpieza completada. La actualización a CodeIgniter 3.1.13 ha finalizado.\n";
echo "===================================================\n";
?>

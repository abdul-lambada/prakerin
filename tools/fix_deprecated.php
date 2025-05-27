<?php
// Script untuk memperbaiki peringatan "Creation of dynamic property" di PHP 8.2

// Daftar file yang perlu diperbaiki
$files_to_fix = [
    'system/core/URI.php',
    'system/core/Router.php'
];

foreach ($files_to_fix as $file) {
    echo "Memperbaiki file: $file\n";
    
    // Baca konten file
    $content = file_get_contents($file);
    
    // Buat cadangan file
    copy($file, $file . '.bak');
    
    // Perbaikan untuk URI.php
    if (strpos($file, 'URI.php') !== false) {
        // Tambahkan deklarasi properti $config di awal class CI_URI
        $pattern = '/class CI_URI\s*{/';
        $replacement = "class CI_URI {\n\t// Property declarations for PHP 8.2 compatibility\n\tpublic \$config;\n\tpublic \$uri_string;\n\tpublic \$segments = [];\n\tpublic \$rsegments = [];\n";
        $content = preg_replace($pattern, $replacement, $content);
    }
    
    // Perbaikan untuk Router.php
    if (strpos($file, 'Router.php') !== false) {
        // Tambahkan deklarasi properti $uri di awal class CI_Router
        $pattern = '/class CI_Router\s*{/';
        $replacement = "class CI_Router {\n\t// Property declarations for PHP 8.2 compatibility\n\tpublic \$uri;\n\tpublic \$routes = [];\n\tpublic \$class;\n\tpublic \$method;\n\tpublic \$directory;\n\tpublic \$default_controller;\n";
        $content = preg_replace($pattern, $replacement, $content);
    }
    
    // Simpan perubahan
    file_put_contents($file, $content);
    
    echo "File $file telah diperbaiki.\n";
}

echo "\nPerbaikan selesai. Silakan periksa kembali aplikasi Anda.\n";
?>

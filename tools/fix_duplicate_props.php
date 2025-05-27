<?php
// Script untuk memperbaiki deklarasi properti duplikat

// Restore dari backup untuk URI.php
if (file_exists('system/core/URI.php.bak')) {
    copy('system/core/URI.php.bak', 'system/core/URI.php');
    echo "File URI.php dikembalikan dari backup.\n";
}

// Restore dari backup untuk Router.php
if (file_exists('system/core/Router.php.bak')) {
    copy('system/core/Router.php.bak', 'system/core/Router.php');
    echo "File Router.php dikembalikan dari backup.\n";
}

// Memperbaiki file URI.php
$uri_file = 'system/core/URI.php';
$content = file_get_contents($uri_file);

// Tambahkan deklarasi properti $config saja (yang tidak ada di kelas asli)
$pattern = '/class CI_URI {/';
$replacement = "class CI_URI {\n\t// Property declarations for PHP 8.2 compatibility\n\tpublic \$config;\n";
$content = preg_replace($pattern, $replacement, $content);

// Simpan perubahan
file_put_contents($uri_file, $content);
echo "File URI.php telah diperbaiki dengan hanya menambahkan properti yang belum dideklarasikan.\n";

// Memperbaiki file Router.php
$router_file = 'system/core/Router.php';
$content = file_get_contents($router_file);

// Periksa properti yang sudah ada di Router.php
$router_props = [];
if (preg_match_all('/public\s+\$(\w+)\s*=/i', $content, $matches)) {
    $router_props = $matches[1];
}

// Tambahkan hanya properti yang belum dideklarasikan
$pattern = '/class CI_Router {/';
$replacement = "class CI_Router {\n\t// Property declarations for PHP 8.2 compatibility\n";

// Properti yang mungkin perlu ditambahkan
$props_to_add = ['uri', 'routes', 'class', 'method', 'directory', 'default_controller'];
foreach ($props_to_add as $prop) {
    if (!in_array($prop, $router_props)) {
        $replacement .= "\tpublic \$$prop;\n";
    }
}

$content = preg_replace($pattern, $replacement, $content);

// Simpan perubahan
file_put_contents($router_file, $content);
echo "File Router.php telah diperbaiki dengan hanya menambahkan properti yang belum dideklarasikan.\n";

echo "\nPerbaikan selesai. Silakan periksa kembali aplikasi Anda.\n";
?>

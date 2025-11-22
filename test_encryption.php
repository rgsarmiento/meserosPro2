<?php

require __DIR__.'/vendor/autoload.php';

use App\Services\DesEncryption;

// Prueba de encriptación
$password = "123"; // Cambia esto por la contraseña que quieres probar

echo "=== PRUEBA DE ENCRIPTACIÓN ===\n\n";
echo "Contraseña original: " . $password . "\n";
echo "Contraseña encriptada: " . DesEncryption::encrypt($password) . "\n\n";

// Prueba con diferentes contraseñas comunes
$passwords = ['123', '1234', 'admin', 'password', '12345'];

echo "=== PRUEBAS CON VARIAS CONTRASEÑAS ===\n\n";
foreach ($passwords as $pass) {
    echo "Password: '$pass' -> Encrypted: '" . DesEncryption::encrypt($pass) . "'\n";
}

echo "\n=== PRUEBA DE DESENCRIPTACIÓN ===\n\n";
$encrypted = DesEncryption::encrypt($password);
echo "Encriptado: " . $encrypted . "\n";
echo "Desencriptado: " . DesEncryption::decrypt($encrypted) . "\n";

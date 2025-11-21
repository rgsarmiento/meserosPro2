<?php

use App\Models\Orden;

echo "=== ÚLTIMA ORDEN ===" . PHP_EOL;
$orden = Orden::latest('Id')->first();

if ($orden) {
    echo "ID: " . $orden->Id . PHP_EOL;
    echo "Llave: " . $orden->Llave . PHP_EOL;
    echo "Mesa: " . $orden->mesa->Nombre . PHP_EOL;
    echo "Mesero: " . $orden->usuario->Nombre . PHP_EOL;
    echo "Total: $" . number_format($orden->Total, 0) . PHP_EOL;
    echo "Estado: " . $orden->Estado . PHP_EOL;
    echo "Fecha: " . $orden->FechaHora . PHP_EOL;
    
    echo PHP_EOL . "=== DETALLES ===" . PHP_EOL;
    foreach($orden->detalles as $detalle) {
        echo "- " . $detalle->NombreProducto . " x" . $detalle->Cantidad . " = $" . number_format($detalle->Precio * $detalle->Cantidad, 0) . PHP_EOL;
        if($detalle->Observacion) {
            echo "  Obs: " . $detalle->Observacion . PHP_EOL;
        }
    }
} else {
    echo "No hay órdenes en la base de datos" . PHP_EOL;
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesas = [
            ['Nombre' => 'Mesa 1', 'Estado' => 'Libre', 'IdPiso' => 1, 'Transmitir' => false],
            ['Nombre' => 'Mesa 2', 'Estado' => 'Libre', 'IdPiso' => 1, 'Transmitir' => false],
            ['Nombre' => 'Mesa 3', 'Estado' => 'Libre', 'IdPiso' => 1, 'Transmitir' => false],
            ['Nombre' => 'Mesa 4', 'Estado' => 'Libre', 'IdPiso' => 1, 'Transmitir' => false],
            ['Nombre' => 'Mesa 5', 'Estado' => 'Libre', 'IdPiso' => 1, 'Transmitir' => false],
            ['Nombre' => 'Mesa 6', 'Estado' => 'Libre', 'IdPiso' => 1, 'Transmitir' => false],
            ['Nombre' => 'Mesa 7', 'Estado' => 'Libre', 'IdPiso' => 2, 'Transmitir' => false],
            ['Nombre' => 'Mesa 8', 'Estado' => 'Libre', 'IdPiso' => 1, 'Transmitir' => false],
            ['Nombre' => 'Barra 1', 'Estado' => 'Libre', 'IdPiso' => 1, 'Transmitir' => false],
            ['Nombre' => 'Barra 2', 'Estado' => 'Libre', 'IdPiso' => 1, 'Transmitir' => false],
        ];

        foreach ($mesas as $mesa) {
            DB::table('PuestosConsumo')->insert($mesa);
        }

        $this->command->info('✓ Se han creado ' . count($mesas) . ' mesas de ejemplo');
    }
}

<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\Models\Barcode\Type;
use App\Enums\Models\Catalog\Level;
use App\Enums\Models\Catalog\Status;
use App\Enums\Models\Catalog\TrackingMode;
use App\Models\Barcode;
use App\Models\Catalog;
use App\Models\Packing;
use Illuminate\Database\Seeder;

final class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $this->addProductCocaCola();
    }

    protected function addProductCocaCola(): void
    {
        $product = Catalog::create([
            'sku_code'      => '1001',
            'name'          => 'Coca-Cola Lata 350ml',
            'level'         => Level::UN,
            'tracking_mode' => TrackingMode::LotAndExpiry,
            'status'        => Status::Enabled,
            'hazardous'     => null,
        ]);

        /** @var Packing $unitPacking */
        $unitPacking = $product->packings()->create([
            'level'    => \App\Enums\Models\Packing\Level::UN,
            'quantity' => 1,
            'weight'   => 0.37,
            'length'   => 12,
            'width'    => 12,
            'height'   => 15,
        ]);

        Barcode::create([
            'packing_id' => $unitPacking->id,
            'code'       => '7894900011517',
            'type'       => Type::EAN,
        ]);
        Barcode::create([
            'packing_id' => $unitPacking->id,
            'code'       => '7891000311101',
            'type'       => Type::Alias,
        ]);

        /** @var Packing $casePacking */
        $casePacking = $product->packings()->create([
            'level'    => \App\Enums\Models\Packing\Level::Display,
            'quantity' => 12,
            'weight'   => 4.44,
            'length'   => 30,
            'width'    => 25,
            'height'   => 15,
        ]);

        // EAN/DUN para Caixa
        Barcode::create([
            'packing_id' => $casePacking->id,
            'code'       => '17894900011514',
            'type'       => Type::DUN,
        ]);

        // --- Packing: Fardo (6 caixas) ---
        /** @var Packing $packPacking */
        $packPacking = $product->packings()->create([
            'level'    => \App\Enums\Models\Packing\Level::Packing,
            'quantity' => 72, // 6 caixas x 12 unidades
            'weight'   => 26.6,
            'length'   => 75,
            'width'    => 50,
            'height'   => 80,
        ]);

        // EAN/DUN para Fardo
        Barcode::create([
            'packing_id' => $packPacking->id,
            'code'       => '27894900011511',
            'type'       => Type::DUN,
        ]);

        // --- Packing: Pallet (72 fardos) ---
        /** @var Packing $palletPacking */
        $palletPacking = $product->packings()->create([
            'level'    => \App\Enums\Models\Packing\Level::Pallet,
            'quantity' => 5184, // 72 fardos x 72 unidades cada
            'weight'   => 1900,
            'length'   => 120,
            'width'    => 100,
            'height'   => 160,
        ]);

        // EAN/DUN para Pallet
        Barcode::create([
            'packing_id' => $palletPacking->id,
            'code'       => '37894900011518',
            'type'       => Type::DUN,
        ]);
    }
}

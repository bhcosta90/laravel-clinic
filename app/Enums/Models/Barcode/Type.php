<?php

declare(strict_types = 1);

namespace App\Enums\Models\Barcode;

enum Type: int
{
    case EAN      = 1;     // Código GS1 padrão (EAN-13, EAN-8)
    case DUN      = 2;     // Embalagem logística (GTIN-14)
    case Alias    = 3;
    case UPC      = 4;
    case QR       = 5;
    case RFID     = 6;
    case Serial   = 7;
    case Internal = 8;
    case Lot      = 9;

    public function label(): string
    {
        return match ($this) {
            self::EAN      => 'EAN',
            self::DUN      => 'DUN',
            self::Alias    => 'Alias',
            self::UPC      => 'UPC',
            self::QR       => 'QR',
            self::RFID     => 'RFID',
            self::Serial   => 'Serial',
            self::Internal => 'Internal',
            self::Lot      => 'Lot',
        };
    }
}

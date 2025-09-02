<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\V1\Api;

final class LocationController
{
    public function store()
    {
    }

    public function download()
    {
        $data = collect();

        $data->push([
            __('Address Code'),
            __('Street'),
            __('Column'),
            __('Level'),
            __('Position'),
            __('Zone'),
            __('Address Type'),
            __('Max Capacity'),
            __('Sequence'),
            __('Controlled'),
            __('Temperature'),
            __('Initial Status'),
        ]);

        $data->push(['R01-C01-N01-P01', 1, 1, 1, 1, 'A', 'Picking', 50, 1, 'N', '25', 'Enabled']);
        $data->push(['R05-C03-N04-P01', 5, 3, 4, 1, 'A', 'Buffer', 200, 100, 'N', '25', 'Enabled']);
        $data->push(['REC-01', '', '', '', '', 'STG', 'Receiving', 1000, 9000, 'N', '25', 'Enabled']);
        $data->push(['EXP-ROT-03', '', '', '', '', 'LO', 'Shipping', 500, 9500, 'N', '25', 'Enabled']);
        $data->push(['AVA-01', '', '', '', '', 'DAM', 'Damage', 100, 9800, 'N', '25', 'Blocked']);
        $data->push(['R02-C05-N01-P01', 2, 5, 1, 1, 'B', 'Picking', 30, 20, 'S', '18', 'Disabled']);
        $data->push(['R02-C05-N01-P02', 2, 5, 1, 1, 'B', 'Picking', 30, 20, 'S', '18', 'Disabled']);

        return response()->streamDownload(function () use ($data) {
            foreach ($data as $row) {
                echo implode(',', $row) . "\n";
            }
        }, 'locations.csv');
    }
}

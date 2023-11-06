<?php

namespace App\Exports\Products;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;



class ProductReports implements FromView
{

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.product-reports', [
            'reports' => $this->data
        ]);
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'B' => NumberFormat::FORMAT_NUMBER_00,
    //         'C' => NumberFormat::FORMAT_NUMBER_00,
    //     ];
    // }
}

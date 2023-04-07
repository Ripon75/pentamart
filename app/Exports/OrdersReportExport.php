<?php

namespace App\Exports;

use App\Models\orders;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersReportExport implements FromView
{
    protected $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('adminend.exports.orders-report', [
            'result' => $this->data
        ]);
    }
}

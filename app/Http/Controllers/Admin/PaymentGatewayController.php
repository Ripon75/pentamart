<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Http\Controllers\Controller;

class PaymentGatewayController extends Controller
{
    protected $_responseFormat = 'view';

    function __construct()
    {
        $this->modelObj = new PaymentGateway();
    }
}

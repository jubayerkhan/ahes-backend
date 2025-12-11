<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:web');
  }

  public function preview()
  {
    return view('content.user.invoice.app-invoice-preview');
  }

  public function print()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.user.invoice.app-invoice-print', ['pageConfigs' => $pageConfigs]);
  }
}

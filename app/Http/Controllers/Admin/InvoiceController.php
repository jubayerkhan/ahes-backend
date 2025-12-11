<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function preview()
  {
    return view('content.admin.invoice.app-invoice-preview');
  }

  public function print()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.admin.invoice.app-invoice-print', ['pageConfigs' => $pageConfigs]);
  }
}

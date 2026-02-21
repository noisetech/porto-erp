<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    public function index(){
        return view('pages.finance.coa.index');
    }
}

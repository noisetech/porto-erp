<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekeningBankController extends Controller
{
    public function index()
    {
        return view('pages.finance.bank.manajemen-rekening-bank');
    }

    public function data(Request $request) {}

    public function listMasterBank(Request $request) {}

    public function simpan(Request $request) {}

    public function update(Request $request) {}
}

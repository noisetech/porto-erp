<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubKategoriAnggaranController extends Controller
{
    public function index(){
        return view('pages.finance.anggaran.sub-kategori-anggaran');
    }


    public function simpan(Request $request){

    }

    public function getDataById($id){

    }

    public function update(Request $request){

    }

    public function hapus(Request $request){

    }
}

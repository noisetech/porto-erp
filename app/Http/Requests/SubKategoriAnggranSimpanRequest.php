<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubKategoriAnggranSimpanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kategori_anggaran' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => 'required',
            'coa'           => 'nullable|array',
            'coa.*'         => 'integer|exists:coa,id',
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_anggaran.required' => 'Kategori anggaran tidak boleh kosong',
            'kode.required' => 'Kategori tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'keterangan.required' => 'Keterangan tidak boleh kosong',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekeningUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bank_master'   => 'required',
            'coa'           => 'required',
            'nama_rekening' => 'required|string|max:100',
            'nomor_rekening' => 'required|unique:rekening_bank,nomor_rekening,' . $this->route('id'),
            'nama_pemilik'  => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'bank_master.required' => 'Bank wajib dipilih',
            'coa.required' => 'COA tidak boleh kosong',
            'nama_rekeing.required' => 'Nama rekening tidak boleh kosong',
            'nomor_rekening.required' => 'Nomor rekening tidak boleh kosong',
            'nomor_rekening.unique' => 'Nomor rekening sudah digunakan',
            'nama_pemelik.required' => 'Nama pemilik tida boleh kosong'
        ];
    }
}

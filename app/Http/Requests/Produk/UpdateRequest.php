<?php

namespace App\Http\Requests\Produk;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name'           => 'required|string|max:255',
            'kategori_id'   => 'required|exists:kategoris,id',
            'cost_price'     => 'required|integer|min:0',
            'stock'          => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'foto.image'             => 'File yang diupload harus gambar.',
            'foto.mimes'             => 'Extensi gambar harus JPG, JPEG, PNG.',
            'foto.max'               => 'Maksimal ukuran gambar 2MB.',
            'name.required'          => 'Nama Wajib diisi.',
            'kategori_id.required'   => 'Kategori produk wajib diisi.',
            'kategori_id.exists'     => 'Kategori produk tidak valid.',
            'email.email'            => 'Format email tidak valid.',
            'cost_price.required' => 'Harga pokok wajib diisi.',
            'cost_price.integer'  => 'Harga pokok harus diisi bilangan bulat.',
            'stock.required'         => 'Stock wajib diisi.',
            'stock.integer'          => 'Stock harus diisi angka.',
        ];
    }
}

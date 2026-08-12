<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
     public function kategori()
 {
     return $this->belongsTo(Kategori::class, 'kategori_id');
 }
}   
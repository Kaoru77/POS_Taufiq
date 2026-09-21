<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'user_id',
        'total_pembayaran',
        'diskon_persen',
        'metode_pembayaran',
        'status_pembayaran',
        'uang_diterima',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class, 'penjualan_id');
    }
    public function getSubtotalSebelumDiskonAttribute()
    {
        return $this->relationLoaded('itemPenjualan')
            ? $this->itemPenjualan->sum('subtotal')
            : $this->itemPenjualan()->sum('subtotal');
    }

    public function getNilaiDiskonAttribute()
    {
        return (int) round($this->subtotal_sebelum_diskon * ($this->diskon_persen ?? 0) / 100);
    }

    public function getKembalianAttribute()
    {
        if ($this->metode_pembayaran !== 'CASH' || is_null($this->uang_diterima)) {
            return null;
        }

        return $this->uang_diterima - $this->total_pembayaran;
    }
}

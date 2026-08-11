<?php

namespace App\Policies;

use App\Models\ItemPenjualan;
use App\Models\User;


class ItemPenjualanPolicy
{
    public function delete(User $user, ItemPenjualan $itempenjualan): bool
  {

     $penjualan = $itempenjualan->penjualan;

     if ($penjualan->status !== 'OPEN') {
         return false;
     }

     if ($user->role->name === 'admin') {
         return true;
     }

     return $user->role->name === 'kasir' && $penjualan->user_id === $user->id;
  }
}

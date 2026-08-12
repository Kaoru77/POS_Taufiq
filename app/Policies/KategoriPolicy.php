<?php

namespace App\Policies;

use App\Models\Kategori;
use App\Models\User;

class KategoriPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['admin', 'kasir']);
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'admin';
    }

    public function update(User $user, Kategori $kategori): bool
    {
        return $user->role->name === 'admin';
    }

    public function delete(User $user, Kategori $kategori): bool
    {
        return $user->role->name === 'admin';
    }
}
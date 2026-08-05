@extends('layouts.app')

@section('title', 'Detail User')

@section('content')

@include('layouts.navbar')

<h1>Detail User</h1>

<table class="table w-auto">
    <tr>
        <th>Nama</th>
        <td>{{ $user->name }}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $user->email }}</td>
    </tr>
    <tr>
        <th>Role</th>
        <td>{{ $user->role->name }}</td>
    </tr>
    <tr>
        <th>Terdaftar sejak</th>
        <td>{{ $user->created_at->translatedFormat('d-m-Y H:i') }}</td>
    </tr>
</table>

<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit Akun</a>
<a href="{{ route('admin.users') }}" class="btn btn-secondary">Kembali</a>

@endsection
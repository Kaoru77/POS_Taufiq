@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="dash-wrapper">
     <div class="form-page">
         <div class="header-card mb-3">
             <div>
                 <div class="header-eyebrow">Manajemen</div>
                 <h2 class="header-title mb-0">Edit User</h2>
             </div>
         </div>

         <div class="panel-card">
             <form action="{{route ('admin.users.update',$user)}}" method="POST">
                 @include('users._form')
             </form>
         </div>
     </div>
</div>

@endsection
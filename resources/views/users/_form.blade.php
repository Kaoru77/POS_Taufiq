@csrf

<div class="mb-3">
    <label class="form-label field-label">Nama</label>
    <div class="input-group">
        <span class="input-icon"><i class="bi bi-person"></i></span>
        <input type="text" name="name"
               class="form-control field-input @error('name') is-invalid @enderror"
               value="{{ old('name',$user->name ?? '') }}">
    </div>
    @error('name')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label field-label">Email</label>
    <div class="input-group">
        <span class="input-icon"><i class="bi bi-envelope"></i></span>
        <input type="email" name="email"
               class="form-control field-input @error('email') is-invalid @enderror"
               value="{{ old('email',$user->email ?? '' ) }}">
    </div>
    @error('email')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label field-label">Password</label>
    <div class="input-group">
        <span class="input-icon"><i class="bi bi-lock"></i></span>
        <input type="password" name="password"
               class="form-control field-input @error('password') is-invalid @enderror">
    </div>
    @error('password')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
    @isset($user)
        <div class="form-hint">Kosongkan kalau tidak ingin mengubah password.</div>
    @endisset
</div>

<div class="mb-4">
    <label class="form-label field-label">Role</label>
    <div class="input-group">
        <span class="input-icon"><i class="bi bi-person-badge"></i></span>
        <select name="role_id"
                class="form-select field-input @error('role_id') is-invalid @enderror">
            <option value="">-- Pilih Role --</option>
            @foreach($roles as $role)
            <option value="{{ $role->id }}"
                @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                {{ ucfirst($role->name) }}
            </option>
            @endforeach
        </select>
    </div>
    @error('role_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<hr class="form-divider">

<button class="btn btn-caramel">Simpan</button>
<a href="{{ route('admin.users') }}" class="btn btn-soft-brown">Kembali</a>

<style>
.dash-wrapper {
    background: #F3E6D5;
    border-radius: 16px;
    padding: 1.5rem;
}
.panel-card {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
}
.form-page {
    max-width: 460px;
    margin: 0 auto;
}
.header-card {
    background: #4E2F1A;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
}
.header-eyebrow {
    font-size: .72rem;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #D9BFA3;
    margin-bottom: 2px;
}
.header-title {
    font-size: 1.35rem;
    font-weight: 600;
    color: #fff;
}

.field-label {
    font-size: .85rem;
    font-weight: 600;
    color: #4E2F1A;
    margin-bottom: 6px;
}
.input-icon {
    background: #FAF3EA;
    border: 1px solid #E8D9C5;
    border-right: none;
    color: #B49A82;
    padding: 0 12px;
    display: flex;
    align-items: center;
}
.field-input {
    border: 1px solid #E8D9C5;
    border-left: none;
    padding: 9px 12px;
}
.field-input:focus {
    border-color: #C9922E;
    box-shadow: none;
}
.input-group:focus-within .input-icon {
    border-color: #C9922E;
}
.form-hint {
    font-size: .76rem;
    color: #8A6D52;
    margin-top: 4px;
}
.form-divider {
    border-top: 1px solid #F0E4D6;
    margin: 1.5rem 0;
}

.btn-caramel {
    background-color: #C9922E;
    border: none;
    color: #fff;
    font-weight: 600;
    padding: 8px 22px;
}
.btn-caramel:hover { background-color: #A97722; color: #fff; }

.btn-soft-brown {
    background-color: #F3E6D8;
    border: none;
    color: #7B4B2A;
    font-weight: 500;
    padding: 8px 22px;
    margin-left: 6px;
}
.btn-soft-brown:hover { background-color: #E8D5BE; color: #4E2F1A; }
</style>
@csrf

<div class="mb-4">
    <label class="form-label field-label">Nama Kategori</label>
    <div class="input-group">
        <span class="input-icon"><i class="bi bi-tag"></i></span>
        <input type="text" name="nama"
               class="form-control field-input @error('nama') is-invalid @enderror"
               value="{{ old('nama', $kategori->nama ?? '') }}"
               placeholder="Misal: Roti, Donat, Kue...">
    </div>
    @error('nama')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<hr class="form-divider">

<button class="btn btn-caramel">Simpan</button>
<a href="{{ route('kategori.index') }}" class="btn btn-soft-brown">Kembali</a>

<style>
.form-page {
    max-width: 460px;
    margin: 0 auto;
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
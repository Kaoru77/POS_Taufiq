@csrf

<div class="text-center mb-4">
    <div class="form-icon mb-2">🏷️</div>
    <h5 class="fw-bold mb-0" style="color:#4E2F1A;">
        {{ isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
    </h5>
</div>

<div class="mb-2">
    <label class="form-label field-label">Nama Kategori</label>
    <div class="input-group">
        <span class="input-icon"><i class="bi bi-tag"></i></span>
        <input type="text" name="nama" id="namaKategori"
               class="form-control field-input @error('nama') is-invalid @enderror"
               value="{{ old('nama', $kategori->nama ?? '') }}"
               placeholder="Misal: Roti, Donat, Kue..."
               oninput="updateBadgePreview(this.value)">
    </div>
    @error('nama')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex align-items-center gap-2 mb-4">
    <span class="preview-label">Pratinjau tampilan:</span>
    <span class="badge-kategori-preview" id="badgePreview">
        {{ $kategori->nama ?? 'Nama Kategori' }}
    </span>
</div>

<hr class="form-divider">

<button class="btn btn-caramel">Simpan</button>
<a href="{{ route('kategori.index') }}" class="btn btn-soft-brown">Kembali</a>

<script>
function updateBadgePreview(value) {
    const preview = document.getElementById('badgePreview');
    preview.textContent = value.trim() === '' ? 'Nama Kategori' : value;
}
</script>

<style>
.form-page {
    max-width: 460px;
    margin: 0 auto;
}
.form-icon {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #F3E6D8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
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
    background: #fff;
    border: 1px solid #E8D9C5;
    border-left: none;
    padding: 9px 12px;
    color: #4E2F1A;
    font-weight: 600;
}
.field-input:focus {
    background: #fff;
    border-color: #C9922E;
    box-shadow: none;
    color: #4E2F1A;
}
.input-group:focus-within .input-icon {
    border-color: #C9922E;
}
.preview-label {
    font-size: .78rem;
    color: #8A6D52;
}
.badge-kategori-preview {
    background: #F3E6D8;
    color: #7B4B2A;
    font-size: .75rem;
    font-weight: 600;
    padding: 4px 14px;
    border-radius: 999px;
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
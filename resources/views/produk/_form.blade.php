@csrf

<style>
    /* Palette Tema Sweet Crumbs Bakery */
    :root {
        --bakery-dark: #3D2418;
        --bakery-accent: #C68A35;
        --bakery-accent-hover: #A87228;
        --bakery-bg-card: #FDFAF5;
        --bakery-bg-input: #FAF4EB;
        --bakery-border: #E8DED1;
        --bakery-text-muted: #7D6B5D;
    }

    .bakery-card {
        background-color: var(--bakery-bg-card);
        border: 1px solid var(--bakery-border);
        border-radius: 12px;
        padding: 24px;
    }

    .bakery-label {
        font-weight: 600;
        color: var(--bakery-dark);
        font-size: 0.9rem;
        margin-bottom: 6px;
    }

    .bakery-input {
        background-color: #ffffff;
        border: 1px solid var(--bakery-border);
        border-radius: 8px;
        padding: 10px 14px;
        color: var(--bakery-dark);
        transition: all 0.2s ease-in-out;
    }

    .bakery-input:focus {
        background-color: #ffffff;
        border-color: var(--bakery-accent);
        box-shadow: 0 0 0 0.25rem rgba(198, 138, 53, 0.2);
        color: var(--bakery-dark);
    }

    .btn-bakery-primary {
        background-color: var(--bakery-accent);
        border-color: var(--bakery-accent);
        color: #ffffff;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 24px;
    }

    .btn-bakery-primary:hover {
        background-color: var(--bakery-accent-hover);
        border-color: var(--bakery-accent-hover);
        color: #ffffff;
    }

    .btn-bakery-secondary {
        background-color: #F0E6D8;
        border-color: #F0E6D8;
        color: var(--bakery-dark);
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 24px;
    }

    .btn-bakery-secondary:hover {
        background-color: #E2D3C1;
        color: var(--bakery-dark);
    }

    .img-preview-box {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px dashed var(--bakery-border);
    }
</style>

<div class="bakery-card shadow-sm">
    <!-- Section 1: Upload Foto Produk -->
    <div class="mb-4">
        <label class="bakery-label">Foto Produk</label>
        <div class="d-flex align-items-center gap-3 flex-wrap mt-1">
            
            <!-- Foto Saat Ini (Jika Mode Edit) -->
            @if (!empty($produk->foto))
                <div class="text-center">
                    <img src="{{ asset('storage/' . $produk->foto) }}" class="img-preview-box" alt="Foto Saat Ini">
                    <div class="small text-muted mt-1" style="font-size: 0.75rem;">Foto Saat Ini</div>
                </div>
            @endif

            <!-- Preview Foto Baru -->
            <div class="text-center" id="previewContainer" style="{{ !empty($produk->foto) ? 'display:none;' : '' }}">
                <img id="preview" src="#" class="img-preview-box" style="display: none;" alt="Preview Foto">
                <div id="previewLabel" class="small text-muted mt-1" style="font-size: 0.75rem; display: none;">Preview Baru</div>
            </div>

            <!-- Input File -->
            <div class="flex-grow-1">
                <input type="file" 
                       name="foto" 
                       onchange="previewImage(this)"
                       class="form-control bakery-input @error('foto') is-invalid @enderror"
                       accept="image/*">
                <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                @error('foto')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

        </div>
    </div>

    <hr style="border-color: var(--bakery-border);">

    <!-- Section 2: Form Input Utama (Grid Layout) -->
    <div class="row g-3">
        
        <!-- Nama Produk -->
        <div class="col-md-6">
            <label class="bakery-label">Nama Produk</label>
            <input type="text" 
                   name="name" 
                   placeholder="Contoh: Roti Cokelat / Thai Green Tea"
                   class="form-control bakery-input @error('name') is-invalid @enderror"
                   value="{{ old('name', $produk->nama ?? '') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Jenis / Kategori Produk -->
        <div class="col-md-6">
            <label class="bakery-label">Jenis / Kategori Produk</label>
            <select name="kategori_id" class="form-select bakery-input @error('kategori_id') is-invalid @enderror">
                <option value="">-- Pilih Jenis Produk --</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_id', $produk->kategori_id ?? '') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            </select>
            @error('kategori_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Harga Beli -->
        <div class="col-md-4">
            <label class="bakery-label">Harga Beli (Rp)</label>
            <input type="number" 
                   name="purchase_price" 
                   placeholder="0"
                   class="form-control bakery-input @error('purchase_price') is-invalid @enderror"
                   value="{{ old('purchase_price', $produk->harga_beli ?? '') }}">
            @error('purchase_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Harga Jual -->
        <div class="col-md-4">
            <label class="bakery-label">Harga Jual (Rp)</label>
            <input type="number" 
                   name="selling_price" 
                   placeholder="0"
                   class="form-control bakery-input @error('selling_price') is-invalid @enderror"
                   value="{{ old('selling_price', $produk->harga_jual ?? '') }}">
            @error('selling_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Stok -->
        <div class="col-md-4">
            <label class="bakery-label">Jumlah Stok</label>
            <input type="number" 
                   name="stock" 
                   placeholder="0"
                   class="form-control bakery-input @error('stock') is-invalid @enderror"
                   value="{{ old('stock', $produk->stok ?? '') }}">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-end align-items-center gap-2 mt-4 pt-3 border-top" style="border-color: var(--bakery-border) !important;">
        <a href="{{ route('produk.index') }}" class="btn btn-bakery-secondary text-decoration-none">Batal</a>
        <button class="btn btn-bakery-primary" type="submit">Simpan Produk</button>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('previewContainer');
    const previewLabel = document.getElementById('previewLabel');
    const file = input.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        if (previewLabel) previewLabel.style.display = 'block';
        if (previewContainer) previewContainer.style.display = 'block';
    }
}
</script>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $penjualan->id }}</title>
    <style>
        :root {
            --ink: #4E2F1A;
            --muted: #8A6D52;
            --paper: #FFFDF9;
            --cream: #F3E6D5;
            --accent: #F3C77A;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--cream);
            color: var(--ink);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 12px;
            min-height: 100vh;
            padding: 32px 16px;
        }
        .receipt {
            width: 80mm;
            min-height: 100mm;
            margin: 0 auto;
            padding: 0 6mm 6mm;
            background: var(--paper);
            box-shadow: 0 18px 45px rgba(78, 47, 26, .16);
            position: relative;
        }
        .receipt::before, .receipt::after {
            content: "";
            display: block;
            height: 8px;
            margin: 0 -6mm 16px;
            background: var(--ink);
        }
        .receipt::after {
            height: 3px;
            margin: 16px -6mm 0;
            background: var(--accent);
        }
        .center { text-align: center; }
        .store-name {
            margin: 0 0 4px;
            color: var(--ink);
            font-size: 21px;
            letter-spacing: .02em;
        }
        .muted { color: var(--muted); }
        .rule { border: 0; border-top: 1px dashed #C9AF94; margin: 12px 0; }
        .meta { display: flex; justify-content: space-between; gap: 12px; }
        .meta span:first-child { color: var(--muted); }
        .item { margin: 10px 0; }
        .item-name { margin-bottom: 3px; font-weight: 600; }
        .item-total { display: flex; justify-content: space-between; gap: 12px; }
        .summary {
            display: flex;
            justify-content: space-between;
            color: var(--ink);
            font-weight: bold;
            font-size: 15px;
        }
        .actions {
            width: 80mm;
            margin: 18px auto 0;
            display: flex;
            gap: 8px;
        }
        .actions a, .actions button {
            flex: 1;
            border: 1px solid var(--ink);
            border-radius: 6px;
            background: transparent;
            color: var(--ink);
            cursor: pointer;
            padding: 10px 8px;
            text-align: center;
            text-decoration: none;
            font: inherit;
        }
        .actions button { background: var(--ink); color: #fff; }
        .actions a:hover { background: rgba(78, 47, 26, .08); }
        .actions button:hover { background: #6A4327; }
        @media print {
            @page { size: 80mm auto; margin: 0; }
            body { background: #fff; padding: 0; }
            .receipt { margin: 0; width: 80mm; box-shadow: none; }
            .receipt::before, .receipt::after { display: none; }
            .actions { display: none; }
        }
    </style>
</head>
<body>
    <main class="receipt">
        <header class="center">
            <h1 class="store-name">{{ config('app.name') }}</h1>
            <div class="muted">Struk Pembayaran</div>
        </header>

        <hr class="rule">
        <div class="meta"><span>No. Transaksi</span><strong>#{{ $penjualan->id }}</strong></div>
        <div class="meta"><span>Tanggal</span><span>{{ $penjualan->created_at->format('d/m/Y H:i') }}</span></div>
        <div class="meta"><span>Kasir</span><span>{{ $penjualan->user->name ?? '-' }}</span></div>
        <hr class="rule">

        @foreach($penjualan->itemPenjualan as $item)
            <div class="item">
                <div class="item-name">{{ $item->produk->nama ?? 'Produk Dihapus' }}</div>
                <div class="item-total">
                    <span>{{ $item->kuantitas }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                    <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                </div>
            </div>
        @endforeach

        <hr class="rule">
        <div class="summary">
            <span>Total</span>
            <span>Rp {{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}</span>
        </div>
        <div class="meta"><span>Pembayaran</span><span>{{ strtoupper($penjualan->metode_pembayaran ?? '-') }}</span></div>
        <p class="center muted">Terima kasih atas kunjungan Anda.</p>
    </main>

    <div class="actions">
        <a href="{{ route('penjualan.show', $penjualan) }}">Kembali</a>
        <button type="button" onclick="window.print()">Cetak</button>
    </div>

</body>
</html>
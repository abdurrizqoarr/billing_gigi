<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran - {{ $pasien->nama_pasien }}</title>
    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .nota-container {
            max-width: 80mm;
            /* Common receipt paper width */
            margin: auto;
            padding: 5mm;
        }

        .header,
        .footer {
            text-align: center;
        }

        .info-section {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
            margin: 10px 0;
        }

        .item-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .item-list li {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .item-list li span:last-child {
            text-align: right;
        }

        .total-section {
            border-top: 1px dashed #000;
            margin-top: 10px;
            padding-top: 5px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }

        @media print {
            body {
                width: 80mm;
                /* Adjust for common receipt printers */
                height: auto;
                margin: 0;
                padding: 0;
                background: #fff;
            }

            .nota-container {
                max-width: 80mm;
                padding: 0;
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
    <script>
        // Cetak saat halaman load
        window.addEventListener('DOMContentLoaded', (event) => {
            window.print();
        });

        // Tutup jendela setelah print selesai
        window.addEventListener('afterprint', (event) => {
            window.close();
        });
    </script>
</head>

<body>
    <div class="nota-container">
        {{-- Header --}}
        <div class="header">
            <h1 class="text-lg font-bold">Nota Pembayaran</h1>
        </div>
        {{-- Patient Information --}}
        <div class="info-section">
            <p><strong>No RM:</strong> {{ $pasien->no_rm }}</p>
            <p><strong>Nama Pasien:</strong> {{ $pasien->nama_pasien }}</p>
            <p><strong>Tanggal:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        {{-- List of Services/Items --}}
        <div class="content-section">
            <p class="font-bold">Tindakan Diterapkan</p>
            <ul class="item-list">
                @forelse($pemberianTindakan as $item)
                    <li>
                        <span>{{ $item['tarif_tindakan'] }} (x{{ $item['jumlah'] }})</span>
                        <span>Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                    </li>
                @empty
                    <li><span>- Belum ada Data.</span></li>
                @endforelse
            </ul>
            <br>
            <p class="font-bold">Obat / BHP Digunakan</p>
            <ul class="item-list">
                @forelse($pemberianObat as $item)
                    <li>
                        <span>{{ $item['nama_obat'] }} (x{{ $item['jumlah'] }})</span>
                        <span>Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                    </li>
                @empty
                    <li><span>- Belum ada Data.</span></li>
                @endforelse
            </ul>
            <br>
            <p class="font-bold">Biaya Lainnya</p>
            <ul class="item-list">
                @forelse($pasien->biayaLain as $item)
                    <li>
                        <span>{{ $item->biaya_lainnya }}</span>
                        <span>Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                    </li>
                @empty
                    <li><span>- Belum ada Data.</span></li>
                @endforelse
            </ul>
            <br>
            @if ($pasien->diskon)
                <p class="font-bold">Diskon</p>
                <ul class="item-list">
                    @forelse($pasien->diskon as $item)
                        <li>
                            <span>{{ $item->diskon }}</span>
                            <span>-Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        </li>
                    @empty
                        <li><span>- Belum ada Data.</span></li>
                    @endforelse
                </ul>
            @endif
        </div>
        {{-- Total --}}
        <div class="total-section">
            <span>TOTAL</span>
            <span>Rp {{ number_format($pasien->total_biaya, 0, ',', '.') }}</span>
        </div>
        {{-- Footer --}}
        <div class="footer mt-4">
            <p>Terima kasih atas kunjungan Anda!</p>
        </div>
    </div>
</body>

</html>

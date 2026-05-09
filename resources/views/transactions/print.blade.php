<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $transaction->id }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Courier New', Courier, monospace;
            background-color: #f0f0f0;
            color: #000;
        }
        .receipt {
            width: 300px;
            margin: 20px auto;
            background: #fff;
            padding: 15px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            font-size: 1.2rem;
        }
        .header p {
            margin: 2px 0;
            font-size: 0.85rem;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .info {
            font-size: 0.85rem;
            margin-bottom: 10px;
        }
        .info p {
            margin: 2px 0;
            display: flex;
            justify-content: space-between;
        }
        table {
            width: 100%;
            font-size: 0.85rem;
            border-collapse: collapse;
        }
        table th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }
        table td {
            padding: 5px 0;
            vertical-align: top;
        }
        .item-name {
            display: block;
            margin-bottom: 2px;
        }
        .item-details {
            display: flex;
            justify-content: space-between;
        }
        .totals {
            margin-top: 10px;
            font-size: 0.85rem;
        }
        .totals p {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        .totals .grand-total {
            font-weight: bold;
            font-size: 1rem;
            margin: 8px 0;
        }
        .footer {
            text-align: center;
            font-size: 0.85rem;
            margin-top: 20px;
        }
        .btn-print {
            display: block;
            width: 300px;
            margin: 20px auto;
            padding: 10px;
            background: #6C5CE7;
            color: #fff;
            border: none;
            cursor: pointer;
            text-align: center;
            font-size: 1rem;
            font-weight: bold;
            font-family: Arial, sans-serif;
            border-radius: 5px;
        }
        @media print {
            body {
                background: #fff;
            }
            .receipt {
                margin: 0;
                box-shadow: none;
                width: 100%;
                max-width: 80mm; /* typical thermal printer width */
            }
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <button class="btn-print" onclick="window.print()">🖨️ Cetak Struk</button>

    <div class="receipt">
        <div class="header">
            <h2>{{ config('app.name', 'Toko Muna') }}</h2>
            <p>Jl. Contoh Alamat No. 123</p>
            <p>Telp: 0812-3456-7890</p>
        </div>

        <div class="divider"></div>

        <div class="info">
            <p><span>No. Trx</span> <span>#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span></p>
            <p><span>Tanggal</span> <span>{{ $transaction->created_at->format('d M Y H:i') }}</span></p>
            <p><span>Kasir</span> <span>{{ $transaction->user->name ?? 'Unknown' }}</span></p>
            <p><span>Metode</span> <span>{{ strtoupper($transaction->payment_method) }}</span></p>
        </div>

        <div class="divider"></div>

        <table>
            <tbody>
                @foreach($transaction->items as $item)
                <tr>
                    <td>
                        <span class="item-name">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                        <div class="item-details">
                            <span>{{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}</span>
                            <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <div class="totals">
            <p class="grand-total"><span>TOTAL</span> <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span></p>
            <p><span>BAYAR ({{ strtoupper($transaction->payment_method) }})</span> <span>Rp {{ number_format($transaction->paid, 0, ',', '.') }}</span></p>
            <p><span>KEMBALI</span> <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span></p>
        </div>

        <div class="divider"></div>

        <div class="footer">
            <p>Terima Kasih Atas Kunjungan Anda</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
        </div>
    </div>

</body>
</html>

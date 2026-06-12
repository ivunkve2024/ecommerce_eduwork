<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $noInvoice }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>@media print { .no-print { display: none; } }</style>
</head>
<body style="background:#f5f5f5;">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between mb-3 no-print">
                <a href="{{ route('products') }}" class="btn btn-secondary btn-sm">&larr; Kembali ke Katalog</a>
                <button onclick="window.print()" class="btn btn-primary btn-sm">Cetak / Simpan PDF</button>
            </div>

            <div class="card shadow border-0 rounded-4 p-5 bg-white">
                <div class="row border-bottom pb-3 mb-4">
                    <div class="col-md-6">
                        <h2 class="fw-bold text-dark">EDU Online Shop</h2>
                        <p class="text-muted small">Nota Pembelian Simulasi (Multi-Controller)</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h4 class="fw-bold text-success">INVOICE</h4>
                        <span class="text-muted">Nomor:</span> <strong class="text-dark">{{ $noInvoice }}</strong><br>
                        <span class="text-muted">Tanggal:</span> <span>{{ date('d F Y, H:i') }}</span>
                    </div>
                </div>

                <div class="alert alert-success border-0 text-center fw-bold rounded-3 mb-4">
                    STATUS: LUNAS
                </div>

                <div class="table-responsive mb-4">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th class="text-center">Harga Satuan</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoiceItems as $item)
                                <tr>
                                    <td><span class="fw-bold">{{ $item['nama'] }}</span></td>
                                    <td class="text-center">Rp {{ number_format($item['harga']) }}</td>
                                    <td class="text-center">{{ $item['quantity'] }} pcs</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item['harga'] * $item['quantity']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <div class="d-flex justify-content-between border-top pt-3">
                            <span class="fs-5">Total Bayar:</span>
                            <span class="fs-5 fw-bold text-success">Rp {{ number_format($totalBayar) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
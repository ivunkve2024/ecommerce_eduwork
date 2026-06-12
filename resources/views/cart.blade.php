<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - EDU Online Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f5f5f5;">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><span class="fw-bold text-dark">Keranjang</span> Belanja</h2>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali Belanja</a>
    </div>

    @if(empty($cartItems))
        <div class="alert alert-warning p-5 rounded-4 shadow-sm text-center">
            <h4 class="fw-bold">Keranjang belanjamu kosong.</h4>
            <a href="{{ route('home') }}" class="btn btn-warning btn-sm mt-2 fw-bold">Lihat Produk</a>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow border-0 rounded-4 p-3">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th style="width: 100px;">Jumlah</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total_belanja = 0; @endphp
                                @foreach($cartItems as $item)
                                    @php 
                                        $subtotal = $item['harga'] * $item['quantity'];
                                        $total_belanja += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item['gambar'] }}" class="rounded shadow-sm me-3" style="width:50px; height:50px; object-fit:cover;">
                                                <span class="fw-bold small">{{ $item['nama'] }}</span>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($item['harga']) }}</td>
                                        <td>
                                            <input type="number" value="{{ $item['quantity'] }}" class="form-control form-control-sm" min="1" readonly>
                                        </td>
                                        <td class="fw-bold text-success">Rp {{ number_format($subtotal) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-danger btn-sm" disabled>Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-sm btn-outline-secondary btn-sm" disabled>Kosongkan Semua</button>
                        <button class="btn btn-sm btn-secondary btn-sm" disabled>Perbarui Jumlah</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow border-0 rounded-4 bg-dark text-white p-4">
                    <h4 class="fw-bold mb-4">Ringkasan</h4>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5">Total Bayar:</span>
                        <span class="fs-5 fw-bold text-warning">Rp {{ number_format($total_belanja) }}</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-warning w-100 fw-bold rounded-pill py-2 text-center" onclick="return confirm('Apakah Anda yakin ingin memproses checkout ini?')">
                        Checkout Sekarang
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
</body>
</html>
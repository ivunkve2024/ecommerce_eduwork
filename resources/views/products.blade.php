<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - EDU Online Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f5f5f5;">

<div class="container mt-4">
    <div class="p-5 mb-4 bg-dark text-white rounded-4 shadow text-center">
        <h1 class="fw-bold">Katalog Produk</h1>
        <p class="fs-5">Temukan produk terbaik pilihan Anda</p>
        <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm mt-2">Kembali ke Beranda</a>
        <a href="{{ route('cart') }}" class="btn btn-warning btn-sm mt-2 ms-2">Lihat Keranjang</a>
    </div>

    <div class="card shadow border-0 rounded-4 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('products') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <select name="kategori" class="form-control">
                            <option value="">-- Semua Kategori --</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Fashion">Fashion</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach($products as $row)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow border-0 rounded-4">
                <img src="{{ $row['gambar'] }}" class="card-img-top" style="height:200px; object-fit:cover;">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-primary mb-2 align-self-start">{{ $row['kategori'] }}</span>
                    <h5 class="fw-bold fs-6">{{ $row['nama'] }}</h5>
                    <p class="text-success fw-bold">Rp {{ number_format($row['harga']) }}</p>
                    <p class="text-muted small">{{ $row['deskripsi'] }}</p>
                    <p class="small"><strong>Stok Tersedia:</strong> {{ $row['stok'] }}</p>
                    
                    <a href="{{ route('cart') }}" class="btn btn-dark w-100 rounded-pill btn-sm mt-auto">Beli Sekarang</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Katalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="#">My E-Commerce</a>
        </div>
    </nav>

<div class="container">
        <h2 class="mb-4 text-center">Katalog Produk Terbaru</h2>

        <div class="row mb-4 justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('home') }}" method="GET">
                    <div class="row g-2">
                        
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <label class="input-group-text" for="filterKategori">Kategori</label>
                                <select class="form-select" id="filterKategori" name="category">
                                    <option value="">Semua</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>

                    </div>
                </form>
                
                @if(request('search') || request('category'))
                    <div class="text-center mt-2">
                        <a href="{{ route('home') }}" class="btn btn-sm btn-link text-secondary text-decoration-none">
                            ✕ Bersihkan Filter
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 mb-3">
            @foreach($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 100px; object-fit: cover; background-color: #ddd;">
                        
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-secondary mb-2 align-self-start">
                                {{ $product->category ? $product->category->name : 'Tanpa Kategori' }}
                            </span>

                            <h5 class="card-title text-dark fs-6 text-truncate" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>
                            
                            <small class="text-muted mb-2">Stok: {{ $product->stock }} pcs</small>
                            
                            <p class="card-text text-danger fw-bold mt-auto mb-3">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            <div class="d-grid gap-2">
                                <a href="{{ route('detail-product', ['id' => $product->id]) }}" class="btn btn-outline-dark btn-sm">Lihat Detail</a>
                                <button class="btn btn-primary btn-sm">Tambah ke Keranjang</button>
                            </div>
                        </div>
                    </div>
                </div>         
            @endforeach
        </div>

        <div class="d-flex justify-content-center my-5">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
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
            <a class="navbar-brand fw-bold" href="{{ route('catalog') }}">My E-Commerce</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('catalog') ? 'active fw-bold' : '' }}" href="{{ route('catalog') }}">Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.index') ? 'active fw-bold' : '' }}" href="{{ route('products.index') }}">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.index') ? 'active fw-bold' : '' }}" href="{{ route('categories.index') }}">Product Category</a>
                    </li>
                </ul>

                <div class="navbar-nav ms-auto align-items-center">
                    @auth
                        <span class="nav-link text-white me-3 mb-0">Halo, {{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light me-2">Log in</a>
                        <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4 text-center">Katalog Produk Terbaru</h2>

        <div class="row mb-4">
            <div class="col-md-12">
                <form action="{{ route('catalog') }}" method="GET" id="catalogFilterForm">
                    <div class="row g-3 align-items-center">                    
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <label class="input-group-text fw-bold text-muted" for="filterKategori">Kategori</label>
                                <select class="form-select" id="filterKategori" name="category" onchange="this.form.submit()">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <label class="input-group-text fw-bold text-muted" for="sort">Sort by</label>
                                <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                                    <option value="">-- Terbaru --</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="stock_low" {{ request('sort') == 'stock_low' ? 'selected' : '' }}>Stock: Low to High</option>
                                    <option value="stock_high" {{ request('sort') == 'stock_high' ? 'selected' : '' }}>Stock: High to Low</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </div>
                </form>
                
                @if(request('search') || request('category') || request('sort'))
                    <div class="text-center mt-3">
                        <a href="{{ route('catalog') }}" class="btn btn-sm btn-light border text-secondary text-decoration-none rounded-pill px-3">
                            ✕ Bersihkan Semua Filter
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 mb-3">
            @forelse($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 140px; object-fit: cover; background-color: #ddd;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-secondary text-white card-img-top" style="height: 140px;">
                                <span class="small">No Image</span>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column p-3">
                            <span class="badge bg-secondary mb-2 align-self-start text-truncate" style="max-width: 100%;">
                                {{ $product->category ? $product->category->name : 'Tanpa Kategori' }}
                            </span>

                            <h5 class="card-title text-dark fs-6 text-truncate mb-1" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>
                            
                            <small class="text-muted mb-2 d-block">Stok: {{ $product->stock }} pcs</small>
                            
                            <p class="card-text text-danger fw-bold mt-auto mb-3">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            <div class="d-grid gap-2">
                                <a href="{{ url('/product/' . $product->id) }}" class="btn btn-outline-dark btn-sm">Lihat Detail</a>
                                <button class="btn btn-primary btn-sm">Tambah ke Keranjang</button>
                            </div>
                        </div>
                    </div>
                </div>         
            @empty
                <div class="col-12 w-100 text-center py-5 text-muted">
                    Produk tidak ditemukan atau belum ada data di database.
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
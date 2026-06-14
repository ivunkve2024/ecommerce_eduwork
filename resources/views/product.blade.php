<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - My E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">My E-Commerce</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
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
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-0">
                <div class="input-group input-group-sm" style="max-width: 250px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau deskripsi..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>

            <div class="d-flex gap-2 align-items-center">
                <form id="sortForm" action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-0">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <label for="sort" class="text-nowrap small fw-bold text-muted mb-0">Sort by:</label>
                    <select name="sort" id="sort" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width: 180px;">
                        <option value="">-- Terbaru --</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="stock_low" {{ request('sort') == 'stock_low' ? 'selected' : '' }}>Stock: Low to High</option>
                        <option value="stock_high" {{ request('sort') == 'stock_high' ? 'selected' : '' }}>Stock: High to Low</option>
                    </select>
                </form>

                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary text-nowrap">+ Tambah Produk</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3" style="width: 5%">No</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 25%">Description</th>
                                <th style="width: 12%">Price</th>
                                <th style="width: 8%">Stock</th>
                                <th style="width: 12%">Category</th>
                                <th style="width: 10%">Image</th>
                                <th class="pe-3 text-center" style="width: 8%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $index => $product)
                                <tr>
                                    <td class="ps-3 fw-bold text-secondary">
                                        {{ $products->firstItem() + $index }}
                                    </td>
                                    <td class="fw-bold text-dark">{{ $product->name }}</td>
                                    <td class="text-muted text-truncate" style="max-width: 200px;" title="{{ $product->description }}">
                                        {{ $product->description ?? '-' }}
                                    </td>
                                    <td class="text-danger fw-semibold">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->stock > 5 ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $product->stock }} pcs
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $product->category ? $product->category->name : 'Tanpa Kategori' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 120px; height: 90px; object-fit: cover;">
                                        @else
                                            <span class="text-muted small">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="d-flex flex-column gap-1 align-items-center">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning w-100" style="font-size: 0.75rem; max-width: 70px;">Edit</a>
                                            
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline w-100" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100" style="font-size: 0.75rem; max-width: 70px;">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        Belum ada data produk di dalam database.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
        
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
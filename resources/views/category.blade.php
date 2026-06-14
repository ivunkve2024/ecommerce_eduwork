<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Produk - My E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('catalog') }}">My E-Commerce</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fw-bold">⚠️ {{ session('error') }}</i>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <h2 class="fw-bold text-dark mb-0">Daftar Kategori</h2>
        
            <div class="d-flex gap-2 align-items-center">
                <form action="{{ route('categories.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-0">
                    <label for="sort" class="text-nowrap small fw-bold text-muted mb-0">Sort by:</label>
                    <select name="sort" id="sort" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width: 220px;">
                        <option value="">-- Terbaru --</option>
                        <option value="count_high" {{ request('sort') == 'count_high' ? 'selected' : '' }}>Product count: High to Low</option>
                        <option value="count_low" {{ request('sort') == 'count_low' ? 'selected' : '' }}>Product count: Low to High</option>
                        <option value="value_high" {{ request('sort') == 'value_high' ? 'selected' : '' }}>Total value: High to Low</option>
                        <option value="value_low" {{ request('sort') == 'value_low' ? 'selected' : '' }}>Total value: Low to High</option>
                        <option value="stock_high" {{ request('sort') == 'stock_high' ? 'selected' : '' }}>Total stock: High to Low</option>
                        <option value="stock_low" {{ request('sort') == 'stock_low' ? 'selected' : '' }}>Total stock: Low to High</option>
                    </select>
                </form>

                <button type="button" class="btn btn-sm btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ Tambah Kategori</button>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-sm">
                        <thead class="table-dark text-uppercase tracking-wider" style="font-size: 0.75rem;">
                            <tr>
                                <th class="px-4 py-3" style="width: 5%">No</th>
                                <th class="px-4 py-3" style="width: 25%">Name</th>
                                <th class="px-4 py-3" style="width: 20%">Slug</th>
                                <th class="px-4 py-3 text-center" style="width: 12%">Product Count</th>
                                <th class="px-4 py-3 text-center" style="width: 12%">Total Stock</th>
                                <th class="px-4 py-3" style="width: 16%">Total Value</th>
                                <th class="px-4 py-3 text-center" style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-dark">
                            @forelse($categories as $index => $category)
                                <tr>
                                    <td class="px-4 py-3 fw-bold text-muted">
                                        {{ $categories->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-3 fw-bold text-dark">{{ $category->name }}</td>
                                    <td class="px-4 py-3 text-muted"><code>{{ $category->slug }}</code></td>
                                    <td class="px-4 py-3 text-center fw-bold text-primary">
                                        {{ $category->product_count }} items
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="badge bg-light text-dark border px-2 py-1">
                                            {{ $category->total_stock ?? 0 }} pcs
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-success fw-bold">
                                        Rp {{ number_format($category->total_value ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="d-flex flex-column gap-1 align-items-center">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning w-100 py-1 edit-category-btn" 
                                                    style="font-size: 0.72rem; max-width: 65px;"
                                                    data-id="{{ $category->id }}"
                                                    data-name="{{ $category->name }}">
                                                Edit
                                            </button>
                                            
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger w-100 py-1 delete-category-btn" 
                                                    style="font-size: 0.72rem; max-width: 65px;"
                                                    data-id="{{ $category->id }}"
                                                    data-name="{{ $category->name }}">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-5 text-center text-muted fst-italic">
                                        Belum ada data kategori di dalam database.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-dark">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Elektronik, Pakaian" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-dark">Ubah Nama Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Kategori Baru</label>
                            <input type="text" name="name" id="edit_category_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger">Hapus Kategori?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteCategoryForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p class="small text-dark mb-0">Apakah Anda yakin ingin menghapus kategori <strong id="delete_category_label"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-xs btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Handler untuk Tombol Edit
        document.querySelectorAll('.edit-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                document.getElementById('edit_category_name').value = name;
                
                // PERBAIKAN: Sesuaikan action URL agar ditambah akhiran /update agar cocok dengan rute manual web.php
                document.getElementById('editCategoryForm').action = `/ecommerce_eduwork/public/categories/${id}/update`;
                
                const editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
                editModal.show();
            });
        });

        // Handler untuk Tombol Hapus
        document.querySelectorAll('.delete-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                document.getElementById('delete_category_label').innerText = name;
                
                // PERBAIKAN: Sesuaikan action URL agar ditambah akhiran /delete agar cocok dengan rute manual web.php
                document.getElementById('deleteCategoryForm').action = `/ecommerce_eduwork/public/categories/${id}/delete`;
                
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
                deleteModal.show();
            });
        });
    </script>
</body>
</html>
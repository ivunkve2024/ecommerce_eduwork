<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - My E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 p-4 bg-white">
                    <h4 class="fw-bold text-dark mb-4">Edit Data Produk</h4>
                    
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Produk</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="category_id" class="form-select">
                                <option value="">Tanpa Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->product_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label small fw-bold">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                            </div>
                            <div class="col">
                                <label class="form-label small fw-bold">Stok (Pcs)</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
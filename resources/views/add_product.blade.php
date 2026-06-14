<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - My E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
</head>
<body class="bg-light"> <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 p-4 bg-white">
                    <h4 class="fw-bold text-dark mb-4">Tambah Produk Baru</h4>
                    
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Produk</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama produk" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="category_id" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label small fw-bold">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Contoh: 15000" required>
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col">
                                <label class="form-label small fw-bold">Stok (Pcs)</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" placeholder="Contoh: 50" required>
                                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Deskripsi Produk</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Keterangan lengkap produk...">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Gambar Produk</label>
                            <input type="file" id="imageInput" class="form-control @error('image') is-invalid @enderror" accept=".jpg, .jpeg, .png, .webp">
                            
                            <input type="hidden" name="image" id="croppedImageBase64">

                            @error('image') 
                                <div class="invalid-feedback d-block">{{ $message }}</div> 
                            @enderror

                            <div class="mt-3">
                                <img id="imagePreview" class="img-thumbnail d-none" style="width: 120px; height: 90px; object-fit: cover;">
                            </div>
                        </div>

                        <div class="modal fade" id="cropperModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Potong Gambar Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnCancelCropX"></button>
                                    </div>
                                    <div class="modal-body p-0" style="max-height: 400px; overflow: hidden; background-color: #000;">
                                        <img id="imageToCrop" src="" style="max-width: 100%; display: block;">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" id="btnCancelCrop">Batal</button>
                                        <button type="button" class="btn btn-sm btn-primary" id="btnCropAndSave">Potong & Terapkan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">Simpan Produk</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <script>
        let cropper;
        const imageInput = document.getElementById('imageInput');
        const imageToCrop = document.getElementById('imageToCrop');
        const imagePreview = document.getElementById('imagePreview');
        const croppedImageBase64 = document.getElementById('croppedImageBase64');

        const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));

        imageInput.addEventListener('change', function (e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                
                reader.onload = function (event) {
                    imageToCrop.src = event.target.result;
                    cropperModal.show();
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('cropperModal').addEventListener('shown.bs.modal', function () {
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 4 / 3, 
                viewMode: 1,       
                autoCropArea: 0.8, 
            });
        });

        document.getElementById('cropperModal').addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

        document.getElementById('btnCropAndSave').addEventListener('click', function () {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 300
                });

                const base64Data = canvas.toDataURL('image/jpeg', 0.9);
                croppedImageBase64.value = base64Data;

                imagePreview.src = base64Data;
                imagePreview.classList.remove('d-none');

                cropperModal.hide();
            }
        });

        const batalkan = () => { imageInput.value = ""; cropperModal.hide(); };
        document.getElementById('btnCancelCrop').addEventListener('click', batalkan);
        document.getElementById('btnCancelCropX').addEventListener('click', batalkan);
    </script>
</body>
</html>
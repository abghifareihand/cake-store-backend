@extends('layouts.app')

@section('title', 'Edit Product')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Product</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name Product</label>
                            <input type="text" class="form-control" name="name" value="{{ $product->name }}">
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Rp
                                    </div>
                                </div>
                                <input type="number" class="form-control currency" name="price"
                                    value="{{ $product->price }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Photo Product</label>
                            <div class="col-sm-12 col-md-7">
                                <div id="image-preview" class="image-preview">
                                    @if (Str::startsWith($product->image, 'http'))
                                    <!-- Jika gambar produk adalah tautan langsung -->
                                    <img src="{{ $product->image }}" alt="Product Image"
                                        style="max-width: 250px; max-height: 250px;">
                                    @elseif ($product->image)
                                    <!-- Jika gambar produk disimpan di dalam direktori storage -->
                                    <img src="{{ asset($product->image) }}" alt="Product Image"
                                        style="max-width: 250px; max-height: 250px;">
                                    @else
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="image" id="image-upload" />
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('library/upload-preview/upload-preview.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-post-create.js') }}"></script>
@endpush

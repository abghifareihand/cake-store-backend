@extends('layouts.app')

@section('title', 'Product')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header d-flex">
            <h1>Product</h1>
            <div class="section-header-button ml-auto">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Create Product</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix mb-3"></div>
                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>

                                    @if ($products->isEmpty())
                                    <tr>
                                       <td colspan="4" class="text-center text-muted h5 font-weight-bold py-4">
                                            No products available
                                        </td>
                                    </tr>
                                    @else
                                    @foreach ($products as $product)
                                    <tr>
                                        <td class="py-3">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href='{{ route('products.edit', $product->id) }}'
                                                    class="btn btn-sm btn-info btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="ml-2">
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                        <i class="fas fa-times"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif


                                </table>
                            </div>
                            <div class="float-right">
                                {{ $products->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
@endpush

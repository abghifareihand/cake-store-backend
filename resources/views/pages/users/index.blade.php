@extends('layouts.app')

@section('title', 'Users')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
       <div class="section-header d-flex">
            <h1>User</h1>
            <div class="section-header-button ml-auto">
                <a href="#" class="btn btn-secondary">Create User</a>
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                    @foreach ($users as $user)
                                    <tr>
                                       <td>
                                        @if ($user->role == 'admin')
                                        <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle" width="35">
                                        @else
                                        <img alt="image" src="{{ asset('img/avatar/avatar-2.png') }}" class="rounded-circle" width="35">
                                        @endif
                                        <div class="d-inline-block ml-2">{{ $user->name }}</div>
                                    </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                       <td>
                                       @if ($user->role == 'admin')
                                        <div class="badge badge-primary">{{ strtoupper($user->role) }}</div>
                                        @else
                                        <div class="badge badge-success">{{ strtoupper($user->role) }}</div>
                                        @endif
                                    </td>
                                       <td>{{ \Carbon\Carbon::parse($user->created_at)->format('l, d F Y') }}</td>
                                       <td>
                                        <div class="d-flex justify-content-center">
                                            @if ($user->role !== 'admin')
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info btn-icon">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                    <i class="fas fa-times"></i> Delete
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                    </tr>
                                    @endforeach


                                </table>
                            </div>
                            <div class="float-right">
                                {{ $users->withQueryString()->links() }}
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
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush

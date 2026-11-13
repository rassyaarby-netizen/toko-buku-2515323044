
@extends('layouts.app')

@section('title', 'Edit Penulis - BookStore')

@section('content')
    <h1 class="mb-4">Edit Penulis</h1>

    <form action="{{ route('penulis.update', $penulis->id) }}" method="POST" style="max-width: 560px;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Penulis</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $penulis->name) }}"
                maxlength="100"
                required
            >

            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Negara</label>
            <input
                type="text"
                name="country"
                id="country"
                class="form-control @error('country') is-invalid @enderror"
                value="{{ old('country', $penulis->country) }}"
                maxlength="100"
            >

            @error('country')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('penulis.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection


{{-- resources/views/buku/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Daftar Buku - BookStore')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Buku</h1>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">+ Tambah Buku</a>
    </div>

    {{-- Form Pencarian dan Filter --}}
    <form action="{{ route('buku.index') }}" method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    placeholder="Cari judul atau nama penulis..."
                    value="{{ request('q') }}"
                >
            </div>

            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($daftarKategori as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="penerbit" class="form-select">
                    <option value="">Semua Penerbit</option>
                    @foreach ($daftarPenerbit as $penerbit)
                        <option value="{{ $penerbit->id }}"
                            {{ request('penerbit') == $penerbit->id ? 'selected' : '' }}>
                            {{ $penerbit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    {{-- Daftar Buku --}}
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($daftarBuku as $buku)
            <div class="col">
                <div class="card h-100 kartu-buku">
                    <img src="{{ $buku->cover_url }}" class="card-img-top" alt="Sampul {{ $buku->title }}">

                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-secondary align-self-start mb-2">
                            {{ $buku->category->name }}
                        </span>

                        <h5 class="card-title">{{ $buku->title }}</h5>

                        <p class="card-text text-muted mb-1">
                            {{ $buku->author?->name ?? $buku->author_name ?? 'Penulis belum diisi' }}
                        </p>

                        <p class="card-text small text-muted mb-1">
                            {{ $buku->publisher?->name ?? 'Penerbit belum diisi' }}
                        </p>

                        <p class="card-text harga-buku">
                            Rp{{ number_format($buku->price, 0, ',', '.') }}
                        </p>

                        @if ($buku->stock > 0)
                            <p class="small text-success mb-2">
                                Stok: {{ $buku->stock }}
                            </p>
                        @else
                            <p class="small mb-2">
                                <span class="badge bg-danger">Stok habis</span>
                            </p>
                        @endif

                        <a href="{{ url('/buku/'.$buku->id) }}"
                           class="btn btn-primary mt-auto">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    Buku tidak ditemukan.
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $daftarBuku->links() }}
    </div>
@endsection


{{-- resources/views/buku/show.blade.php --}}

@extends('layouts.app')

@section('title', ($buku->title ?? 'Buku tidak ditemukan') . ' — BookStore')

@section('content')
    @if ($buku)
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $buku->cover_url }}" class="img-fluid rounded" alt="Sampul {{ $buku->title }}">
            </div>

            <div class="col-md-8">
                <span class="badge bg-secondary mb-2">{{ $buku->category->name }}</span>

                <h1>{{ $buku->title }}</h1>

                <p class="text-muted mb-1">Penulis: {{ $buku->author_name }}</p>
                <p class="text-muted">Penerbit: {{ $buku->publisher?->name ?? 'belum diisi' }}</p>

                @if ($buku->published_year)
                    <p class="text-muted">Tahun Terbit: {{ $buku->published_year }}</p>
                @endif

                <p class="harga-buku fs-4 mb-1">
                    Rp{{ number_format($buku->price, 0, ',', '.') }}
                </p>

                @if ($buku->stock > 0)
                    <p class="mb-3">Stok: {{ $buku->stock }}</p>
                @else
                    <p class="mb-3">
                        <span class="badge bg-danger">Stok habis</span>
                    </p>
                @endif

                <a href="{{ url('/buku') }}" class="btn btn-outline-secondary">&larr; Kembali ke daftar buku</a>
                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-outline-primary">Ubah</a>

                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin menghapus buku ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                </form>
            </div>
        </div>

        <hr class="my-4">

        <h3 class="mb-3">Buku lain di kategori ini</h3>

        <div class="row">
            @forelse ($bukuSerupa as $bukuLain)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $bukuLain->title }}</h5>

                            <p class="card-text text-muted">
                                Penulis: {{ $bukuLain->author_name }}
                            </p>

                            <p class="card-text">
                                Rp{{ number_format($bukuLain->price, 0, ',', '.') }}
                            </p>

                            <a href="{{ route('buku.show', $bukuLain->id) }}"
                               class="btn btn-outline-primary btn-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada buku lain dalam kategori ini.</p>
            @endforelse
        </div>

    @else
        <div class="alert alert-warning">
            <h1 class="h4">Buku tidak ditemukan</h1>
            <p class="mb-0">Tidak ada buku dengan id {{ $id }}.</p>
        </div>

        <a href="{{ url('/buku') }}" class="btn btn-outline-secondary mt-3">&larr; Kembali ke daftar buku</a>
    @endif
@endsection

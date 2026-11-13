<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    public function index()
    {
        return view('penulis.index', [
            'daftarPenulis' => Author::withCount('books')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function create()
    {
        return view('penulis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:authors,name',
            'country' => 'nullable|string|max:100',
        ], [
            'name.required' => 'Nama penulis wajib diisi.',
            'name.max' => 'Nama penulis maksimal 100 karakter.',
            'name.unique' => 'Nama penulis ini sudah terdaftar.',
            'country.max' => 'Negara maksimal 100 karakter.',
        ]);

        Author::create($validated);

        return redirect()->route('penulis.index')
            ->with('success', 'Penulis berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('penulis.index');
    }

    public function edit(string $id)
    {
        return view('penulis.edit', [
            'penulis' => Author::findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $penulis = Author::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('authors', 'name')->ignore($penulis->id),
            ],
            'country' => 'nullable|string|max:100',
        ], [
            'name.required' => 'Nama penulis wajib diisi.',
            'name.max' => 'Nama penulis maksimal 100 karakter.',
            'name.unique' => 'Nama penulis ini sudah terdaftar.',
            'country.max' => 'Negara maksimal 100 karakter.',
        ]);

        $penulis->update($validated);

        return redirect()->route('penulis.index')
            ->with('success', 'Penulis berhasil diubah.');
    }

    public function destroy(string $id)
    {
        $penulis = Author::findOrFail($id);

        if ($penulis->books()->exists()) {
            return redirect()->route('penulis.index')
                ->with('error', 'Penulis "' . $penulis->name . '" tidak bisa dihapus karena masih dipakai oleh buku.');
        }

        try {
            $penulis->delete();
        } catch (QueryException $e) {
            if ($e->getCode() !== '23000') {
                throw $e;
            }

            return redirect()->route('penulis.index')
                ->with('error', 'Penulis tidak bisa dihapus karena masih dipakai oleh buku.');
        }

        return redirect()->route('penulis.index')
            ->with('success', 'Penulis berhasil dihapus.');
    }
}

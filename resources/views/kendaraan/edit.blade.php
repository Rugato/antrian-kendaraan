@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-xl font-bold mb-4">Edit Data Kendaraan</h2>
    <form action="{{ route('kendaraan.update', $kendaraan->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Nomor Polisi</label>
            <input type="text" name="nomor_polisi" value="{{ old('nomor_polisi', $kendaraan->nomor_polisi) }}" required
                class="w-full border border-slate-300 rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Jenis Kendaraan</label>
            <select name="jenis_kendaraan" required class="w-full border border-slate-300 rounded-lg px-3 py-2">
                <option value="Motor" {{ $kendaraan->jenis_kendaraan == 'Motor' ? 'selected' : '' }}>Motor</option>
                <option value="Mobil" {{ $kendaraan->jenis_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                <option value="Truk" {{ $kendaraan->jenis_kendaraan == 'Truk' ? 'selected' : '' }}>Truk</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Nama Pemilik</label>
            <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', $kendaraan->nama_pemilik) }}" required
                class="w-full border border-slate-300 rounded-lg px-3 py-2">
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('kendaraan.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium">Perbarui</button>
        </div>
    </form>
</div>
@endsection
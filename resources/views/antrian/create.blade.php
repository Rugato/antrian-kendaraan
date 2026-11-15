@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-xl font-bold mb-4">Tambah Antrian Kendaraan</h2>
    <form action="{{ route('antrian.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Pilih Kendaraan</label>
            <select name="kendaraan_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2">
                <option value="">-- Pilih Nomor Polisi --</option>
                @foreach($kendaraans as $k)
                    <option value="{{ $k->id }}" {{ old('kendaraan_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nomor_polisi }} - {{ $k->nama_pemilik }} ({{ $k->jenis_kendaraan }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Nomor Antrian</label>
            <input type="text" name="nomor_antrian" value="{{ old('nomor_antrian') }}" placeholder="Contoh: A-001" required
                class="w-full border border-slate-300 rounded-lg px-3 py-2">
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Waktu</label>
                <input type="time" name="waktu" value="{{ old('waktu', date('H:i')) }}" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Status Antrian</label>
            <select name="status_antrian" required class="w-full border border-slate-300 rounded-lg px-3 py-2">
                <option value="Menunggu">Menunggu</option>
                <option value="Diproses">Diproses</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('antrian.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium">Simpan</button>
        </div>
    </form>
</div>
@endsection
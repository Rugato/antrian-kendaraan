@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-xl font-bold mb-4">Edit Antrian Kendaraan</h2>
    <form action="{{ route('antrian.update', $antrian->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Pilih Kendaraan</label>
            <select name="kendaraan_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2">
                @foreach($kendaraans as $k)
                    <option value="{{ $k->id }}" {{ $antrian->kendaraan_id == $k->id ? 'selected' : '' }}>
                        {{ $k->nomor_polisi }} - {{ $k->nama_pemilik }} ({{ $k->jenis_kendaraan }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Nomor Antrian</label>
            <input type="text" name="nomor_antrian" value="{{ old('nomor_antrian', $antrian->nomor_antrian) }}" required
                class="w-full border border-slate-300 rounded-lg px-3 py-2">
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $antrian->tanggal) }}" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Waktu</label>
                <input type="time" name="waktu" value="{{ old('waktu', $antrian->waktu) }}" required
                    class="w-full border border-slate-300 rounded-lg px-3 py-2">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Status Antrian</label>
            <select name="status_antrian" required class="w-full border border-slate-300 rounded-lg px-3 py-2">
                <option value="Menunggu" {{ $antrian->status_antrian == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Diproses" {{ $antrian->status_antrian == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ $antrian->status_antrian == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('antrian.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium">Perbarui</button>
        </div>
    </form>
</div>
@endsection
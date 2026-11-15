@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h1 class="text-xl font-bold text-slate-800">Daftar Data Kendaraan</h1>
        <div class="flex gap-2">
            <!-- Tombol Cetak PDF Data Kendaraan -->
            <a href="{{ route('kendaraan.pdf') }}" target="_blank"
                class="bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Cetak PDF
            </a>
            <a href="{{ route('kendaraan.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                + Tambah Kendaraan
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-slate-100 text-slate-700 uppercase text-xs">
                <tr>
                    <th class="p-3 border">No</th>
                    <th class="p-3 border">Nomor Polisi</th>
                    <th class="p-3 border">Jenis Kendaraan</th>
                    <th class="p-3 border">Nama Pemilik</th>
                    <th class="p-3 border">Diinput Oleh (User)</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraans as $index => $item)
                <tr class="hover:bg-slate-50">
                    <td class="p-3 border">{{ $index + 1 }}</td>
                    <td class="p-3 border font-semibold">{{ $item->nomor_polisi }}</td>
                    <td class="p-3 border">{{ $item->jenis_kendaraan }}</td>
                    <td class="p-3 border">{{ $item->nama_pemilik }}</td>
                    <td class="p-3 border text-slate-500">{{ $item->user->name ?? '-' }}</td>
                    <td class="p-3 border text-center space-x-2">
                        <a href="{{ route('kendaraan.edit', $item->id) }}" class="text-amber-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('kendaraan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kendaraan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-slate-500 border">Belum ada data kendaraan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h1 class="text-xl font-bold text-slate-800">Daftar Antrian Kendaraan</h1>
        <div class="flex gap-2">
            <!-- Tombol Cetak PDF Data Antrian -->
            <a href="{{ route('antrian.pdf') }}" target="_blank"
                class="bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Cetak PDF
            </a>
            <a href="{{ route('antrian.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                + Tambah Antrian
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-slate-100 text-slate-700 uppercase text-xs">
                <tr>
                    <th class="p-3 border">No</th>
                    <th class="p-3 border">Nomor Antrian</th>
                    <th class="p-3 border">Nomor Polisi</th>
                    <th class="p-3 border">Pemilik</th>
                    <th class="p-3 border">Tanggal</th>
                    <th class="p-3 border">Waktu</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antrians as $index => $item)
                <tr class="hover:bg-slate-50">
                    <td class="p-3 border">{{ $index + 1 }}</td>
                    <td class="p-3 border font-bold text-indigo-700">{{ $item->nomor_antrian }}</td>
                    <td class="p-3 border font-semibold">{{ $item->kendaraan->nomor_polisi ?? '-' }}</td>
                    <td class="p-3 border">{{ $item->kendaraan->nama_pemilik ?? '-' }}</td>
                    <td class="p-3 border">{{ $item->tanggal }}</td>
                    <td class="p-3 border">{{ $item->waktu }}</td>
                    <td class="p-3 border">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $item->status_antrian == 'Selesai' ? 'bg-emerald-100 text-emerald-700' : ($item->status_antrian == 'Diproses' ? 'bg-amber-100 text-amber-700' : 'bg-slate-200 text-slate-700') }}">
                            {{ $item->status_antrian }}
                        </span>
                    </td>
                    <td class="p-3 border text-center space-x-2">
                        <a href="{{ route('antrian.edit', $item->id) }}" class="text-amber-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('antrian.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus antrian ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-4 text-center text-slate-500 border">Belum ada data antrian kendaraan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

class AntrianController extends Controller
{
    // READ: Menampilkan seluruh daftar antrian beserta relasi kendaraan
    public function index()
    {
        $antrians = Antrian::with('kendaraan')->latest()->get();
        return view('antrian.index', compact('antrians'));
    }

    // Menampilkan form tambah antrian dengan pilihan kendaraan yang terdaftar
    public function create()
    {
        $kendaraans = Kendaraan::orderBy('nomor_polisi')->get();
        return view('antrian.create', compact('kendaraans'));
    }

    // CREATE: Validasi dan simpan data antrian baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'nomor_antrian' => 'required|string|max:20',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'status_antrian' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        Antrian::create($validated);
        return redirect()->route('antrian.index')->with('success', 'Data antrian berhasil ditambahkan.');
    }

    // Menampilkan form edit antrian
    public function edit(Antrian $antrian)
    {
        $kendaraans = Kendaraan::orderBy('nomor_polisi')->get();
        return view('antrian.edit', compact('antrian', 'kendaraans'));
    }

    // UPDATE: Validasi dan perbarui data antrian
    public function update(Request $request, Antrian $antrian)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'nomor_antrian' => 'required|string|max:20',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'status_antrian' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        $antrian->update($validated);
        return redirect()->route('antrian.index')->with('success', 'Data antrian berhasil diperbarui.');
    }

    // DELETE: Menghapus data antrian
    public function destroy(Antrian $antrian)
    {
        $antrian->delete();
        return redirect()->route('antrian.index')->with('success', 'Data antrian berhasil dihapus.');
    }

    // LAPORAN PDF: Menghasilkan laporan PDF Data Antrian Kendaraan menggunakan FPDF
    public function cetakPdf()
    {
        $antrians = Antrian::with('kendaraan')->get();

        $pdf = new Fpdf('P', 'mm', 'A4');
        $pdf->AddPage();

        // 1. Judul Laporan
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'LAPORAN ANTRIAN KENDARAAN', 0, 1, 'C');

        // 2. Tanggal Cetak
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(190, 6, 'Tanggal Cetak: ' . date('d-m-Y H:i') . ' WIB', 0, 1, 'C');
        $pdf->Ln(6);

        // 3. Header Tabel Data
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(220, 230, 241);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
        $pdf->Cell(28, 8, 'No. Antrian', 1, 0, 'C', true);
        $pdf->Cell(32, 8, 'Nomor Polisi', 1, 0, 'C', true);
        $pdf->Cell(45, 8, 'Nama Pemilik', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'Tanggal', 1, 0, 'C', true);
        $pdf->Cell(22, 8, 'Waktu', 1, 0, 'C', true);
        $pdf->Cell(28, 8, 'Status', 1, 1, 'C', true);

        // Isi Tabel Data
        $pdf->SetFont('Arial', '', 9);
        $no = 1;
        foreach ($antrians as $item) {
            $pdf->Cell(10, 8, $no++, 1, 0, 'C');
            $pdf->Cell(28, 8, $item->nomor_antrian, 1, 0, 'C');
            $pdf->Cell(32, 8, $item->kendaraan->nomor_polisi ?? '-', 1, 0, 'C');
            $pdf->Cell(45, 8, $item->kendaraan->nama_pemilik ?? '-', 1, 0, 'L');
            $pdf->Cell(25, 8, $item->tanggal, 1, 0, 'C');
            $pdf->Cell(22, 8, $item->waktu, 1, 0, 'C');
            $pdf->Cell(28, 8, $item->status_antrian, 1, 1, 'C');
        }

        // 4. Jumlah Data
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 8, 'Total Jumlah Data Antrian: ' . $antrians->count() . ' antrian', 0, 1, 'L');

        // Output PDF ke browser
        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="laporan_antrian_kendaraan.pdf"');
    }
}
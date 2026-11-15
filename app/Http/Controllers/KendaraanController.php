<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Codedge\Fpdf\Fpdf\Fpdf;

class KendaraanController extends Controller
{
    // READ: Menampilkan seluruh daftar kendaraan beserta relasi user
    public function index()
    {
        $kendaraans = Kendaraan::with('user')->latest()->get();
        return view('kendaraan.index', compact('kendaraans'));
    }

    // Menampilkan form tambah kendaraan
    public function create()
    {
        return view('kendaraan.create');
    }

    // CREATE: Validasi dan simpan data kendaraan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_polisi' => 'required|string|max:20|unique:kendaraans,nomor_polisi',
            'jenis_kendaraan' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:100',
        ]);

        // Menyisipkan ID user yang sedang login untuk menjaga relasi tabel users
        $validated['user_id'] = Auth::id();
        $validated['nomor_polisi'] = strtoupper($validated['nomor_polisi']);

        Kendaraan::create($validated);
        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    // Menampilkan form edit kendaraan
    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit', compact('kendaraan'));
    }

    // UPDATE: Validasi dan perbarui data kendaraan
    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'nomor_polisi' => 'required|string|max:20|unique:kendaraans,nomor_polisi,' . $kendaraan->id,
            'jenis_kendaraan' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:100',
        ]);

        $validated['nomor_polisi'] = strtoupper($validated['nomor_polisi']);
        $kendaraan->update($validated);

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    // DELETE: Menghapus data kendaraan
    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();
        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil dihapus.');
    }

    // LAPORAN PDF: Menghasilkan laporan PDF Data Kendaraan menggunakan FPDF
    public function cetakPdf()
    {
        $kendaraans = Kendaraan::with('user')->get();

        $pdf = new Fpdf('P', 'mm', 'A4');
        $pdf->AddPage();

        // 1. Judul Laporan
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'LAPORAN DATA KENDARAAN', 0, 1, 'C');

        // 2. Tanggal Cetak
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(190, 6, 'Tanggal Cetak: ' . date('d-m-Y H:i') . ' WIB', 0, 1, 'C');
        $pdf->Ln(6);

        // 3. Header Tabel Data
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(220, 230, 241);
        $pdf->Cell(12, 8, 'No', 1, 0, 'C', true);
        $pdf->Cell(38, 8, 'Nomor Polisi', 1, 0, 'C', true);
        $pdf->Cell(35, 8, 'Jenis Kendaraan', 1, 0, 'C', true);
        $pdf->Cell(60, 8, 'Nama Pemilik', 1, 0, 'C', true);
        $pdf->Cell(45, 8, 'Diinput Oleh', 1, 1, 'C', true);

        // Isi Tabel Data
        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        foreach ($kendaraans as $item) {
            $pdf->Cell(12, 8, $no++, 1, 0, 'C');
            $pdf->Cell(38, 8, $item->nomor_polisi, 1, 0, 'C');
            $pdf->Cell(35, 8, $item->jenis_kendaraan, 1, 0, 'C');
            $pdf->Cell(60, 8, $item->nama_pemilik, 1, 0, 'L');
            $pdf->Cell(45, 8, $item->user->name ?? '-', 1, 1, 'L');
        }

        // 4. Jumlah Data
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 8, 'Total Jumlah Data Kendaraan: ' . $kendaraans->count() . ' unit', 0, 1, 'L');

        // Output PDF ke browser
        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="laporan_kendaraan.pdf"');
    }
}
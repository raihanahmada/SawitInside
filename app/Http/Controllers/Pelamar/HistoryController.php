<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use App\Models\PelamarProfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();

    // Jika belum punya profil pelamar
    if (!$user->pelamar_profil) {
        return redirect()->route('pelamar.datadiry')
            ->with('warning', 'Silakan lengkapi profil terlebih dahulu untuk melihat history lamaran.');
    }

    $pelamarProfil = $user->pelamar_profil;

    // Query dengan eager loading
    $query = Lamaran::with(['lowongan' => function($query) {
        $query->with('pemilik');
    }])->where('pelamar_id', $pelamarProfil->id);

    // Filter berdasarkan status
    if ($request->filled('status')) {
        $query->where('status_lamaran', $request->status);
    }

    // Sorting
    $sort = $request->input('sort', 'terbaru');
    if ($sort === 'terlama') {
        $query->orderBy('created_at', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    // Pagination
    $lamarans = $query->paginate(10)->withQueryString();

    // Hitung statistik - GUNAKAN VARIABLE LAMA
    $totalLamaran = Lamaran::where('pelamar_id', $pelamarProfil->id)->count();
    $pendingLamaran = Lamaran::where('pelamar_id', $pelamarProfil->id)
        ->where('status_lamaran', 'menunggu')->count();
    $diprosesLamaran = Lamaran::where('pelamar_id', $pelamarProfil->id)
        ->where('status_lamaran', 'diproses')->count();
    $diterimaLamaran = Lamaran::where('pelamar_id', $pelamarProfil->id)
        ->where('status_lamaran', 'diterima')->count();
    $ditolakLamaran = Lamaran::where('pelamar_id', $pelamarProfil->id)
        ->where('status_lamaran', 'ditolak')->count();

    return view('pelamar.history', compact(
        'lamarans',
        'totalLamaran',
        'pendingLamaran', // INI VARIABLE YANG DIPAKAI VIEW
        'diprosesLamaran',
        'diterimaLamaran',
        'ditolakLamaran'
    ));
}

    /**
     * Detail lamaran
     */
    public function show($id)
    {
        $user = Auth::user();

        if (!$user->pelamar_profil) {
            return redirect()->route('pelamar.datadiry')
                ->with('error', 'Silakan lengkapi profil terlebih dahulu');
        }

        $lamaran = Lamaran::with(['lowongan' => function($query) {
            $query->with(['pemilik' => function($q) {
                $q->with('user');
            }]);
        }])->where('pelamar_id', $user->pelamar_profil->id)
          ->findOrFail($id);

        return view('pelamar.history-detail', compact('lamaran'));
    }

    /**
     * Export history (PDF/Excel)
     */
    public function export(Request $request)
    {
        $user = Auth::user();

        if (!$user->pelamar_profil) {
            return back()->with('error', 'Silakan lengkapi profil terlebih dahulu');
        }

        $lamarans = Lamaran::with(['lowongan' => function($query) {
            $query->with('pemilik');
        }])->where('pelamar_id', $user->pelamar_profil->id)
          ->orderBy('created_at', 'desc')
          ->get();

        $format = $request->format ?? 'pdf';

        if ($format === 'excel') {
            // Return Excel file
            // return Excel::download(new HistoryExport($lamarans), 'history-lamaran.xlsx');
            return back()->with('info', 'Fitur export Excel akan segera tersedia.');
        }

        // Return PDF
        // $pdf = PDF::loadView('pelamar.export.history-pdf', compact('lamarans'));
        // return $pdf->download('history-lamaran.pdf');
        return back()->with('info', 'Fitur export PDF akan segera tersedia.');
    }

    /**
     * Get statistik lamaran (API)
     */
    public function getStatistik()
    {
        $user = Auth::user();

        if (!$user->pelamar_profil) {
            return response()->json(['error' => 'Profil tidak ditemukan'], 404);
        }

        $pelamarProfil = $user->pelamar_profil;

        $statistik = [
            'total' => Lamaran::where('pelamar_id', $pelamarProfil->id)->count(),
            'menunggu' => Lamaran::where('pelamar_id', $pelamarProfil->id)
                ->where('status_lamaran', 'menunggu')->count(),
            'diproses' => Lamaran::where('pelamar_id', $pelamarProfil->id)
                ->where('status_lamaran', 'diproses')->count(),
            'diterima' => Lamaran::where('pelamar_id', $pelamarProfil->id)
                ->where('status_lamaran', 'diterima')->count(),
            'ditolak' => Lamaran::where('pelamar_id', $pelamarProfil->id)
                ->where('status_lamaran', 'ditolak')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $statistik
        ]);
    }

    /**
     * Hapus lamaran (soft delete)
     */
    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user->pelamar_profil) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $lamaran = Lamaran::where('pelamar_id', $user->pelamar_profil->id)
            ->where('id', $id)
            ->first();

        if (!$lamaran) {
            return response()->json(['error' => 'Lamaran tidak ditemukan'], 404);
        }

        // Hanya bisa hapus jika status masih menunggu
        if ($lamaran->status_lamaran !== 'menunggu') {
            return response()->json([
                'error' => 'Lamaran tidak dapat dihapus karena status sudah berubah'
            ], 400);
        }

        $lamaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dihapus'
        ]);
    }
}

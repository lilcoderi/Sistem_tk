<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LingkupPerkembangan;
use App\Models\Kurikulum; // Impor Model Kurikulum
use Illuminate\Validation\ValidationException; // Untuk menangani error validasi lebih baik

class LingkupPerkembanganController extends Controller
{
    public function index(Request $request)
    {
        $query = LingkupPerkembangan::query();

        // Sort by nama_lingkup ascending/descending
        if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('nama_lingkup', $request->sort);
        }

        // Filter by kurikulum_id
        if ($request->has('filter_kurikulum') && $request->get('filter_kurikulum') != '') {
            $query->where('kurikulum_id', $request->get('filter_kurikulum'));
        }

        // Eager load the 'kurikulum' relationship to avoid N+1 query problem
        $data = $query->with('kurikulum')->paginate(6)->appends($request->query());

        // Get all kurikulums for the filter dropdown in the view
        $kurikulums = Kurikulum::orderBy('tahun', 'desc')->orderBy('nama', 'asc')->get();

        return view('kepala_sekolah.penilaian.lingkup.index', compact('data', 'kurikulums'));
    }

    public function create()
    {
        // Pass all kurikulums to the view so the user can select one
        $kurikulums = Kurikulum::orderBy('tahun', 'desc')->orderBy('nama', 'asc')->get();
        return view('kepala_sekolah.penilaian.lingkup.create', compact('kurikulums'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_lingkup' => 'required|string|max:255',
                'kurikulum_id' => 'required|exists:kurikulum,id', // Validasi kurikulum_id
                'tujuan_pembelajaran' => 'nullable|string',
                'deskripsi' => 'required|string',
            ], [
                'nama_lingkup.required' => 'Nama lingkup perkembangan wajib diisi.',
                'kurikulum_id.required' => 'Kurikulum wajib dipilih.',
                'kurikulum_id.exists' => 'Kurikulum yang dipilih tidak valid.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
            ]);

            LingkupPerkembangan::create([
                'nama_lingkup' => $request->nama_lingkup,
                'kurikulum_id' => $request->kurikulum_id,
                'tujuan_pembelajaran' => $request->tujuan_pembelajaran,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect()->route('lingkup.index')->with('success', 'Data lingkup perkembangan berhasil disimpan.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Gagal menambahkan lingkup perkembangan. Mohon periksa kembali input Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $lingkup = LingkupPerkembangan::with('kurikulum')->findOrFail($id); // Eager load kurikulum
        return view('kepala_sekolah.penilaian.lingkup.detail', compact('lingkup'));
    }

    public function edit($id)
    {
        $lingkup = LingkupPerkembangan::findOrFail($id);
        $kurikulums = Kurikulum::orderBy('tahun', 'desc')->orderBy('nama', 'asc')->get(); // Pass all kurikulums for selection
        return view('kepala_sekolah.penilaian.lingkup.edit', compact('lingkup', 'kurikulums'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_lingkup' => 'required|string|max:255',
                'kurikulum_id' => 'required|exists:kurikulum,id', // Validasi kurikulum_id
                'tujuan_pembelajaran' => 'nullable|string',
                'deskripsi' => 'required|string',
            ], [
                'nama_lingkup.required' => 'Nama lingkup perkembangan wajib diisi.',
                'kurikulum_id.required' => 'Kurikulum wajib dipilih.',
                'kurikulum_id.exists' => 'Kurikulum yang dipilih tidak valid.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
            ]);

            $lingkup = LingkupPerkembangan::findOrFail($id);
            $lingkup->update([
                'nama_lingkup' => $request->nama_lingkup,
                'kurikulum_id' => $request->kurikulum_id,
                'tujuan_pembelajaran' => $request->tujuan_pembelajaran,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect()->route('lingkup.index')->with('success', 'Data lingkup perkembangan berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Gagal memperbarui lingkup perkembangan. Mohon periksa kembali input Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $lingkup = LingkupPerkembangan::findOrFail($id);
            $lingkup->delete();

            return redirect()->route('lingkup.index')->with('success', 'Data lingkup perkembangan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
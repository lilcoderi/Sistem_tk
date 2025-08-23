<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum; // Pastikan Anda mengimpor Model Kurikulum
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // Untuk menangani error validasi lebih baik

class KurikulumController extends Controller
{
    /**
     * Menampilkan daftar semua kurikulum.
     * Dalam kasus ini, mungkin tidak digunakan secara langsung sebagai halaman,
     * tetapi bisa jadi untuk keperluan API atau debug.
     * Jika Anda hanya ingin daftar kurikulum untuk dropdown, ambil saja di controller lain.
     */
    public function index()
    {
        $kurikulums = Kurikulum::orderBy('tahun', 'desc')->orderBy('nama', 'asc')->get();
        // Anda mungkin tidak butuh view ini jika kurikulum hanya dikelola via modal
        return view('kurikulum.index', compact('kurikulums'));
    }

    /**
     * Menampilkan form untuk membuat kurikulum baru.
     * Dalam kasus ini, form ada di modal, jadi method ini mungkin tidak perlu.
     */
    public function create()
    {
        // Karena form penambahan kurikulum ada di modal, method ini mungkin tidak diperlukan
        // atau bisa digunakan untuk merender view modal secara terpisah jika diperlukan.
        return view('kurikulum.create');
    }

    /**
     * Menyimpan kurikulum baru ke database.
     * Ini adalah method yang akan dipanggil dari modal form di view lingkup_perkembangan.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                // Validasi unik gabungan nama dan tahun.
                // 'unique:table,column,except_id,id_column,additional_column,additional_value'
                // NULL,id di sini berarti tidak ada id yang dikecualikan (untuk operasi create)
                'nama' => 'required|string|max:255|unique:kurikulum,nama,NULL,id,tahun,' . $request->tahun,
                'tahun' => 'required|integer|min:1900|max:2100',
            ], [
                // Pesan validasi kustom
                'nama.required' => 'Nama kurikulum wajib diisi.',
                'nama.unique' => 'Kurikulum dengan nama dan tahun yang sama sudah ada.',
                'tahun.required' => 'Tahun kurikulum wajib diisi.',
                'tahun.integer' => 'Tahun kurikulum harus berupa angka.',
                'tahun.min' => 'Tahun kurikulum minimal :min.',
                'tahun.max' => 'Tahun kurikulum maksimal :max.',
            ]);

            Kurikulum::create([
                'nama' => $request->nama,
                'tahun' => $request->tahun,
            ]);

            // Redirect kembali ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with('success', 'Kurikulum berhasil ditambahkan!');
        } catch (ValidationException $e) {
            // Jika validasi gagal, kembalikan dengan error dan input sebelumnya
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Gagal menambahkan kurikulum. Mohon periksa kembali input Anda.');
        } catch (\Exception $e) {
            // Tangani error lain yang mungkin terjadi
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan kurikulum: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail kurikulum tertentu.
     */
    public function show(Kurikulum $kurikulum)
    {
        return view('kurikulum.show', compact('kurikulum'));
    }

    /**
     * Menampilkan form untuk mengedit kurikulum tertentu.
     */
    public function edit(Kurikulum $kurikulum)
    {
        return view('kurikulum.edit', compact('kurikulum'));
    }

    /**
     * Memperbarui kurikulum di database.
     */
    public function update(Request $request, Kurikulum $kurikulum)
    {
        try {
            $request->validate([
                // Validasi unik gabungan nama dan tahun untuk update.
                // $kurikulum->id digunakan untuk mengecualikan kurikulum yang sedang diedit.
                'nama' => 'required|string|max:255|unique:kurikulum,nama,' . $kurikulum->id . ',id,tahun,' . $request->tahun,
                'tahun' => 'required|integer|min:1900|max:2100',
            ], [
                'nama.required' => 'Nama kurikulum wajib diisi.',
                'nama.unique' => 'Kurikulum dengan nama dan tahun yang sama sudah ada.',
                'tahun.required' => 'Tahun kurikulum wajib diisi.',
                'tahun.integer' => 'Tahun kurikulum harus berupa angka.',
                'tahun.min' => 'Tahun kurikulum minimal :min.',
                'tahun.max' => 'Tahun kurikulum maksimal :max.',
            ]);

            $kurikulum->update([
                'nama' => $request->nama,
                'tahun' => $request->tahun,
            ]);

            // Redirect ke halaman index lingkup perkembangan dengan pesan sukses
            return redirect()->route('lingkup.index')->with('success', 'Kurikulum berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Gagal memperbarui kurikulum. Mohon periksa kembali input Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui kurikulum: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus kurikulum dari database.
     */
    public function destroy(Kurikulum $kurikulum)
    {
        try {
            // Sebelum menghapus kurikulum, pastikan tidak ada lingkup perkembangan yang menggunakannya.
            // Ini penting untuk menjaga integritas data jika foreign key constraint di database adalah RESTRICT.
            // Metode lingkupPerkembangans() mengasumsikan ada relasi hasMany di Model Kurikulum.
            if ($kurikulum->lingkupPerkembangans()->count() > 0) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus kurikulum karena masih ada lingkup perkembangan yang menggunakannya.');
            }

            $kurikulum->delete();
            return redirect()->route('lingkup.index')->with('success', 'Kurikulum berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kurikulum: ' . $e->getMessage());
        }
    }
}
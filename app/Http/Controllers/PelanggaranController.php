<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class PelanggaranController extends Controller
{
    public function index(): View
    {
        $pelanggarans = Pelanggaran::latest()->paginate(10);

        if (request('cari')) {
            $pelanggarans = $this->search(request('cari'));
        }


        return view('admin.pelanggaran.index', compact('pelanggarans'));
    }

    public function search(string $cari)
    {
        $pelanggarans = DB::table('pelanggarans')->where(DB::raw('lower(jenis)'), 'like', '%' . strtolower($cari) . '%')->paginate(10);
        return $pelanggarans;
    }

    public function create()
    {
        return view('admin.pelanggaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string|max:250',
            'konsekuensi' => 'required|string|max:250',
            'poin' => 'required',
        ]);

        Pelanggaran::create([
            'jenis' => $request->jenis,
            'konsekuensi' => $request->konsekuensi,
            'poin' => $request->poin
        ]);
        return redirect()->route('pelanggaran.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id): View
    {
        $pelanggaran = Pelanggaran::where('id', $id)
        ->first();

        return view('admin.pelanggaran.edit', compact('pelanggaran'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:250',
            'konsekuensi' => 'required|string|max:250',
            'poin' => 'required'
        ]);

        $datas = Pelanggaran::findOrFail($id);

        $datas->update([
            'jenis'=> $request->jenis,
            'konsekuensi'=> $request->konsekuensi,
            'poin'=> $request->poin
            
        ]);
        return redirect()->route('pelanggaran.index', $id)->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        $post = Pelanggaran::findOrFail($id);

        $post->delete();
        return redirect()->route('pelanggaran.index')->with(['success' => 'Pelanggaran Berhasil Dihapus!']);
    }
}

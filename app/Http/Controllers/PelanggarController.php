<?php

namespace App\Http\Controllers;

use App\Models\Pelanggar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailPelanggaran;


class PelanggarController extends Controller
{
    //get data db
    public function index(): View
    {
        $id_pelanggars = DB::table('pelanggars')->pluck('id_siswa')->toArray();

        $pelanggars = DB::table('pelanggars')
        ->join('siswas', 'pelanggars.id_user','=', 'siswas.id')
        ->join('users', 'siswas.id_user', '=', 'users.id')
        ->select(
            'pelanggars.*',
            'siswas.image',
            'siswas.nis',
            'siswas.tingkatan',
            'siswas.jurusan',
            'siswas.kelas',
            'siswas.hp',
            'users.name',
            'users.email'
        )->whereIn('siswas.id', $id_pelanggars)
        ->latest()->paginate(10);

        if (request('cari')) {
            $pelanggars = $this->searchPelanggar(request('cari'), $id_pelanggars);
        }
        return view('admin.pelanggar.index', compact('pelanggars'));
    }

    public function searchPelanggar(string $cari, $id)
    {
        $pelanggars = DB::table('pelanggars')
        ->join('siswas', 'pelanggars.id_user','=', 'siswas.id')
        ->join('users', 'siswas.id_user', '=', 'users.id')
        ->select(
            'pelanggars.*',
            'siswas.image',
            'siswas.nis',
            'siswas.tingkatan',
            'siswas.jurusan',
            'siswas.kelas',
            'siswas.hp',
            'users.name',
            'users.email'
        )->whereIn('siswas.id', $id)
        ->latest()
        ->where('users.name', 'like', '%' . $cari . '%')
        ->orwhere('siswas.nis', 'like', '%' . $cari . '%')
        ->paginate(10);

        return $pelanggars;
    }

    public function create(): View
    {
        $id_pelanggars = DB::table('pelanggars')->pluck('id_siswa')->toArray();

        $siswas = DB::table('siswas')
        ->join('users', 'siswas.id_user', '=', 'users.id')
        ->select(
            'siswas.*',
            'users.name',
            'users.email'
        )->whereNotIn('siswas.id', $id_pelanggars)
        ->latest()
        ->paginate(10);

        if (request('cari')) {
            $siswas = $this->searchSiswa(request('cari'), $id_pelanggars);
        }
        return view('admin.pelanggar.create', compact('siswas'));
    }

    public function searchSiswa(string $cari, $id)
    {
        $siswas = DB::table('siswas')
        ->join('users', 'siswas.id_user', '=', 'users.id')
        ->select(
            'siswas.*',
            'users.name',
            'users.email'
        )->whereNotIn('siswas.id', $id)
        ->latest()
        ->where('users.name', 'like', '%' . $cari . '%')
        ->orWhere('users.nis', 'like', '%' . $cari . '%')
        ->paginate(10);

        return $siswas;
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required'
        ]);

        Pelanggar::create([
            'id_siswa' => $request->id_siswa,
            'poin_pelanggar' => 0,
            'status_pelanggar' => 0,
            'status' => 0
        ]);

        $idPelanggar = Pelanggar::where('id_siswa', $request->$id_siswa)->value('id');

        return redirect()->route('pelanggar.show', $idPelanggar);
    }

    public function show(string $id)
    {
        //get data db
        $pelanggar = DB::table('pelanggars')
        ->join('siswas', 'pelanggars.id_siswa', '=', 'siswa.id')
        ->joim('users', 'siswas.id_user', '=', 'users.id')
        ->select(
            'pelanggars.*',
            'siswas.image',
            'siswas.nis',
            'siswas.tingkatan',
            'siswas.jurusan',
            'siswas.kelas',
            'siswas.hp',
            'siswas.status',
            'users.name',
            'users.email'
        )
        ->where('pelanggars.id', $id)
        ->first();

        $pelanggarans = DB::table('pelanggarans')->latest()->paginate(10);

        if(request('cari')) {
            $pelanggarans = $this->searchPelanggaran(request('cari'));
        }

        $idUser = Auth::id();

        return view('admin.pelanggar.show', compact('pelanggar', 'pelanggarans', 'idUser'));
    }

    public function searchPelanggaran(string $cari)
    {
        $pelanggarans = DB::table('pelanggarans')->where(DB::raw('lower(jenis'), 'like', '%' . strtolower($cari) . '%')->paginate(10);
        return $pelanggarans;
    }

    public function storePelanggaran(request $request)
    {
        $validated = $request->validate([
            'id_pelanggar' =>'required',
            'id_user' =>'required',
            'id_pelanggaran' =>'required'
        ]);
        $this->updatePoin($request->id_pelanggaran, $request->id_pelanggar);

        return redirect()->route("setailPelanggar.show", $request->id_pelanggar)->with(['success' => 'DataBerhasil Disimpan']);
    }

    public function updatePoin(string $id_pelanggaran, string $id_pelanggar)
    {
        $poin = $this->calculatedPoin($id_pelanggaran, $id_pelanggar);
        $datas = Pelanggar::findorFail($id_pelanggar);

        $datas->update([
            'poin_pelanggar' => $poin
        ]);

        $this->updateStatus($datas, $poin);
    }

    public function calculatedPoin(string  $id_pelanggaran, string $id_pelanggar)
    {
        $poin_pelanggaran = DB::table('pelanggarans')->where('id', $id_pelanggaran)->value('poin');
        $poin_pelanggar = DB::table('pelanggars')->where('id', $id_pelanggar)->value('poin_pelanggar');
        $poin = $poin_pelanggar + $poin_pelanggaran;

        return $poin;
    }

}

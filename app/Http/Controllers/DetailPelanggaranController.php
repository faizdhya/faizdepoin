<?php

namespace App\Http\Controllers;

use App\Models\DetailPelanggaran;
use App\Models\Pelanggar;
use App\Models\Pelanggaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class DetailPelanggaranController extends Controller
{
    public function show(string $id): View
    {
      $details = DB::table('details_pelanggaran')
      ->join('pelanggars' , 'detail_pelanggarans.id_pelanggar', '=', 'pelanggars.id')
      ->join('pelanggarans' , 'setail_pelanggarans.id_pelanggaran' , '=' , 'pelanggarans.id')
      ->join('users' , 'detail_pelanggarans.id_users' , '=' , 'users.id')
      ->select(
        'deail_pelanggarans.*',
        'pelanggars.id_siswa',
        'pelanggars.poin_pelanggar',
        'pelanggars.jenis',
        'pelanggars.konsekuensi',
        'pelanggars.poin',
        'users.name'
      )->where('detail_pelanggarans.id_pelanggar' , $id)
      ->latest()
      ->paginate(10);

      $pelanggar = DB::table('pelanggars')
      ->join('siswas' , 'pelanggars.id_user' , '=' , 'siswas.id')
      ->join('users' , 'siswas.id_user' , '=' , 'users.id')
      ->select(
        'pelanggars.*',
        'siswas.image',
        'siswas.nis',
        'siswas.tingkatan',
        'siswas.jurusan',
        'siswas.kelas',
        'siswas.hp',
        'siswas.name',
        'siswas.email',
      )
      ->where('pelanggars.id' , $id)
      ->first();
      return view('admin.detail.show' , compact('details' , 'pelanggar'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
      $datas = DetailPelanggaran::findOrFail($id);

      $datas->update([
        'status' => 1
      ]);
      return redirect('detailPelanggar.show' , $request->id_pelanggar)->with(['success' => 'Siswa Telah Diberikan!']);
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
      $this->deletePoin($request->id_pelanggar, $request->id_pelanggaran);

      $post = Pelanggaran::findOrFail($id);

      $post->delete();

      return redirect()->route('detailPelanggar.show', $request->id_pelanggar)->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function deletePoin($id_pelanggar, $poin_pelanggaran)
    {
      $poin_pelanggar = pelanggar::where('id', $id_pelanggar)->value('poin_pelanggar');
      $poin = $poin_pelanggar - $poin_pelanggaran;

      $pelanggar = pelanggar::findOrFail($id_pelanggar);

      $pelanggar->update([
        'poin_pelanggar' => $poin
      ]);
    }

    
}

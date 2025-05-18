<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show</title>


</head>
<body>
    <style type="text/css">
        table {
            border-collapse: collapse;
            margin: 20px 0px;
            text-align: left;
        }

        table,
        th,
        td {
            border: 1px solid;
            text-align: left;
            padding-right: 20px;
        }
    </style>

    <h1>Detail Siswa</h1>
    <a href="{{ route('pelanggar.index') }}">Kembali</a>

    <table>
        <tr>
            <td colspan="4" style="text-align: center;"><img src="{{ asset('storage/siswas/'.$pelanggar->image) }}" width="120px" hight="120px"alt=""></td>
        </tr>
        <tr>
            <th colspan="2">Akun Pelanggar</th>
            <th colspan="2">Data Pelanggar</th>
        </tr>
        <tr>
            <th>Nama</th>
            <td>: {{ $pelanggar->name }}</td>
            <th>Nis</th>
            <td>: {{ $pelanggar->nis }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>: {{ $pelanggar->email }}</td>
            <th>Kelas</th>
            <td>: {{ $pelanggar->tingkatan }}  {{ $pelanggar->jurusan }} {{ $pelanggar->kelas }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <th>No HP</th>
            <td>: {{ $pelanggar->hp }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <th>Status</th>
            @if($pelanggar->status == 1) :
            <td>: Aktif</td>
            @else
            <td>Tidak Ktif</td>
            @endif
        </tr>
    </table>
    <br><br>
    <h1>Pilih Pelanggar</h1>
    <form action="" method="get">
      <label>Cari :</label>
      <input type="text" name="cari">
      <input type="submit" value="Cari">
  </form>
  <br><br>
  @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
    </div>
    @endif

    <table class="tabel">
      <tr>
        <th>Jenis</th>
        <th>Konsekuensi</th>
        <th>Poin</th>
        <th>Aksi</th>
      </tr>
        @forelse ($pelanggarans as $pelanggaran)
      <tr>
        <td>{{ $pelanggaran->jenis }}</td>
        <td>{{ $pelanggaran->konsekuensi }}</td>
        <td>{{ $pelanggaran->poin }}</td>
        <td>
          <form action="{{ route('pelanggar.storePelanggaran' , $pelanggar->id) }}" method="POST">
            @csrf
            <input type="hidden" name="id_pelanggar" value="{{ $pelanggar->id }}">
            <input type="hidden" name="id_user" value="{{ $idUser }}">
            <input type="hidden" name="id_pelanggaran" value="{{ $pelanggaran->id }}">
            <button type="submit">Tambah Pelanggaran</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td>
          <p>Data tidak ditemukan</p>
        </td>
        <td>
          <a href="{{ route('pelanggaran.index') }}">Kembali</a>
        </td>
      </tr>
      @endforelse
    </table>
    {{ $pelanggarans->links() }}
</body>
</html>
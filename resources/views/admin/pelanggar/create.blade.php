<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
</head>
<body>
    <h1>Pilih Data Pelanggar</h1>
    <a href="{{ route('pelanggar.index') }}">Kembali</a><br><br>

    <form id="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf
  </form>
  <br><br>
  <form action="" method="get">
      <label>Cari :</label>
      <input type="text" name="cari">
      <input type="submit" value="Cari">
  </form>
  <br><br>

  <table class="tabel">
    <tr>
      <th>Foto</th>
      <th>NIS</th>
      <th>Nama</th>
      <th>Kelas</th>
      <th>No Hp</th>
      <th>Aksi</th>
    </tr>
    @forelse ($siswas as $siswa)
    <tr>
      <td>
        <img src="{{ asset('storage/siswas/'.$siswa->image) }}" width="120px" height="120px" alt="">
      </td>
      <td>{{ $pelanggar->nis }}</td>
      <td>{{ $pelanggar->name }}</td>
      <td>{{ $pelanggar->tingkatan }} {{ $pelanggar->jurusan }} {{ $pelanggar->kelas }}</td>
      <td>{{ $pelanggar->hp }}</td>
      <td>
        <form action="{{ route('pelanggar.store') }}" method="POST">
          @csrf
          <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">
          <button type="submit">Tambah Pelanggaran</button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <td>
        <p>Data tidak ditemukan, silahkan cek pada data pelanggar</p>
      </td>
      <td>
        <a href="{{ route('pelanggar.index') }}">Data Pelanggar</a>||||||<a href="{{ route('pelanggar.create') }}">kembali</a>
      </td>
    </tr>
    @endforelse
  </table>
  {{ $siswas->links() }}
    
</body>
</html>
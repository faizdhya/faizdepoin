<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <a class="nav-link" href="{{ route('siswa.index') }}">Data Siswa</a>
    <a class="nav-link" href="{{ route('akun.index') }}">Data Akun</a>
    <a class="nav-link" href="{{ route('pelanggar.index') }}">Data Pelanggar</a>
    <a class="nav-link" href="{{ route('pelanggaran.index') }}">Data Pelanggaran</a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
    <h1>Dashboard Admin</h1>
    @if ($message = Session::get('success'))
    <p>{{ $message }}</p>
    @else
    <p>You are logged in!</p>
    @endif

    <h3>Jumlah Siswa {{ $jmlSiswas }}</h3>
    <h3>Jumlah Siswa {{ $jmlPelanggars }}</h3>
    <br><br><br>

    <h1>Top 10 siswa dengan poin pelanggaran tertinggi</h1>
    <table class="tabel">
        <tr>
            <th>Foto</th>
            <th>Nis</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>No Hp</th>
            <th>Poin</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        @forelse ($pelanggars as $pelanggar)
        <tr>
          <td>
            <img src="{{ asset('storage/siswas/'.$pelanggar->image) }}" width="120px" height="120px" alt="">
          </td>
            <td>{{ $pelanggar->nis }}</td>
            <td>{{ $pelanggar->name }}</td>
            <td>{{ $pelanggar->tingkatan }} {{ $pelanggar->jurusan }} {{ $pelanggar->kelas }}</td>
            <td>{{ $pelanggar->hp }}</td>
            <td>{{ $pelanggar->poin_pelanggar }}</td>
            <td>
                <a class="nav-link" href="{{ route('pelanggaran.index') }}">Data Pelanggaran</a>
            </td>
        </tr>
        @empty
        <tr>
            <td>
            <p>Data tidak ditemukan</p>
            </td> 
            <td>
              <a href="{{ route('pelanggar.index') }}">Kembali</a>
            </td>
        </tr>
        @endforelse
    </table>

    <br><br><br>

    <h1>Top 10 Pelanggaran yang sering dilakukan</h1><br>
    <table class="tabel">
  <tr>
    <td>Nam Pelanggaran</td>
    <td>Konsekuensi</td>
    <td>Poin</td>
    <td>Aksi</td>
    <th>Total Pelanggaran</th>
  </tr>
  @forelse ($hitung as $hit)
<tr>
  <td>{{ $hit->jenis }}</td>
  <td>{{ $hit->konsekuensi }}</td>
  <td>{{ $hit->poin }}</td>
  <td>{{ $hit->totals }}</td>
  
</tr>
@empty
<tr>
  <td>
    <p>Data Tidak Ditemukan</p>
  </td>
  <td>
    <a href="{{ route('pelanggaran.index') }}">Kembali</a>
  </td>
</tr>
@endforelse
</table>
</body>
<footer>

</footer>
</html>
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
            @if($pelanggar->status == 0) :
            <td>: Tidak Perlu Ditindak</td>
            @elseif($pelanggar->status == 1) 
            <td>Perlu Ditindak</td>
            @else
            <td>: Sudah Ditindak</td>
            @endif
        </tr>
        <tr>
          <td>
            Total Poin
          </td>
          <td>: <h1>{{ $pelanggar->poin_pelanggar }}</h1>
          </td>
        </tr>
    </table>
    <br><br>

    <h1>Pelanggaran Yang Dilakukam</h1>
    <br><br>

    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    @if($pelanggar->status == 0 || $pelanggar->status == 1) :
    <button onclick="mmyFunction()">Tambah Pelanggaran</button>

    <script>
      function myFunction() {
        alert("Poin Pelanggar Sudah Mencapai {{ $pelanggar->poin_pelanggar }} Poin Pelanggar Perlu Ditindak!");
      }
    </script>
    @else
    <a href="{{ route('pelanggar.show' , $pelanggar->id) }}">Tambah Pelanggaran</a>
    @endif
</body>
</html>
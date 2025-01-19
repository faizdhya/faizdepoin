<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Akun</title>
    <style type="text/css">
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0px;
        }
        table,
        th,
        td {
            border: 1px solid;
        }
    </style>
</head>
<body>
    <h1>Edit Akun</h1>
    <a href="{{ route('akun.index') }}">Kembali</a>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $errors)
            <li>{{ $errors }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    <form action="{{ route('akun.update , $user->id') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h2>Data Akun</h2>
        <label>Nama Lengkap</label>
        <input type="text" id="name" name="name" value="{{ $akun->name }}">
        <br><br>

        <label>Hak Akses</label>
        <select name="usertype" required>
            <option {{ 'admin' == $akun->usertype ? 'selected' : '' }} value="admin">Admin</option>
            <option {{ 'ptk' == $akun->usertype ? 'selected' : '' }} value="ptk">PTK</option>
        </select>

        <button type="submit">SIMPAN DATA</button>
        <br><br>
    </form>

    <form action="{{ route('updateEmail' , $akun->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label>Alamat Email</label>
        <input type="email" name="email" id="email" value="{{ $akun->email }}">
        <br><br>
        <button type="submit">SIMPAN EMAIL</button>
        <br><br>
    </form>

    <form action="{{ route('updatePassword' , $akun->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label>Password</label>
        <input type="password" name="password" id="password">
        <br><br>

        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start"></label>
        <div class="col=md-6">
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
        </div>
        <br><br>

        <button type="submit">SIMPAN PASSWORD</button>
        <br><br>
    </form>
</body>
</html>
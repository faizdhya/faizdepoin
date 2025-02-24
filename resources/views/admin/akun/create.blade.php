<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun</title>
</head>
<body>
    <h1>Register/Tambah Akun</h1>
    <a href="{{ route('akun.index') }}">Kembali</a><br><br>

    @if ($errors->any())
    <div class="alert-danger">
        <ul>
            @foreach ($errors->all() as $error )
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('akun.store') }}" method="POST">
        @csrf
        <label>Nama Lengkap</label><br>
        <input type="text" id="name" name="name" value="{{ old('name') }}"><br>

        <br>
        <label>Alamat Email</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}"><br>

        <br>
        <label>password</label><br>
        <input type="password" id="password" name="password"><br>

        <br>
        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start"></label>
        <div class="col=md-6">
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
        </div>
        <br>

        <label>Hak Akses</label><br>
        <select name="usertype" required>
            <option value="">Pilih Hak Akses</option>
            <option value="Admin">Admin</option>
            <option value="siswa">Siswa</option>
            <option value="PTK">PTK</option>
        </select>
        <br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
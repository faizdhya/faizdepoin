@extends('auth.layouts')

@section('content')

<h1>Login</h1>

<form action="{{ route('authenticate') }}" method="POST">
    @csrf
    <label>Email Address</label><br>
    <input type="email" id="email" name="email" value="{{ old('email') }}"><br>
    <label>Password</label>
    <input type="password" name="password" id="password"><br><br>
    <input type="submit" value="Login">
</form>

@endsection
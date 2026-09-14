@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')

<div class="panel" style="max-width:520px;">
  <h3 class="panel-title">Data Diri</h3>
  <form method="POST" action="{{ route('profile.update') }}">
    @csrf @method('PUT')
    <div class="field" style="margin-bottom:10px;"><label>Nama</label><input type="text" name="name" value="{{ old('name', $user->name) }}" required></div>
    <div class="field" style="margin-bottom:10px;"><label>Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
    <div class="field" style="margin-bottom:10px;"><label>Telepon</label><input type="text" name="phone" value="{{ old('phone', $user->phone) }}"></div>
    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
  </form>
</div>

<div class="panel" style="max-width:520px;">
  <h3 class="panel-title">Ubah Password</h3>
  <form method="POST" action="{{ route('profile.password') }}">
    @csrf @method('PUT')
    <div class="field" style="margin-bottom:10px;"><label>Password Saat Ini</label><input type="password" name="current_password" required></div>
    <div class="field" style="margin-bottom:10px;"><label>Password Baru</label><input type="password" name="password" required></div>
    <div class="field" style="margin-bottom:10px;"><label>Konfirmasi Password Baru</label><input type="password" name="password_confirmation" required></div>
    <button class="btn btn-primary" type="submit">Ubah Password</button>
  </form>
</div>
@endsection

@extends('general')

@section('content')
<div class="row justify-content-center align-items-center" style="height: 100vh;">
    <form method="POST" action="{{ route('handleLogin') }}" class="col-lg-4">
        @csrf
        <div class="card">
            <div class="card-body">
                <strong><h1>Masuk</h1></strong>
                <hr>
                
                @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                
                <div class="mt-3">
                    <label for="username">Nama Pengguna</label>
                    <input type="text" class="form-control @error('username') border-danger @enderror" name="username" placeholder="Masukkan nama pengguna">
                    @error('username')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mt-3">
                    <label for="password">Kata Sandi</label>
                    <input type="password" class="form-control @error('password') border-danger @enderror" name="password" placeholder="Masukkan kata sandi">
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@extends('layouts.public')

@section('title', 'Login')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="px-3 py-5 bg-body-tertiary rounded shadow" style="width: 325px; min-width: 325px; height: 400px; min-height: 400px;">
            <h1 class="text-center mb-3">
                <i class="bi bi-mortarboard-fill text-black bg-warning py-1 px-2 rounded"></i>
            </h1>
            {{-- <hr> --}}
            <h4 class="mb-3 text-center">Login</h4>
            <hr>
            <div class="px-3">
                <form method="POST" class="ajax-form" action="{{ route('login-submit') }}">
                    @csrf
                    <div class="mb-3 form-floating">
                        <input type="email" id="email" name="email" class="form-control" required autofocus>
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="password" id="password" name="password" class="form-control" required>
                        <label for="password" class="form-label">Password</label>
                    </div>
                    {{-- <div class="mb-3 form-check">
                        <input type="checkbox" id="remember" name="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Remember me</label>
                    </div> --}}
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection

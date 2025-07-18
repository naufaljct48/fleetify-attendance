@extends('layouts.app')
@section('content')
<div class="page">
    <div class="container container-tight d-flex flex-column justify-content-center  vh-100">
        <div class="text-center mb-4">
            <a href="#" class="navbar-brand navbar-brand-autodark">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-library">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                    <path d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                    <path d="M11 7h5" />
                    <path d="M11 10h6" />
                    <path d="M11 13h3" />
                </svg> Fleetify
            </a>
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Register</h2>
                <form action="{{ route('register') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" placeholder="Name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" placeholder="Email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" placeholder="Password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" required>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center text-secondary mt-3">
            Already have account ? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</div>
@endsection
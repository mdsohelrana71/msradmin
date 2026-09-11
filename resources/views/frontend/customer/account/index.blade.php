@extends('frontend.layouts.app')

@section('title', 'My Account')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="list-group">
                <a href="{{ route('customer.account') }}" class="list-group-item list-group-item-action active">
                    My Account
                </a>

                <form method="POST" action="{{ route('customer.logout') }}">
                    @csrf
                    <button type="submit" class="list-group-item list-group-item-action text-danger border-0 w-100 text-start">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            <h3>Welcome, {{ Auth::user()->name }}</h3>
            <p class="mb-1">{{ Auth::user()->email }}</p>
            <p class="mb-0">Customer Account</p>
        </div>
    </div>
</div>
@endsection
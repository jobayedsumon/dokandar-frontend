@extends('layout.app')

@section('content')

    <div>
        @include('includes.header')
    </div>

    <div class="container mt-5">
        @if(session()->has('msg'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="text-center">
                    <img class="mx-auto" width="100px" src="{{ asset('images/logos/logo_user.png') }}" alt="">
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Phone Number</label>
                        <div class="d-flex align-items-baseline">
                            <span class="mr-2">(+880)</span><input required type="number" name="user_phone" maxlength="10" minlength="10" class="form-control" placeholder="Enter Phone Number">
                        </div>

                        <small id="" class="form-text text-muted">We'll never share your phone number with anyone else.</small>
                    </div>
                    <button type="submit" class="btn btn-danger">Login</button>
                </form>
            </div>
        </div>


    </div>

    <div>
        @include('includes.footer')
    </div>



@endsection

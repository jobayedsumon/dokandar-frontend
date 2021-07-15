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

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Phone Number</label>
                        <div class="d-flex align-items-baseline">
                            <span class="mr-2">(+880)</span><input required type="number" name="user_phone" maxlength="10" minlength="10" class="form-control" placeholder="Enter Phone Number">
                        </div>

                        <small id="" class="form-text text-muted">We'll never share your phone number with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="">Full Name</label>
                        <input required type="text" name="user_name" class="form-control" placeholder="Enter Full Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input required type="email" name="user_email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <button type="submit" class="btn btn-danger">Register</button>
                </form>
            </div>
        </div>


    </div>

    <div>
        @include('includes.footer')
    </div>



@endsection

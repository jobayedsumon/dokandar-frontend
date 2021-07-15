@extends('layout.app')

@section('content')

    <div>
        @include('includes.header')
    </div>

    <div class="container mt-5">
        @if(isset($msg))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ $msg }}
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

                <form action="{{ route('otp-verify', $user_id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Enter OTP</label>
                        <div class="d-flex align-items-baseline">
                            <span class="mr-2"></span><input required type="number" name="otp" maxlength="4" class="form-control" placeholder="An OTP has been sent to your number">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger">Verify</button>
                </form>
            </div>
        </div>


    </div>

    <div>
        @include('includes.footer')
    </div>



@endsection

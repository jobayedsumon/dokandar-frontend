@extends('layout.app')

@section('content')

    <div>
        @include('includes.header')
    </div>

    <div class="container">
        @if(session()->has('msg'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

            <div class="container">

                <div class="row">

                    <div class="col-3"></div>
                    <div class="col-6">
                        <div class="text-center">
                            <img class="mx-auto" src="{{ asset('images/order_placed.png') }}" width="300px" alt="">
                            <h3 class="font-weight-bold text-xl">Order ID - {{ $order['cart_id'] ?? '' }} has been placed successfully. <br>Please keep BDT
                                {{ $order['total_price'] ?? '' }}!!</h3>
                            <br>
                            <br>
                            <span class="text-muted">Thanks for choosing us for delivering your needs.</span>
                            <br>
                            <br>
                            <span class="text-muted">You can check your order status in My Account section.</span>
                        </div>
                    </div>

                </div>

            </div>




    </div>

    <div>
        @include('includes.footer')
    </div>

    <script>
        $('#payNowBtn').attr('disabled', 'disabled');
        $('#codBtn').attr('disabled', 'disabled');
        $('#agree').click(function() {
            if ($(this).is(':checked')) {
                $('#payNowBtn').removeAttr('disabled');
                $('#codBtn').removeAttr('disabled');
            } else {
                $('#payNowBtn').attr('disabled', 'disabled');
                $('#codBtn').attr('disabled', 'disabled');
            }
        });
    </script>



@endsection

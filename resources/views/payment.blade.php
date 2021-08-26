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

            <div class="container">

                <div class="row">
                    <div class="col-6 order-md-1">
                        <h3 class="mb-3 text-lg">Select Payment Method</h3>
                        <div>
                            <form action="{{ route('payment', $order->cart_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_status" value="success">
                                <button class="btn btn-danger" type="submit" name="payment_method" value="COD">Cash On Delivery</button>
                                <button class="btn btn-danger" type="submit" name="payment_method" value="ONLINE">ONLINE PAYMENT</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-6 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-lg">Coupon</span>
                        </h4>
                        <form class="p-2" method="POST" action="{{ route('apply-coupon', $order->cart_id) }}">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="coupon_code" placeholder="Promo code" required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-danger">Redeem</button>
                                </div>
                            </div>
                        </form>
                        @if($order->coupon_discount)
                            <li class="list-group-item d-flex justify-content-between bg-light mt-3">
                                <div class="text-success">
                                    <h6 class="my-0">Promo code</h6>
                                    <small>{{ session()->get('coupon_code') }}</small>
                                </div>
                                <span class="text-success">-BDT {{ $order->coupon_discount }}</span>
                            </li>
                        @endif

                        <ul class="list-group mb-3 sticky-top">


                            <li class="list-group-item d-flex justify-content-between">
                                <span>Order Amount</span>
                                <strong>BDT {{ $order->price_without_delivery }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Delivery Charge</span>
                                <strong>BDT {{ $order->delivery_charge }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between text-xl text-danger">
                                <span>Payable Amount</span>
                                <strong>BDT {{ $order->coupon_discount ? $order->rem_price : $order->total_price }}</strong>
                            </li>
                        </ul>

                    </div>

                </div>

            </div>




    </div>

    <div>
        @include('includes.footer')
    </div>


@endsection

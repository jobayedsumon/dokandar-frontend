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
                        <h3 class="mb-3 text-lg">Delivery Address</h3>
                        <form action="{{ route('order') }}" method="POST">
                            @csrf
                            <ul>
                                @forelse($address_list as $address_data)
                                    <li>

                                        <div class="addressBox">
                                            <input type="radio" name="address_id" value="{{ $address_data['address_id'] }}">
                                            {{ $address_data['address'] }}
                                        </div>

                                    </li>
                                @empty
                                @endforelse
                            </ul>

                            <button type="submit" class="btn btn-danger mt-5">Confirm Order</button>
                        </form>

                    </div>
                    <div class="col-6 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-lg">Your cart</span>
                            <span class="badge badge-danger badge-pill px-2">{{ count($cartDetails) }}</span>
                        </h4>
                        <ul class="list-group mb-3 sticky-top">
                            @php $sub_total = 0; @endphp
                            @forelse($cartDetails as $c)
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">{{ $c['product']->product_name }}</h6>
                                    <small class="text-muted">(BDT {{ $c['variant']->price }} / {{ $c['variant']->quantity }} {{ $c['variant']->unit }}) x {{ $c['qty'] }}</small>
                                </div>
                                @php
                                    $total = $c['qty'] * $c['variant']->price;
                                    $sub_total += $total;
                                @endphp
                                <span class="">BDT {{ $total }}</span>
                            </li>
                            @empty
                            @endforelse


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

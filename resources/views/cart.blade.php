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
        <h1 class="text-xl my-3">You have total {{ count($cartDetails) }} item(s) in your cart</h1>
        <table class="table table-responsive table-striped table-hover">
            <thead class="bg-danger text-white font-weight-bold">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product</th>
                <th scope="col">Size / Variation</th>
                <th scope="col">Price</th>
                <th scope="col">Add-Ons</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Amount</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @php $sub_total = 0; @endphp
            @forelse($cartDetails as $index=>$c)
            <tr>
                <th scope="row">{{ $index+1 }}</th>
                <td>
                    <div class="d-flex align-items-center">
                        <img width="50px" class="mr-2" src="{{ imageBaseUrl($c['product']->product_image) }}" alt="">
                        <p>{{ $c['product']->product_name }}</p>
                    </div>

                </td>
                <td>{{ $c['variant']->quantity }} {{ $c['variant']->unit }}</td>
                <td>BDT {{ $c['variant']->price }}</td>
                <td>
                    <ul>

                        @php $total_addon_price = 0; @endphp
                        @if(isset($c['addons']))
                        @forelse($c['addons'] as $addon)
                            @php $total_addon_price += $addon->addon_price; @endphp
                            <li>
                                {{ $addon->addon_name . ' - BDT ' . $addon->addon_price }}
                            </li>
                        @empty
                            N/A
                        @endforelse
                        @else
                            N/A
                        @endif
                    </ul>
                </td>
                <td>{{ $c['qty'] }}</td>
                @php
                    $total = $c['qty'] * $c['variant']->price;
                    $sub_total += ($total + $total_addon_price);
                 @endphp
                <td>BDT {{ $total + $total_addon_price}}</td>
                <td>
                    <a href="{{ route('remove-cart', $c['cart_id']) }}"><i class="fa fa-trash text-danger"></i></a>
                </td>
            </tr>
            @empty
            @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5"></th>
                    <th>Sub Total</th>
                    <th>BDT {{ $sub_total }}</th>
                </tr>

            </tfoot>
        </table>
            <a class="btn btn-danger pull-right" href="{{ route('checkout') }}">Proceed To Checkout</a>
    </div>

    <div>
        @include('includes.footer')
    </div>



@endsection

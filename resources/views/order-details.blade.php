@extends('layout.app')

@section('content')

    <div>
        @include('includes.header')
        <style>
            .table td, .table th {
                border-top: none !important;
            }
        </style>
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
            <div class="material-datatables">
                <form role="form" method="post" action="" >
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%" data-background-color="purple">
                        <thead>
                        <tr>
                            <th colspan="3" class="text-center text-lg">Order #{{ $data['cart_id'] }}</th>

                            <!--th class="text-center" style="width: 100px;">Action</th-->
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td colspan="3">
                                <table class="table">
                                    <tr>
                                        <td valign="top" width="50%">
                                            <strong class="font-weight-bold"> Order Details </strong><br />
                                            <strong>  Vendor: {{ $data['vendor_name'] }}</strong>
                                            <br />
                                            <strong > Order Id: #{{ $data['cart_id'] }}</strong>
                                            <br />
                                            <strong>  Order Date: {{ date('d-m-Y', strtotime($data['order_date'])) }}</strong>
                                            <br />
                                            <strong>  Order Status: {{ $data['order_status'] }}</strong>
                                            <br />
                                            <strong>  Total Amount: BDT {{ $data['price'] }}</strong>
                                            <br />

                                        </td>
                                        <td width="50%">
                                            <strong class="font-weight-bold"> Delivery Details </strong><br />
                                            <strong>Delivery Date: {{ date('d-m-Y', strtotime($data['delivery_date'])) }} </strong>
                                            <br />
                                            @if($data['time_slot'])
                                                <strong>Delivery Time: {{ $data['time_slot'] }} </strong>
                                                <br>
                                                @endif

                                            <strong>Address: {{ $data['address'] }}</strong>
                                            <br>

                                             <strong>Delivery Boy:
                                                 {{ $data['delivery_boy_name'] ? $data['delivery_boy_name']
                                                    .' ('.$data['delivery_boy_phone'].')' : 'Not Assigned Yet'}}</strong>
                                        </td>

                                    </tr>
                                </table>
                            </td>
                        </tr>


                        </tbody>
                    </table>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Product Price</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $total = 0; @endphp
                        @forelse($data['details'] as $index=>$product)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->qty }}</td>
                                <td>BDT {{ $product->price }}</td>
                                <td>BDT {{ $product->price * $product->qty }}</td>
                                @php $total += ($product->price * $product->qty) @endphp
                            </tr>
                        @empty
                        @endforelse
                        <tr style="border-top: 1px solid #ccc">
                            <td colspan="4"><strong class="pull-right">Total</strong></td>
                            <td >
                                <strong class="">BDT {{ $total }}</strong>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"><strong class="pull-right">Delivery Charges</strong></td>
                            <td >
                                <strong class="">BDT {{ $data['delivery_charge'] }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"><strong class="pull-right">Net Total Amount</strong></td>
                            <td >
                                <strong class="">BDT {{ $data['price'] }}</strong>
                            </td>
                        </tr>
                        </tbody>


                    </table>

                </form>
            </div>
        </div>
        </div>

    </div>

    <div>
        @include('includes.footer')
    </div>



@endsection

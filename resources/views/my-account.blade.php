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

        <!-- my account start  -->
            <section class="main_content_area">
                <div class="container">
                    <div class="account_dashboard">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-lg-3">
                                <!-- Nav tabs -->
                                <div class="dashboard_tab_button">
                                    <ul role="tablist" class="nav flex-column dashboard-list">
                                        <li><a href="#dashboard" data-toggle="tab" class="nav-link active">Dashboard</a></li>
                                        <li> <a href="#orders" data-toggle="tab" class="nav-link">Orders</a></li>
                                        <li><a href="#address" data-toggle="tab" class="nav-link">Addresses</a></li>
                                        <li><a href="#account-details" data-toggle="tab" class="nav-link">Account details</a></li>
                                        <li><a href="{{ route('logout') }}" class="nav-link">logout</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9 col-lg-9">
                                <!-- Tab panes -->
                                <div class="tab-content dashboard_content">
                                    <div class="tab-pane fade show active" id="dashboard">
                                        <h3>Dashboard </h3>
                                        <p>From your account dashboard. you can easily check &amp; view your <a href="#orders">recent orders</a>, manage your <a href="#address">delivery addresses</a> and <a href="#account-details">Edit your password and account details.</a></p>
                                    </div>
                                    <div class="tab-pane fade" id="orders">
                                        <div class="table-responsive">
                                            <h1 class="text-xl my-3">You have total {{ count($data) }} order(s)</h1>
                                            <table class="table table-responsive table-striped table-hover">
                                                <thead class="bg-danger text-white font-weight-bold">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Address</th>
                                                    <th>Total Items</th>
                                                    <th>Order Status</th>
                                                    <th>Order Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($data as $order)
                                                    <tr>
                                                        <td class="text-danger">{{ $order['cart_id'] }}</td>
                                                        <td>{{ $order['address'] }}</td>
                                                        <td>{{ count($order['data']) }}</td>
                                                        <td>{{ $order['order_status'] }}</td>
                                                        <td>BDT {{ $order['remaining_amount'] }}</td>
                                                        <td>{{ $order['payment_method'] }}</td>
                                                        <td><a class="btn btn-danger" href="">Details</a></td>
                                                    </tr>
                                                @empty
                                                @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


{{--                                    <div class="tab-pane" id="address">--}}
{{--                                        <p>The following addresses will be used on the checkout page by default.</p>--}}
{{--                                        <div class="checkout_form">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-lg-6 col-md-6">--}}
{{--                                                    <h4 class="billing-address">Billing address</h4>--}}
{{--                                                    <div class="row">--}}
{{--                                                        <form action="{{ route('update-address') }}" method="POST">--}}
{{--                                                            @csrf--}}
{{--                                                            @method('PATCH')--}}
{{--                                                            <div class="col-12 mb-20">--}}
{{--                                                                <label for="division">Division <span>*</span></label>--}}
{{--                                                                <select class="select_option" name="division" id="division">--}}

{{--                                                                    <option value="{{ $division ?? '' }}">{{ $division ?? '' }}</option>--}}

{{--                                                                    <option value="dhaka">Dhaka</option>--}}
{{--                                                                    <option value="chittagong">Chittagong</option>--}}
{{--                                                                    <option value="barisal">Barisal</option>--}}
{{--                                                                    <option value="khulna">Khulna</option>--}}
{{--                                                                    <option value="mymensingh">Mymensingh</option>--}}
{{--                                                                    <option value="sylhet">Sylhet</option>--}}
{{--                                                                    <option value="rangpur">Rangpur</option>--}}

{{--                                                                </select>--}}
{{--                                                            </div>--}}

{{--                                                            <div class="col-12 mb-20">--}}
{{--                                                                <label>District <span>*</span></label>--}}
{{--                                                                <input type="text" name="district" value="{{ $district ?? '' }}">--}}
{{--                                                            </div>--}}

{{--                                                            <div class="col-12 mb-20">--}}
{{--                                                                <label>Town / City <span>*</span></label>--}}
{{--                                                                <input type="text" name="city" value="{{ $city ?? '' }}">--}}
{{--                                                            </div>--}}

{{--                                                            <div class="col-12 mb-20">--}}
{{--                                                                <label>Street address  <span>*</span></label>--}}
{{--                                                                <input name="street" placeholder="House number and street name" type="text" value="{{ $street ?? '' }}">--}}
{{--                                                            </div>--}}

{{--                                                            <button class="customButton py-2 px-6" style="border-radius: 5px" type="submit">Save</button>--}}

{{--                                                        </form>--}}

{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="tab-pane fade" id="account-details">--}}
{{--                                        <h3>Account details </h3>--}}
{{--                                        <div class="login">--}}
{{--                                            <div class="login_form_container">--}}
{{--                                                <div class="account_login_form">--}}
{{--                                                    <form action="{{ route('update-account') }}" method="POST">--}}
{{--                                                        @csrf--}}
{{--                                                        @method('PATCH')--}}
{{--                                                        <label>Name</label>--}}
{{--                                                        <input type="text" name="name" value="{{ $customer->name }}">--}}
{{--                                                        <label>Email</label>--}}
{{--                                                        <input type="email" name="email" value="{{ $customer->email }}">--}}
{{--                                                        @if ($errors->has('email'))--}}
{{--                                                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('email') }}</span>--}}
{{--                                                            <br>--}}
{{--                                                        @endif--}}
{{--                                                        <label>Phone Number</label>--}}
{{--                                                        <input type="text" name="phone_number" value="{{ $customer->phone_number }}">--}}
{{--                                                        <label>Password</label>--}}
{{--                                                        <input type="password" name="password" required>--}}
{{--                                                        <label>Birthdate</label>--}}
{{--                                                        <input type="date" placeholder="MM/DD/YYYY" value="{{ $customer->birthdate }}" name="birthdate">--}}
{{--                                                        <span class="example">--}}
{{--                                                  (E.g.: 05/31/1970)--}}
{{--                                                </span>--}}
{{--                                                        <br>--}}
{{--                                                        <span class="custom_checkbox">--}}
{{--                                                    <input {{ $customer->receive_offer ? 'checked' : '' }} type="checkbox" value="1" name="receive_offer">--}}
{{--                                                    <label>Receive offers from our partners</label>--}}
{{--                                                </span>--}}
{{--                                                        <br>--}}
{{--                                                        <span class="custom_checkbox">--}}
{{--                                                    <input {{ $customer->receive_offer ? 'checked' : '' }} type="checkbox" value="1" name="newsletter">--}}
{{--                                                    <label>Sign up for our newsletter<br><em>You may unsubscribe at any moment. For that purpose, please find our contact info in the legal notice.</em></label>--}}
{{--                                                </span>--}}
{{--                                                        <div class="save_button primary_btn default_button">--}}
{{--                                                            <button class="customButton py-2 px-6" style="border-radius: 5px" type="submit">Save</button>--}}
{{--                                                        </div>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- my account end   -->


    </div>

    <div>
        @include('includes.footer')
    </div>



@endsection

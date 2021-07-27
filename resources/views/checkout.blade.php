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
                        <div class="d-flex align-items-baseline">
                            <h3 class="mb-3 text-lg">Delivery Address</h3>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#addressModal">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>


                        <form action="{{ route('order') }}" method="POST">
                            @csrf
                            <ul>
                                @forelse($address_list as $address_data)
                                    <li class="mt-3">

                                        <div class="addressBox">
                                            <input type="radio" required name="address_id" value="{{ $address_data['address_id'] }}">
                                            {{ $address_data['address'] }}
                                        </div>

                                    </li>
                                @empty
                                @endforelse
                            </ul>

                            <div class="form-group mt-4">
                                <label for="dateSlots">Date Slots</label>
                                <input required type="date" min="{{ $minDate }}" max="{{ $maxDate }}" name="delivery_date" id="dateSlots">
                            </div>

                            <div class="form-group mt-4">
                                <label for="">Time Slots</label>
                                <div id="timeSlots">

                                </div>

                            </div>

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

                                    @php $total_addon_price = 0; @endphp
                                    @if(isset($c['addons']))
                                    @forelse($c['addons'] as $addon)
                                        @php $total_addon_price += $addon->addon_price; @endphp
                                        <br>
                                        <small class="text-muted">
                                            {{ $addon->addon_name . ' - BDT ' . $addon->addon_price }}
                                        </small>
                                    @empty
                                    @endforelse
                                    @endif
                                </div>
                                @php
                                    $total = $c['qty'] * $c['variant']->price;
                                    $sub_total += ($total + $total_addon_price);
                                @endphp
                                <span class="">BDT {{ $total + $total_addon_price }}</span>
                            </li>
                            @empty
                            @endforelse

                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <h3 class="text-lg text-danger">Sub Total</h3>
                                <h3 class="text-lg text-danger">BDT {{ $sub_total }}</h3>
                            </li>

                        </ul>


                    </div>

                </div>

            </div>



            <!-- Modal -->
            <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
                <form action="{{ route('add-address') }}" method="POST">
                    @csrf
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addressModalLabel">Add New Address</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <select class="form-control" required name="address_type">
                                            <option value="">Select address type</option>
                                            <option value="Home">Home</option>
                                            <option value="Office">Office</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <select class="form-control" id="city" required name="city_id">
                                            <option value="">Select city</option>
                                            @forelse($city_list as $city)
                                                <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-control" id="area" required name="area_id">
                                            <option value="">Select near by</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <input placeholder="House no." name="houseno" type="text" class="form-control" required>
                                    </div>
                                    <div class="col-6">
                                        <input placeholder="Enter your pincode or zipcode" name="pin" type="text" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <input placeholder="Enter your state" type="text" name="state" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <textarea name="street" placeholder="Enter your address line" class="form-control" required></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="lat">
                                <input type="hidden" name="lng">
                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Save changes</button>
                            </div>

                        </div>

                    </div>
                </form>

            </div>




    </div>

    <div>
        @include('includes.footer')
    </div>



@endsection

@section('script')
<script>

    $(document).ready(function () {

        navigator.geolocation.getCurrentPosition(success, error);

        function success(position) {
            $('input[name=lat]').val(position.coords.latitude);
            $('input[name=lng]').val(position.coords.longitude);

            var GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + position.coords.latitude + '%2C' + position.coords.longitude + '&language=en&key={{ $checkmap->map_api_key }}';
            console.log(GEOCODING);
            $.ajax({
                url : GEOCODING,
                type: "GET",
                dataType: 'jsonp',
                cache: false,
                success: function(response, textStatus, jqXHR) {
                    console.log(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });

        }

        function error(err) {
            console.log(err)
        }

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

        $('#city').on('change', function () {

            var data = {
                city_id: $(this).val(),
                vendor_id: {{ $cartDetails[0]['product']->vendor_id }}
            }

            $.ajax({
                url : "/get-area-list",
                type: "POST",
                data : data,
                success: function(response, textStatus, jqXHR) {
                    console.log(response);
                    $.each(response, function (index, item) {
                        var option = new Option(item.area_name, item.area_id);
                        $('#area').append($(option));
                    });

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });

        });

        $('#dateSlots').on('change', function () {

            var data = {
                selected_date: $(this).val(),
                vendor_id: {{ $cartDetails[0]['product']->vendor_id }}
            }

            $.ajax({
                url : "/get-time-slots",
                type: "POST",
                data : data,
                success: function(response, textStatus, jqXHR) {
                    console.log(response);
                    var slots = '';
                    $.each(response, function (index, item) {
                        slots += ' <input required type="radio" name="time_slot" value="'+item+'"> '+item;
                    });
                    $('#timeSlots').empty();
                    $('#timeSlots').append(slots);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        });



    });

</script>
@endsection

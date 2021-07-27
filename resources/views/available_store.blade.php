@extends('layout.app')

@section('content')

    <div>
        @include('includes.header')
    </div>

    <div class="">
        <div class="jumbotron jumbotron-fluid" style="background-image: url('{{ imageBaseUrl($data["vendorCategory"]->category_image) }}')">
            <div class="container">
                <h1 class="display-4 text-danger">{{ $data['vendorCategory']->category_name }}</h1>
            </div>
        </div>
    </div>


    <div class="container">

        <h1 class="title">Total <span id="storeCount">{{ count($data['availableStore']) }}</span> store(s) found.</h1>

        @if(session()->has('msg'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row" id="storeContainer">


            @forelse($data['availableStore'] as $availableStore)
                <div class="col-md-6 col-lg-4 col-sm-12 column">
                    <a href="{{ route('vendor-type', [$availableStore['vendor_id'], $data['vendorCategory']->ui_type]) }}">
                    <div class="card">
                        <div class="txt">
                            <h1>{{ $availableStore['vendor_name'] }}</h1>
                            <p>Delivery within {{ $availableStore['delivery_range'] }} KM from {{ $availableStore['vendor_loc'] }}</p>
                        </div>

                        <div class="ico-card">
                            <div class="column-overlay"></div>
                            <img src="{{ imageBaseUrl($availableStore['vendor_logo']) }}" alt="">
                        </div>
                    </div>
                    </a>
                </div>
            @empty
            @endforelse


        </div>
        </div>
    </div>




    <div>
        @include('includes.footer')
    </div>



@endsection

@section('script')
    <script>
        $(document).ready(function () {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success, error);
            } else {
                alert("Geolocation is not supported by this browser.");
            }

            function success(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                var data = {
                    vendor_category_id: {{ $data['vendor_category_id'] }},
                    ui_type: {{ $data['ui_type']}},
                    lat: lat,
                    lng: lng
                }

                $.ajax({
                    url : "{{ route('get-nearby-stores') }}",
                    type: "POST",
                    data : data,
                    success: function(response, textStatus, jqXHR) {
                        $('#storeCount').text(response.length);
                        $.each(response, function (index, item) {

                            var store = `<div class="col-md-6 col-lg-4 col-sm-12 column">
                    <a href="`+URL+`/vendor/`+item.vendor_id+`/ui-type/{{ $data['vendorCategory']->ui_type }}/vendor-type">
                    <div class="card">
                        <div class="txt">
                            <h1>`+item.vendor_name+`</h1>
                            <p>Delivery within `+item.delivery_range+` KM from `+item.vendor_loc+`</p>
                        </div>

                        <div class="ico-card">
                            <div class="column-overlay"></div>
                            <img src="{{ imageBaseUrl() }}`+item.vendor_logo+`" alt="">
                        </div>
                    </div>
                    </a>
                </div>`;
                            $('#storeContainer').append(store);
                        });

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
        });
    </script>
@endsection

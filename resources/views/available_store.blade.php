@extends('layout.app')

@section('content')

    <div>
        @include('includes.header')
    </div>

    <div class="">
        <div class="jumbotron jumbotron-fluid" style="background-image: url('{{ imageBaseUrl($data["vendorCategory"]->category_image) }}')">
            <div class="container">
                <h1 class="display-4">{{ $data['vendorCategory']->category_name }}</h1>
            </div>
        </div>
    </div>


    <div class="container">

        <h1 class="title">Total {{ count($data['availableStore']) }} store(s) found.</h1>

        @if(session()->has('msg'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">


            @forelse($data['availableStore'] as $availableStore)
                <div class="col-md-6 col-lg-4 col-sm-12 column">
                    <div class="card">
                        <div class="txt">
                            <h1>{{ $availableStore['vendor_name'] }}</h1>
                            <p>Delivery within {{ $availableStore['delivery_range'] }} KM from {{ $availableStore['vendor_loc'] }}</p>
                        </div>
                        <a href="{{ route('categories', $availableStore['vendor_id']) }}">Click Here</a>
                        <div class="ico-card">
                            <img src="{{ imageBaseUrl($availableStore['vendor_logo']) }}" alt="">
                        </div>
                    </div>
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

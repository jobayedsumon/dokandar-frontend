@extends('layout.app')

@section('content')

    <div>
        @include('includes.header')
    </div>

    <div class="">
        <div class="owl-carousel">
            @forelse($data['vendorBanner'] as $vendorBanner)
            <div>
                <img src="{{ imageBaseUrl($vendorBanner['banner_image']) }}" alt="{{ $vendorBanner['banner_name'] }}">
                <h1 class="caption">{{ $vendorBanner['banner_name'] }}</h1>
            </div>
            @empty
            @endforelse
        </div>
    </div>


    <div class="container">
        <div class="row">

            @forelse($data['categories'] as $category)
                <div class="col-md-6 col-lg-4 col-sm-12 column">
                    <div class="card">
                        <div class="txt">
                            <h1>{{ $category['category_name'] }}</h1>
                            <p>Explore products</p>
                        </div>
                        <a href="{{ route('products', $category['category_id']) }}">Click Here</a>
                        <div class="ico-card">
                            <img src="{{ imageBaseUrl($category['category_image']) }}" alt="">
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

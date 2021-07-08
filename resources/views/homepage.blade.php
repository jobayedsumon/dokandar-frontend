@extends('layout.app')

@section('content')

    <div>
        @include('includes.header')
    </div>

    <div class="">
        <div class="owl-carousel">
            @forelse($data['adminBanner'] as $adminBanner)
            <div>
                <img src="{{ imageBaseUrl($adminBanner['banner_image']) }}" alt="{{ $adminBanner['banner_name'] }}">
                <h1 class="caption">{{ $adminBanner['banner_name'] }}</h1>
            </div>
            @empty
            @endforelse
        </div>
    </div>



    <div class="row">

            @forelse($data['vendorCategory'] as $vendorCategory)
                <div class="col-md-6 col-lg-4 col-sm-12 column">
                    <div class="card">
                        <div class="txt">
                            <h1>{{ $vendorCategory['category_name'] }}</h1>
                            <p>See available stores</p>
                        </div>
                        <a href="{{ route('available-store', [$vendorCategory['vendor_category_id'], $vendorCategory['ui_type']]) }}">Click Here</a>
                        <div class="ico-card">
                            <img src="{{ imageBaseUrl($vendorCategory['category_image']) }}" alt="">
                        </div>
                    </div>
                </div>
            @empty
            @endforelse


        </div>
    </div>

    <div>
        @include('includes.footer')
    </div>



@endsection

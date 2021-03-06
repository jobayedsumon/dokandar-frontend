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


<div class="container">
    <div class="row">

        @forelse($data['vendorCategory'] as $vendorCategory)

            <div class="col-md-6 col-lg-6 col-sm-12 column">
                <a href="{{ route('available-store', [$vendorCategory['vendor_category_id'], $vendorCategory['ui_type']]) }}">
                <div class="card">
                    <div class="txt">
                        <h1>{{ $vendorCategory['category_name'] }}</h1>
                        <p>See available stores</p>
                    </div>

                    <div class="ico-card">
                        <div class="column-overlay"></div>
                        <img src="{{ imageBaseUrl($vendorCategory['category_image']) }}" alt="">
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

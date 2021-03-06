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

        <section id="wrapper">
            <div class="content">
                <!-- Tab links -->
                <div class="tabs">
                    @forelse($data['subCategories'] as $index => $subCategory)
                    <button class="tablinks {{ $index == 0 ? 'active' : '' }}" data-id="subcat{{ $subCategory['subcat_id'] }}">
                        <p data-title="{{ $subCategory['subcat_name'] }}">{{ $subCategory['subcat_name'] }}</p></button>
                    @empty
                    @endforelse
                </div>

                <!-- Tab content -->
                <div class="wrapper_tabcontent">
                    @forelse($data['subCategories'] as $index => $subCategory)
                        <div id="subcat{{ $subCategory['subcat_id'] }}" class="tabcontent {{ $index == 0 ? 'active' : '' }}">
                            <div class="container ">
                            <div class="row">
                            @forelse($subCategory['products'] as $product)
                                @if(count($product) > 1)
                                <div class="col-md-4 mt-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-img-actions"> <img src="{{ imageBaseUrl($product['products_image'] ?? '') }}" class="card-img img-fluid" width="96" height="350" alt="Could not load image"> </div>
                                        </div>
                                        <div class="card-body bg-light text-center">
                                            <div class="mb-2">
                                                <h6 class="font-weight-semibold mb-2">{{ $product['product_name'] ?? '' }}</h6>
                                                @php
                                                    if ($product['data']) {
                                                        $min = PHP_INT_MAX; $max = PHP_INT_MIN;
                                                        foreach ($product['data'] as $variant) {
                                                            if ($variant['price'] <= $min) {
                                                                $min = $variant['price'];
                                                            }
                                                            if ($variant['price'] >= $max) {
                                                                $max = $variant['price'];
                                                            }
                                                        }

                                                    }
                                                @endphp
                                                <h3 class="mb-0 font-weight-semibold">BDT {{ $min == $max ? $min : $min.' - '.$max }}</h3>
                                                <a href="{{ route('grocery-product-details', [$data['vendor_id'], $product['product_id']]) }}" class="btn bg-cart">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @endif
                            @empty
                            @endforelse
                            </div>
                            </div>
                        </div>
                    @empty
                    @endforelse

                </div>
            </div>
        </section>

    </div>

    <div>
        @include('includes.footer')
    </div>


    <script>
        // tabs

        var tabLinks = document.querySelectorAll(".tablinks");
        var tabContent = document.querySelectorAll(".tabcontent");


        tabLinks.forEach(function(el) {
            el.addEventListener("click", openTabs);
        });


        function openTabs(el) {
            var btnTarget = el.currentTarget;
            var id = btnTarget.dataset.id;

            tabContent.forEach(function(el) {
                el.classList.remove("active");
            });

            tabLinks.forEach(function(el) {
                el.classList.remove("active");
            });

            document.querySelector("#" + id).classList.add("active");

            btnTarget.classList.add("active");
        }

    </script>

@endsection

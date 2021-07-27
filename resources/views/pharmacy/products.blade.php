@extends('layout.app')

@section('content')

    <div>
        @include('includes.header')
    </div>

    <div class="container">

        <section id="wrapper">
            <div class="content">
                <!-- Tab links -->
                <div class="tabs">
                    @forelse($data['pharmacyCats'] as $index => $pharmacyCat)
                    <button class="tablinks {{ $index == 0 ? 'active' : '' }}" data-id="pharmacyCat{{ reset($pharmacyCat)['resturant_cat_id'] }}">
                        <p data-title="{{ reset($pharmacyCat)['cat_name'] }}">{{ reset($pharmacyCat)['cat_name'] }}</p></button>
                    @empty
                    @endforelse
                </div>

                <!-- Tab content -->
                <div class="wrapper_tabcontent">
                    @forelse($data['pharmacyCats'] as $index => $pharmacyCat)
                        <div id="pharmacyCat{{ reset($pharmacyCat)['resturant_cat_id'] }}" class="tabcontent {{ $index == 0 ? 'active' : '' }}">
                            <div class="container ">
                            <div class="row">
                            @forelse($pharmacyCat as $product)
                                @if(count($product) > 1 && isset($product['product_name']))
                                <div class="col-md-4 mt-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-img-actions"> <img src="{{ imageBaseUrl($product['product_image'] ?? '') }}" class="card-img img-fluid" width="96" height="350" alt="Could not load image"> </div>
                                        </div>
                                        <div class="card-body bg-light text-center">
                                            <div class="mb-2">
                                                <h6 class="font-weight-semibold mb-2">{{ $product['product_name'] ?? '' }}</h6>
                                                @php

                                                    if (isset($product['variant'])) {
                                                        $min = PHP_INT_MAX; $max = PHP_INT_MIN;
                                                        foreach ($product['variant'] as $variant) {
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
                                                <a href="{{ route('pharmacy-product-details', [$data['vendor_id'], $product['product_id'] ?? -1]) }}" class="btn bg-cart">View Details</a>
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

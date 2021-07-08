@extends('layout.app')

@section('content')

    <div>
        @include('includes.header')
    </div>




    <div class="container">

        <div class="super_container">

            @if(session()->has('msg'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ session()->get('msg') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="single_product">
                <div class="container-fluid" style=" background-color: #fff; padding: 11px;">
                    <div class="row">
                        <div class="col-lg-2 order-lg-1 order-2">
                            <ul class="image_list">
                                @forelse($product_variant as $variant)
                                    <li data-image="{{ imageBaseUrl($variant->varient_image) }}"><img src="{{ imageBaseUrl($variant->varient_image) }}" alt=""></li>
                                @empty
                                @endforelse

                            </ul>
                        </div>
                        <div class="col-lg-4 order-lg-2 order-1">
                            <div class="image_selected"><img src="{{ imageBaseUrl($product->product_image) }}" alt=""></div>
                        </div>
                        <div class="col-lg-6 order-3">
                            <div class="product_description">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item"><a href="#">Products</a></li>
                                        <li class="breadcrumb-item active">Accessories</li>
                                    </ol>
                                </nav>
                                <div class="product_name">{{ $product->product_name }}</div>
                                @php
                                    if ($product_variant) {
                                        $min = $minStrike = PHP_INT_MAX; $max = $maxStrike = PHP_INT_MIN;
                                        foreach ($product_variant as $variant) {
                                            if ($variant->price <= $min) {
                                                $min = $variant->price;
                                            }
                                            if ($variant->price >= $max) {
                                                $max = $variant->price;
                                            }
                                            if ($variant->strick_price <= $minStrike) {
                                                $minStrike = $variant->strick_price;
                                            }
                                            if ($variant->strick_price >= $maxStrike) {
                                                $maxStrike = $variant->strick_price;
                                            }
                                        }

                                    }
                                @endphp
                                <div> <span class="product_price">BDT {{ $min == $max ? $min : $min.' - '.$max }}</span> <strike class="product_discount"> <span style='color:black'>BDT {{ $minStrike == $maxStrike ? $minStrike : $minStrike.' - '.$maxStrike }}</span> </strike> </div>
                                <div> <span class="product_saved">You Saved:</span> <span style='color:black'>BDT {{ ($minStrike-$min) == ($maxStrike-$max) ? ($minStrike-$min) : ($minStrike-$min).' - '.($maxStrike-$max) }}</span></div>
                                <hr class="singleline">
                                <div>
                                    @forelse($product_variant as $variant)
                                        <span class="product_info">{{ $variant->description }}</span><br>
                                    @empty
                                    @endforelse

                                </div>

                                <form action="{{ route('product-action', $product->product_id) }}" method="POST">
                                    @csrf
                                    <div>

                                        <div class="row" style="margin-top: 15px;">
                                            <div class="col-xs-6 form-group" style="margin-left: 15px; font-size: 16px; font-weight: 600">
                                                <span class="product_options">Size Options</span><br>
                                                <div>
                                                @forelse($product_variant as $variant)
                                                    <div>
                                                    <input required type="radio" name="variant" value="{{ $variant->varient_id }}" class="">
                                                    <span class="text-danger">{{ $variant->quantity.' '.$variant->unit }} - BDT {{ $variant->price }}</span> &nbsp;
                                                    </div>
                                                    @empty
                                                @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="singleline">

                                    <div class="row align-items-center">
                                        <div class="col-xs-6" style="margin-left: 13px;">
                                            <div class="">
                                                <div class="d-flex align-items-center">
                                                    <label style="font-size: 16px; font-weight: 600; margin-bottom: 0px">QTY: </label>
                                                    <input required class="" type="number" name="qty" min="1" value="1" style="border: 1px solid; margin: 0 5px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 form-inline">
                                            <button type="submit" name="action" value="1" class="btn btn-primary shop-button">Add to Cart</button>
                                            <button type="submit" name="action" value="2" class="btn btn-success shop-button">Buy Now</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

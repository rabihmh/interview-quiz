<x-front-layout title="{{$product->slug}}">
    <x-slot:breadcrumbs>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">{{$product->name}}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{route('front.products.index')}}"><i class="lni lni-shopping-basket"></i> Shop</a>
                            </li>
                            <li>{{$product->name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </x-slot:breadcrumbs>
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="main-img">
                                    <img src="{{$product->image_url}}" id="current" alt="#">
                                </div>
                            </main>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title">{{$product->name}}</h2>
                            <p class="category"><i class="lni lni-tag"></i><a
                                    href="javascript:void(0)">{{$product->category->name}}</a></p>
                            <h3 class="price">{{App\Helpers\Currency::format( $product->price,)}}
                                @if($product->compare_price)
                                    <span>{{App\Helpers\Currency::format( $product->compare_price,'EUR')}}</span>
                                @endif
                            </h3>
                            <p class="info-text">{{$product->description}}</p>
                            <form method="post" action="{{route('front.cart.store')}}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group quantity">
                                            <label for="color">Quantity</label>
                                            <input  type="number" class="form-control" name="quantity" min="1" max="5">
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-content">
                                    <div class="row align-items-end">
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="button cart-button">
                                                <button class="btn" type="submit" style="width: 100%;">Add to Cart
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script type="text/javascript">
            const current = document.getElementById("current");
            const opacity = 0.6;
            const imgs = document.querySelectorAll(".img");
            imgs.forEach(img => {
                img.addEventListener("click", (e) => {
                    //reset opacity
                    imgs.forEach(img => {
                        img.style.opacity = 1;
                    });
                    current.src = e.target.src;

                    e.target.style.opacity = opacity;
                });
            });
        </script>
    @endpush
</x-front-layout>

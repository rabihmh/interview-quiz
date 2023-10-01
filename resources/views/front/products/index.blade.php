<x-front-layout title="All Products">
    @push('styles')
        <style>
            #loading-image {
                display: none;
                text-align: center;
                margin-top: 60px
            }

            .pagination {
                display: flex;
            }
        </style>

    @endpush
    <x-slot:breadcrumbs>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Shop List</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{route('front.products.index')}}"><i class="lni lni-shopping-basket"></i> Shop</a>
                            </li>
                            <li>All</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </x-slot:breadcrumbs>
    <!-- Start Product Grids -->
    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <!-- Start Product Sidebar -->
                    <div class="product-sidebar">
                        <!-- Start Single Widget -->
                        <div class="single-widget search">
                            <h3>Search Product</h3>
                            <form id="search-form">
                                <input type="text" placeholder="Search Here..." id="search-input">
                                <button type="button" id="search-button"><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <div class="single-widget condition">
                            <h3>All Categories</h3>
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$category->id}}"
                                           name="category_id"
                                           id="category-filter-{{$category->id}}">
                                    <label class="form-check-label" for="category-filter-{{$category->id}}">
                                        {{$category->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <!-- End Single Widget -->

                        <!-- Start Single Widget -->
                        <div class="single-widget condition">
                            <h3>Filter by Price</h3>
                            <div class="form-check">
                                <input class="form-check-input price-filter" type="checkbox" value="50-100"
                                       id="price-filter-1">
                                <label class="form-check-label" for="price-filter-1">
                                    $50 - $100
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input price-filter" type="checkbox" value="100-150"
                                       id="price-filter-2">
                                <label class="form-check-label" for="price-filter-2">
                                    $100 - $150
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input price-filter" type="checkbox" value="150-200"
                                       id="price-filter-3">
                                <label class="form-check-label" for="price-filter-3">
                                    $150 - $200
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input price-filter" type="checkbox" value="200-300"
                                       id="price-filter-4">
                                <label class="form-check-label" for="price-filter-4">
                                    $200 - $300
                                </label>
                            </div>
                            <!-- Add more price range filters here -->
                        </div>
                        <!-- End Single Widget -->
                        <button id="search-btn" class="btn btn-primary" type="submit">Search</button>

                    </div>

                    <!-- End Product Sidebar -->
                </div>
                <div class="col-lg-9 col-12">
                    <div class="product-grids-head">
                        <div class="product-grid-topbar">
                            <div class="row align-items-center">
                                <div class="col-lg-7 col-md-8 col-12">
                                </div>
                                <div class="col-lg-5 col-md-4 col-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-grid" type="button" role="tab"
                                                    aria-controls="nav-grid" aria-selected="true"><i
                                                    class="lni lni-grid-alt"></i></button>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div id="loading-image">
                            <img src="{{asset('front/images/loading.gif')}}" alt="Loading...">
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-grid" role="tabpanel"
                                 aria-labelledby="nav-grid-tab">
                                <div class="row product-content">
                                    @foreach($products as $product)
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <!-- Start Single Product -->
                                            <div class="single-product">
                                                <div class="product-image">
                                                    @if($product->compare_price)
                                                        <span
                                                            class="sale-tag">{{$product->sale_percentage_discount}}</span>
                                                    @endif
                                                    <img src="{{$product->image_url}}" alt="#">
                                                    <div class="button">
                                                        <a href="{{route('front.products.show',$product->id)}}"
                                                           class="btn"><i
                                                                class="lni lni-cart"></i> Add to Cart</a>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <span class="category">{{$product->category->name}}</span>
                                                    <h4 class="title">
                                                        <a href="#">{{$product->name}}</a>
                                                    </h4>
                                                    <span>Quantity:{{$product->quantity}}</span>
                                                    <ul class="review">
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star"></i></li>
                                                        <li><span>4.0 Review(s)</span></li>
                                                    </ul>
                                                    <div class="price">
                                                        <span>{{App\Helpers\Currency::format( $product->price)}}</span>
                                                        @if($product->compare_price)
                                                            <span
                                                                class="discount-price">{{App\Helpers\Currency::format( $product->compare_price)}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Single Product -->
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row my-pagination">
                                    <div class="col-12">
                                        <!-- Pagination -->
                                        <div>
                                            {{$products->withQueryString()->links()}}
                                        </div>
                                        <!--/ End Pagination -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product Grids -->
    @push('scripts')
        <script src="{{asset('admin/vendor/jquery/jquery.js')}}"></script>
        <script>
            var currencyCode = '{{ config('app.currency', 'USD') }}';
        </script>

        <script>
            // Function to format currency in JavaScript
            function formatCurrency(amount, currency) {
                const formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: currency,
                });
                return formatter.format(amount);
            }

            $(document).ready(function () {
                $('#search-btn').click(function (e) {
                    e.preventDefault();
                    let searchTerm = $('#search-input').val();
                    let categoryFilters = getCheckedValues('.form-check-input:checked[name="category_id"]');
                    let priceFilters = getCheckedValues('.price-filter:checked');

                    $.ajax({
                        url: '{{ route('front.products.search') }}',
                        type: 'GET',
                        data: {
                            categories: categoryFilters,
                            prices: priceFilters,
                            searchTerm: searchTerm
                        },
                        success: function (response) {
                            updateProducts(response);
                        },
                        error: function () {
                            alert('An error occurred while fetching data.');
                        }
                    });
                });

                function getCheckedValues(selector) {
                    let values = [];
                    $(selector).each(function () {
                        values.push($(this).val());
                    });
                    return values;
                }

                function updateProducts(response) {
                    $('.single-product').remove();
                    $('.my-pagination').remove();

                    $('#loading-image').show();

                    setTimeout(function () {
                        $('#loading-image').hide();

                        $.each(response, function (index, product) {
                            var productHtml = `
                        <!-- Start Single Product -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-product">
                                <div class="product-image">
                                    ${product.sale_percentage_discount ? '<span class="sale-tag">' + product.sale_percentage_discount + '</span>' : ''}
                                    <img src="${product.image_url}" alt="#">
                                    <div class="button">
                                        <a href="http://127.0.0.1:8000/products/${product.id}" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <span class="category">${product.category.name}</span>
                                    <h4 class="title">
                                        <a href="http://127.0.0.1:8000/products/${product.id}">${product.name}</a>
                                    </h4>
                                    <span>Quantity: ${product.quantity}</span>
                                   <ul class="review">
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star"></i></li>
                                                        <li><span>4.0 Review(s)</span></li>
                                                    </ul>
                                   <div class="price">
                <span>${formatCurrency(product.price, currencyCode)}</span>
                ${product.compare_price ? '<span class="discount-price">' + formatCurrency(product.compare_price, currencyCode) + '</span>' : ''}
            </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                    `;
                            $('.row.product-content').append(productHtml);
                        });
                    }, 1000);
                }
            });
        </script>

    @endpush
</x-front-layout>

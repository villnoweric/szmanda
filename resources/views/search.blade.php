<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <style>
            .bg-green{
                background-color: #008938!important;
            }
            .pad{
                margin-top: 25px;
            }
            a:link, a:visited, a:hover, a:active { color: black }
        </style>
    </head>
    <body>
        <header class="p-3 bg-dark text-white bg-green">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
              
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/" class="nav-link px-2 text-white">Home</a></li>
                <li><a href="/about" class="nav-link px-2 text-white">About</a></li>
            </ul>
    
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" action="/search" method="get">
                <input name="sq" type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
            </form>
    
            <div class="text-end">
                <button type="button" class="btn btn-outline-light me-2">Login</button>
                <button type="button" class="btn btn-light">Sign-up</button>
            </div>
            </div>
        </div>
        </header>
        <div class="container pad">
            <h1>Search Results</h1>
            <hr>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                @foreach ($products as $product)
                <a href="/product/{{$product->sku}}" style="text-decoration: none;">
                    <div class="col">
                        <div class="card shadow-sm" style="height:390px;">
                            <div class="card-img-top" style="width:100%; height:225px; position: relative;">
                                <img src="{{ str_replace("ProductSmall","ProductMedium",json_decode($product->images,true)[0]) }}" style="width: auto;
                                height: auto;
                                position: absolute;
                                top: 0;
                                bottom: 0;
                                left: 0;
                                right: 0;
                                margin: auto; max-height:100%; max-width:100%;">
                            </div>
                            
                                        
                            <div class="card-body">
                                <h6 class="card-title" style="height: 3em;">{{ $product->name }}</h6>
                            <p class="card-text" style="height: 4em;"><br>
                                @if(isset($product->pricepoints->last()->listPrice))
                                @if($product->pricepoints->last()->onSale)
                                <span class="badge bg-primary">On Sale!</span>
                                @endif
                                @endif
                                @if($product->special_order)
                                <span class="badge bg-success">Specail Order</span>
                                @endif
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <!--<div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>-->
                                @if($product->discontinued)
                                <span class="badge bg-danger">Discontinued</span>
                                @endif
                                {{$product->pricepoints->Count()}}
                                @if(isset($product->pricepoints->last()->listPrice))
                                @if($product->pricepoints->last()->onSale)
                                <strong><strike>@convert($product->pricepoints->last()->listPrice)</strike> @convert($product->pricepoints->last()->salePrice)</strong>
                                @else
                                <strong>@convert($product->pricepoints->last()->listPrice)</strong>
                                @endif
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </body>
</html>
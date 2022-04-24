<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <style>
            .bg-green{
                background-color: #008938!important;
            }
        </style>
    </head>
    <body>
        <header class="p-3 bg-dark text-white bg-green">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
              
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{ url('/') }}" class="nav-link px-2 text-white">Home</a></li>
                <li><a href="{{ url('/about') }}/about" class="nav-link px-2 text-white">About</a></li>
            </ul>
    
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" action="{{ url('/search') }}" method="get">
                <input name="sq" type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
            </form>
    
            <div class="text-end">
                <button type="button" class="btn btn-outline-light me-2">Login</button>
                <button type="button" class="btn btn-light">Sign-up</button>
            </div>
            </div>
        </div>
        </header>
        <div class="container mt-3">
            Stats<br>
            - Products: {{ $products->count() }}<br>
            - Categories: {{ $category->count() }}<br>
            - Stores: {{ $stores->count()}}<br>
            - Price Points: {{ $pricepoints->count()}}<br>
            - Discontinued Products: {{$products->where('discontinued',1)->count()}}<br>
            - Instock Items: {{$products->where('discontinued',0)->where('special_order',0)->count()}}<br>
            - Specail Order Items: {{$products->where('special_order',1)->count()}}<br>

        </div>
    </body>
</html>
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
            img{
                width: auto;
                height: auto;
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto; max-height:100%; max-width:100%;
            }
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
            <div class="row">
                <div class="col-md-4" style=" position: relative; height: 300px">
                    <img src="{{ str_replace("ProductSmall","ProductMedium",json_decode($product->images,true)[0]) }}" width="100%" height="100%">
                </div>
                <div class="col-md-8">
                    <h2>{{$product->name}}</h2>
                    <hr>
                    {{$product->longDescription}}
                    <br><br>
                    SKU: {{$details->productDTO->sku}}<br>
                    <?php $pricepoint = $product->pricepoints->last(); ?>
                    @if($pricepoint->onSale)
                        <strike>Price: @convert($pricepoint->listPrice)</strike><br>
                        Sale Price: @convert($pricepoint->salePrice)<br>
                        Rebate: @convert($pricepoint->totalRebate)<br>
                        After Rebate: @convert($pricepoint->salePrice - $pricepoint->totalRebate)
                    @else
                        Price: @convert($pricepoint->listPrice)<br>
                        Rebate: @convert($pricepoint->totalRebate)<br>
                        After Rebate: @convert($pricepoint->listPrice - $pricepoint->totalRebate)
                    @endif
                
                </div>
            </div><hr>
            <div style="height:500px;width:100%">
                <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" width="100%" height="300px" style="display: block; height: 300px; width: 100%"></canvas>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script>
        /* globals Chart:false, feather:false */
        (function () {
        'use strict'

        feather.replace({ 'aria-hidden': 'true' })

        // Graphs
        var ctx = document.getElementById('myChart')
        // eslint-disable-next-line no-unused-vars
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels: [
                '9/17',
                '9/18',
                '9/19',
                '9/20',
                '9/21',
                '9/22',
                '9/23'
            ],
            datasets: [{
                data: [
                5.99,5.99,5.99,5.49,5.49,5.33,5.33
                ],
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#008938',
                borderWidth: 4,
                pointBackgroundColor: '#008938'
            }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            if(parseInt(value) >= 1000){
                                return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            } else {
                                return '$' + value;
                            }
                        }
                    }
                    },
                    ]
                },
                legend: {
                    display: false
                }
            }
        })
        })()
    </script>
</html>
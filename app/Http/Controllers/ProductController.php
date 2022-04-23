<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->with('pricepoints');
        
        if(request('so')){
            $products->where('special_order',request('so'));
        }

        /*if(request('d')){
            $products->where('discontinued',request('so'));
        }else{
            $products->where('discontinued',0);
        }*/

        if(request('sale')){
            $value = request('sale');
            $products->whereHas('pricepoints', function($q) use($value) {
                // Query the name field in status table
                $q->where('onSale', $value); // '=' is optional
         });
        }
        
        if(request('clear')){
            $value = request('clear');
            $products->whereHas('pricepoints', function($q) use($value) {
                // Query the name field in status table
                $q->where('onClearance', $value); // '=' is optional
         });
        }

        if(request('sq')){
            $products->where(function($q) {
                $q->where('name', 'like', '%' . request('sq') . '%')
                ->orwhere('description', 'like', '%' . request('sq') . '%')
                ->orwhere('longDescription', 'like', '%' . request('sq') . '%')
                ->orwhere('sku', 'like', request('sq'));
            });
        }

        return view('search', [
            'products' => $products->paginate(16)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('product', [
            'product' => Product::where('sku', $id)->first(),
            'details' => json_decode(file_get_contents('https://service.menards.com/ProductDetailsService/v9/products/id/' . $id . '?opt=TRUE&acc=TRUE&promo=TRUE&calc=TRUE&var=TRUE&n=3155&product=TRUE&st-prod=TRUE&rebate=TRUE&inv=TRUE&avail=TRUE&serv-pl=TRUE'),false)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

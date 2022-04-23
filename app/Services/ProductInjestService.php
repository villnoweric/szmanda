<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;

use Symfony\Component\HttpClient\HttpClient;
use App\Models\Store;
use App\Models\PricePoint;
use App\Models\Product;
class ProductInjestService
{

    public function injest($data)
    {   
        //print("Invoked\n");
        
        $products = $data;
        //Log::debug("Invoked: " . $data);
        //return $products;
        ///*
        foreach($products as $product){
            //$return .= $product['product']['sku'] . "\n";
            if(Product::where('sku',$product['product']['sku'])->count() == 0){
                $prod = new Product;
                $sku = $product['product']['sku'];
                $prod->sku = $sku;
                $prod->productId = $product['product']['productId'];
                $prod->name = $product['product']['name'];
                $prod->url = $product['product']['url'];
                $prod->description = $product['product']['description'];
                $prod->images = json_encode($product['product']['images']);
                
                
                $product_details = json_decode(file_get_contents("https://service.menards.com/ProductDetailsService/v9/products/id/$sku?product=TRUE&rebate=TRUE&inv=TRUE&avail=TRUE&st-prod=TRUE&n=3155&var=TRUE"),true);
                
                $prod->categories = json_encode($product_details['productDTO']['categoryIds']);
                $prod->longDescription = $product_details['productDTO']['longDescription'];
                if($product_details['storeProductDTO']['storeStatusCode']=="DISCONTINUED"){
                    $prod->discontinued = True;
                }
                if($product_details['storeProductDTO']['storeStatusCode']=="VENDOR_SPECIAL_ORDER"){
                    $prod->special_order = True;
                }
                if($product_details['storeProductDTO']['storeStatusCode']=="SEASONAL"){
                    $prod->seasonal = True;
                }
                $prod->save();
                
                if(isset($product_details['variationDTOs'])){
                $variations = $product_details['variationDTOs'][0]['variationValueDTOs'];
                foreach($variations as $variation){
                    $variation_product = new Product;
                    $sku = $variation['itemId'];
                    if(Product::where('sku',$product['product']['sku'])->count() == 0){
                        $variation_product->sku = $sku;
                        $variation_details = json_decode(file_get_contents("https://service.menards.com/ProductDetailsService/v9/products/id/$sku?product=TRUE&rebate=TRUE&inv=TRUE&avail=TRUE&st-prod=TRUE&n=3155&var=TRUE"),true);
                        
                        $variation_product->productId = $variation_details['productDTO']['compositeModelNumber'];
                        $variation_product->name = $variation_details['productDTO']['title'];
                        $variation_product->url = '//www.menards.com/main/' . $variation['fullUrl'];
                        $variation_product->description = $variation_details['productDTO']['shortDescription'];
                        $variation_product->longDescription = $product_details['productDTO']['longDescription'];
                        $variation_product->images = json_encode(array('//hw.menardc.com/main/' . $variation['image']));
                        $variation_product->categories = json_encode($variation_details['productDTO']['categoryIds']);
                        if($variation_details['storeProductDTO']['storeStatusCode']=="DISCONTINUED"){
                            $variation_product->discontinued = True;
                        }
                        if($variation_details['storeProductDTO']['storeStatusCode']=="VENDOR_SPECIAL_ORDER"){
                            $variation_product->special_order = True;
                        }
                        if($variation_details['storeProductDTO']['storeStatusCode']=="SEASONAL"){
                            $variation_product->seasonal = True;
                        }
                        $variation_product->save();
                    }
                    
                    //$sql = "INSERT IGNORE INTO products (sku,productId,name,url,description,longDescription,images,categories) VALUES ('$sku', '$productId', $name, '$url',$description,$longDescription,'$images','$categories')";
                    
                }
                }
            }
            
        }
        //return $return;
    }
}
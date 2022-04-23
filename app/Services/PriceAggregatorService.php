<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;

use Symfony\Component\HttpClient\HttpClient;
use App\Models\Store;
use App\Models\PricePoint;
use App\Models\Product;
class PriceAggregatorService
{
    /**
     * Make a call to to specified url and return formatted data
     * 
     * @param string $url
     * 
     * @return array
     */
    public function __invoke()
    {
        $stores = Store::where('number',3115)->get();
        $products = Product::all();
        foreach($stores as $store){
            foreach($products as $product){
                
                    $this->priceCheck($product,$store);


                //Log::debug('Product: ' . $details->productDTO->title);
                //Log::debug('Type: ' . $details->storeProductDTO->storeStatusCode);
            }
        }
    }

    public function priceCheck($product,$store){
        if(true || !$product->discontinued){
            $details = json_decode(file_get_contents("https://service.menards.com/ProductDetailsService/v9/products/id/$product->sku?n=$store->number&st-prod=TRUE&rebate=TRUE&inv=TRUE"));
            if($details->storeProductDTO->storeStatusCode == "STOCK" || $details->storeProductDTO->storeStatusCode == "VENDOR_SPECIAL_ORDER" || $details->storeProductDTO->storeStatusCode == "SEASONAL" || ($details->storeProductDTO->storeStatusCode == "DISCONTINUED" && $details->inventoryDTO->storeOnhandInventory > 0 )){
                if($details->storeProductDTO->storeStatusCode == "VENDOR_SPECIAL_ORDER"){
                    $product->special_order = True;
                    $product->save();
                }
                $pricePoint = new PricePoint;
                $pricePoint->productSku = $product->sku;
                $pricePoint->storeNumber = $store->number;
                $pricePoint->listPrice = $details->storeProductDTO->listPrice;
                //check sale
                $pricePoint->onSale = False;
                if($details->storeProductDTO->salePrice != $details->storeProductDTO->listPrice){
                    $pricePoint->onSale = True;
                    $pricePoint->salePrice = $details->storeProductDTO->salePrice;
                    if(isset($details->storeProductDTO->saleStartDateTime)){
                        $pricePoint->saleStart = $details->storeProductDTO->saleStartDateTime;
                        $pricePoint->saleEnd = $details->storeProductDTO->saleEndDateTime;
                    }
                }

                $pricePoint->onClearance = $details->storeProductDTO->clearance;
                //check rebate
                $pricePoint->isRebate = False;
                if(isset($details->rebateDisplay)){
                    $pricePoint->isRebate = True;
                    $pricePoint->totalRebate = $details->rebateDisplay->totalRebateAmount;
                    $pricePoint->rebates = json_encode($details->rebateDisplay->rebates);
                }
                $pricePoint->inventory = $details->inventoryDTO->storeOnhandInventory;
                $pricePoint->save();
            }elseif($details->storeProductDTO->storeStatusCode== "DISCONTINUED" || $details->storeProductDTO->storeStatusCode== "DELETED"){
                if($details->storeProductDTO->storeStatusCode== "DELETED"){
                    Log::debug('DELETED SKU: ' . $product->sku);
                }
                $product->discontinued = True;
                $product->save();
            }elseif($details->storeProductDTO->storeStatusCode=='SEASONAL'){
                Log::debug('SEASONAL SKU: ' . $product->sku);
            }
        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use App\SetProductVariant;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Facades\DB;
class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
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
        $product=Product::with(['getProductVariant','getProductVariant.colorName',
        'getProductVariant.getGallaryImage',
        'getProductVariant.getStleVariant',
        'getProductVariant.getStleVariant.getStyleName'
       ])->where('id',$id)->get();
      // $p=$this->getProduct($product)[0];
       return response()->json($this->getProduct($product)[0],200);
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
    public function getProductByCategory($catId)
    {
       $product=Product::with(['getProductVariant','getProductVariant.colorName',
                               'getProductVariant.getGallaryImage',
                               'getProductVariant.getStleVariant',
                               'getProductVariant.getStleVariant.getStyleName'
                              ])->orWhere("categories",$catId)->orWhere("sub_category",$catId)->get();
       return $this->getProduct($product);
                    
    }
      public function getProduct(Object $product)
    {
        $pCollection=[];
        $pGallary=[];
        $thumb=[];
        $neckStyle=[];
        $sleeveStyle=[];
        $bottomStyle=[];
        $defaultStyle=[];
        $variantCollection=[];
        $i=0;$j=0;$k=0;$l=0;$m=0;$h=0;
      if(isset($product)){                      
       foreach($product as $p){
          if(isset($p->getProductVariant)){
              foreach($p->getProductVariant as $gp){
                if(isset($gp->getStleVariant)){
                    $j=0;
                    foreach($gp->getStleVariant as $pVariant){

                        $img=json_decode($pVariant['image'],true);
                        if($pVariant['style_type']=="neck_style"){
                                  
                        if($pVariant['default_design']=="default style"){
                           $defaultStyle[$h++]=[
                                                'id'=>$pVariant->getStyleName['id'],
                                              "type"=>"neck_style",
                                              'design_name'=>$pVariant->getStyleName['style_group_name'],
                                              'design_icon'=>url("")."/".$pVariant->getStyleName['style_group_icon'],
                                              "neck_design"=>url("")."/".$img['image']
                                               ] ;
                        }else{
                                    $neckStyle[$j++]=['id'=>$pVariant->getStyleName['id'],
                                              "type"=>"neck_style",
                                              'design_name'=>$pVariant->getStyleName['style_group_name'],
                                              'design_icon'=>url("")."/".$pVariant->getStyleName['style_group_icon'],
                                              "neck_design"=>url("")."/".$img['image']
                                              ];
                        }                      
                        }elseif($pVariant['style_type']=="sleeve_style"){

                          if($pVariant['default_design']=="default style"){
                           $defaultStyle[$h++]=[
                                                'id'=>$pVariant->getStyleName['id'],
                                              "type"=>"sleeve_style",
                                              'design_name'=>$pVariant->getStyleName['style_group_name'],
                                              'design_icon'=>url("")."/".$pVariant->getStyleName['style_group_icon'],
                                               "lhand_design"=>url("")."/".$img['lhand'],
                                               "rhand_design"=>url("")."/".$img['rhand']
                                               ] ;
                           }else{
                                          $sleeveStyle[$k++]=['id'=>$pVariant->getStyleName['id'],
                                           "type"=>"sleeve_style",
                                          'design_name'=>$pVariant->getStyleName['style_group_name'],
                                          'design_icon'=>url("")."/".$pVariant->getStyleName['style_group_icon'],
                                           "lhand_design"=>url("")."/".$img['lhand'],
                                           "rhand_design"=>url("")."/".$img['rhand']
                                          ]; 
                                 }
                            
                        }elseif($pVariant['style_type']=="length_style"){
                              if($pVariant['default_design']=="default style"){
                           $defaultStyle[$h++]=[
                                              'id'=>$pVariant->getStyleName['id'],
                                              "type"=>"bottom_style",
                                              'design_name'=>$pVariant->getStyleName['style_group_name'],
                                              'design_icon'=>url("")."/".$pVariant->getStyleName['style_group_icon'],
                                              "bottom_design"=>url("")."/".$img['image']
                                               ] ;
                           }else{
                            $bottomStyle[$l++]=['id'=>$pVariant->getStyleName['id'],
                                                "type"=>"bottom_style",
                                               'design_name'=>$pVariant->getStyleName['style_group_name'],
                                              'design_icon'=>url("")."/".$pVariant->getStyleName['style_group_icon'],
                                              "bottom_design"=>url("")."/".$img['image']
                                              ]; 
                        }
                      
                        
                    }
                  }
                }
                     $j=0;
                    if(isset($gp->getGallaryImage)){
                    foreach($gp->getGallaryImage as $pGal){
                        $pGallary[$j++]=url("product/product-gallary")."/".$pGal['image'];
                    }
                    } 
                    $variantCollection[$m++]=["variants"=>["id"=>$gp->colorName['id'],
                                              "color_name"=>$gp->colorName['colorname'],                       
                                              "color_code" =>isset($gp->colorName['color_code'])?$gp->colorName   ['color_code']:"",
                                              "color_image" =>isset($gp->colorName['color_image'])?$gp->colorName ['color_image']:"",
                                              "color_vary_price"=>isset($gp->colorName['color_vary_price'])?$gp->colorName ['color_vary_price']:"",
                                              "height"=>json_decode($gp['height'],true),
                                              "product_size"=>json_decode($gp->product_size,true),
                                              "default_design"=>$defaultStyle,
                                              'neck_style'=>$neckStyle,
                                              "sleeve_style"=>$sleeveStyle,
                                              "bottom_style"=>$bottomStyle,
                                              "gallary_image"=>$pGallary]];
            }
          } 
            $m=0;
            $j=0;
            $h=0;$l=0; $k=0;
            if(isset($p['thumbnails'])){
                foreach(json_decode($p['thumbnails'],true) as $thmb){
                    $thumb[$j++]=url("product/thumbnail")."/".$thmb;
                }
            }
                      $pCollection[$i++]=[
                       "id"=>$p['id'],
                       "sku_id"=>$p->sku_id,
                       "quantity"=>$p['stock'],
                       "product_name"=>$p['pname'],
                       "product_price"=>$p['s_price'],
                       "discount"=>$p->discount."%",
                       "total_price"=>round($p->s_price-($p->s_price*$p->discount/100)),
                       "total_saving"=>round((($p->discount/100)*$p->s_price)),
                       "meta_key"=>$p->meta_key,
                       "meta_title"=>$p->meta_title,
                       'return_policy'=>$p->return_policy,
                       "shipping"=>$p->shipping=="paid"?$p->shipping_charge:"free",
                       "stock"=>$p->stock>0?"In stock":"Out of stock",
                       "short_descript"=>$p->p_s_description,
                       "long_descript"=>$p->p_description,
                       "feature_description"=>$p->feature,
                       "product_thumbnail"=> $thumb,
                       "variant_products"=>$variantCollection
                        ];
                        $pGallary=[];
                        $thumb=[];
                        $neckStyle=[];
                        $sleeveStyle=[];
                        $bottomStyle=[];
                        $variantCollection=[];              
        } 
         return $pCollection;          
        }else{
            return response()->json("Sorry no product available for this category",404);
        }                      
    }
    public function searchProduct()
    {
        $product = Product::where('pname', 'like', '%' . request('pname') . '%')->get();
        if(isset($product)){
            $pCollection=$this->product($product);
            return response()->json(["products"=>$pCollection],200);
        }else{
            return response()->json(['status'=>false,"msg"=>"Sorry no product found"]);
        }
    }
    public function product(Object $product)
    {
        $i=0;$j=0;
        $pCollection=[];
        $thumb=[];
        if(count($product)){
            foreach($product as $p){
                foreach(json_decode($p['thumbnails'],true) as $thmb){
                    $thumb[$j++]=url("product/thumbnail")."/".$thmb;
                }
                $pCollection[$i++]=[
                    "id"=>$p['id'],
                    "sku_id"=>$p->sku_id,
                    "quantity"=>$p['stock'],
                    "product_name"=>$p['pname'],
                    "product_price"=>$p['s_price'],
                    "discount"=>$p->discount."%",
                    "total_price"=>round($p->s_price-($p->s_price*$p->discount/100)),
                    "total_saving"=>round((($p->discount/100)*$p->s_price)),
                    "meta_key"=>$p->meta_key,
                    "meta_title"=>$p->meta_title,
                    'return_policy'=>$p->return_policy,
                    "shipping"=>$p->shipping=="paid"?$p->shipping_charge:"free",
                    "stock"=>$p->stock>0?"In stock":"Out of stock",
                    "short_descript"=>$p->p_s_description,
                    "long_descript"=>$p->p_description,
                    "feature_description"=>$p->feature,
                    "product_thumbnail"=> $thumb,
                     ];
                     $thumb=[];
                     $j=0;
            }
            return $pCollection;
        }
   }
    public function getUsedColor()
    {
       $color=SetProductVariant::with('colorName')->select('color_id')->groupBy("color_id")->get();
       $colorCollection=[];
       $i=0;
       if(isset($color)){
        foreach($color as $clr){
            $colorCollection[$i++]=['id'=>$clr->color_id,
                                   "color_code"=>isset($clr->colorName['color_code'])?$clr->colorName['color_code']:"",
                                   "color_image"=>$clr->colorName['color_image']!=""?url('').$clr->colorName['color_image']:"",
                                   'color_name'=>$clr->colorName['colorname']
                                   ];
           }
           return response()->json(['colors'=>$colorCollection],200);
       }else{
           return response()->json(['msg'=>"No Color Found","status"=>false],404);
       }
   
      
    }
    public function getUsedFabric()
    {
       $fabric= Product::groupBy('fabric_type')->select('fabric_type')
                        ->where('fabric_type','!=','')->get();
       $fabricCollection=[];
       $i=0;
       if(isset($fabric)){
        foreach($fabric as $fab){
            $fabricCollection[$i++]=[
                                   "fabric_type"=>$fab->fabric_type,                                                      ];
           }
           return response()->json(['fabric_collections'=>$fabricCollection],200);
       }else{
           return response()->json(['msg'=>"No fabric Found","status"=>false],404);
       }
    }
   public function sortProduct(Request $request)
    {
       $productCollection=[];$i=0;$j=0;
       $productId=[];$J=0;
       $thumb=[];
       $product="";
       $sql="select * from eshakti_products  where ";
       if(!empty($request->fabric_type) || !empty($request->color)){
         $product = SetProductVariant::select('products.*')
                    ->join('products', 'products.id', '=', 'product_id')
                    ->orWhereIn("fabric_type",$request->fabric_type)
                    ->orWhereIn('color_id',$request->color)->distinct('id')->get();
         if(count($product)>0){
             foreach($product as $p){

                 $productId[$j++]=$p['id'];
             }
           }
          }
            if(!empty($request->price_range)){
            foreach($request->price_range as $price){
              $sql .=" (s_price > ".$price['min_price']." and  s_price < ".$price['max_price'].") OR";
               }
               $sql=rtrim($sql,"OR");
               if(!empty($productId)){
                    $sql .=" AND id IN(".implode(",",array_unique($productId)).")"; 
               }
              $product=DB::select($sql);
             }
           if(!empty($request->home_filtter)){
               if($request->home_filtter['pricing_type']=="discount"){
                $sql .=" (discount > ".$request->home_filtter['min_price']." and  discount < ".$request->home_filtter['max_price'].") ";
                if(strtolower($request->home_filtter['attribute'])=="best seller"){
                 $sql .=" order by best_seller asc";
                }elseif(strtolower($request->home_filtter['attribute'])=="new arrival"){
                    $sql .=" order by id desc limit 200";
                }
               }elseif($request->home_filtter['pricing_type']=="price"){
                $sql .=" (s_price > ".$request->home_filtter['min_price']." and  s_price < ".$request->home_filtter['max_price'].") ";
                if(strtolower($request->home_filtter['attribute'])=="best seller"){
                    $sql .=" order by best_seller asc";
                   }elseif(strtolower($request->home_filtter['attribute'])=="new arrival"){
                       $sql .=" order by id desc limit 200";
                   }
               }
               $product=DB::select($sql);
           }
            
               //return $product;
               if(count($product)){
                foreach($product as $p){
                      if(json_decode($p->thumbnails)){
                        foreach(json_decode($p->thumbnails,true) as $thmb){
                            $thumb[$j++]=url("product/thumbnail")."/".$thmb;
                        }
                      }
 
                    $productCollection[$i++]=[
                        "id"=>$p->id,
                        "sku_id"=>$p->sku_id,
                        "product_name"=>$p->pname,
                        "quantity"=>$p->stock,
                        "product_price"=>$p->s_price,
                        "discount"=>$p->discount."%",
                        "total_price"=>round($p->s_price-($p->s_price*$p->discount/100)),
                        "total_saving"=>round((($p->discount/100)*$p->s_price)),
                        "meta_key"=>$p->meta_keyword,
                        "meta_title"=>$p->meta_title,
                        'return_policy'=>$p->return_policy,
                        "shipping"=>$p->shipping=="paid"?$p->shipping_charge:"free",
                        "stock"=>$p->stock>0?"In stock":"Out of stock",
                        "short_descript"=>$p->p_s_description,
                        "long_descript"=>$p->p_description,
                        "product_thumbnail"=> $thumb,
                         ];
                         $thumb=[];
                         $j=0;
                   }
               }

        return response()->json(["products"=>$productCollection],200);
       }
}

<?php

namespace App\Http\Controllers\Api;

use App\Carts;
use App\Http\Controllers\Controller;
use App\Product;
use App\Tax;
use App\User;
use Image;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
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
    public function error()
    {
        return response()->json(['error'=>[
            "status"=>false,
            "msg"=>"user id required"
        ]],406);
    }
    public function store(Request $request)
    {
      if($request->user_id=="" || $request->user_id==null){
        return self::error();
      }elseif($request->product_id=="" || $request->product_id==null){
        return self::error();
      }elseif($request->sku_id=="" || $request->product_id==null){
        return self::error(); 
      }else{
        $cdata=new Carts;
        $cdata->user_id=$request->user_id;
        $cdata->product_id=$request->product_id;
        $cdata->sku_id=$request->sku_id;
        $cdata->quantity=$request->quantity;
        $cdata->color_id=$request->color_id;
        $cdata->height=$request->height;
        $cdata->sleeve_id=$request->sleeve_id;
        $cdata->neck_id=$request->neck_id;
        $cdata->bottom_id=$request->bottom_id;
        $cdata->size_type=$request->size_type;
        $cdata->size=json_encode($request->size);
        $cdata->optional_style=json_encode($request->optional_style);
        $ad_image = time().'.' . explode('/', explode(':', substr($request->customized_image, 0, strpos($request->customized_image, ';')))[1])[1];
        \Image::make($request->customized_image)->save(public_path('customized-image/').$ad_image);
        $cdata->customized_image=$ad_image;
        //$makeImage=Image::make($orgImage);
        $cdata->save();
        $cartItems=self::show($request->user_id);
        return response()->json(["success"=>"added to cart",'cart_product'=>$cartItems],200);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
                $ct=User::with(["cartData","cartData.product",
                "cartData.colorName","cartData.sleeveName",
                "cartData.neckName","cartData.bottomName"])
          ->findOrFail($id); 
          $cart=[];
          $i=0;
          if(isset($ct)){
          foreach($ct->cartData as $item){
          $cart[$i++]=['cart_id'=>$item['id'],
              "product_id"=>$item['product_id'],
              "product_name"=>$item->product['pname'],
              "sku_id"=>$item['sku_id'],
              "price"=>$item->product['s_price']*$item['quantity'],
              "color_name"=>$item->colorName['colorname'],
              "sleeve_type"=>$item->sleeveName['style_group_name'],
              "bottom_type"=>$item->bottomName['style_group_name'],
              "neck_type"=>$item->neckName['style_group_name'],
              "quantity"=>$item['quantity'],
              "size"=>json_decode($item['size'],true),
              "height"=>$item['height'],
              "optional_style"=>json_decode($item['optional_style'],true),
              "customized_image"=>url('customized-image').'/'.$item['customized_image'], 
                ];   
            }
          }
          return $cart;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $ct= Carts::findOrFail($id);
      $ct->quantity=$request->quantity;
      if($ct->update()){
        return response()->json(['success'=>[
        'status'=>true,'msg'=>'Quantity increased']],200);
      }else{
        return response()->json(['error'=>[
        'status'=>true,'msg'=>'Something getting wrong from your side']],406);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cr=Carts::findOrFail($id);
        $cr->delete();
        return response()->json(["success"=>
        ["msg"=>'Cart items removed',
          "status"=>true
        ]],200);
    }
        public function homePageApi()
     {
        $productCollection=[]; 
        $i=0;
        $tempCollect="";
        $slider=[];$j=0;
        $post=HomePageSetting::select('content_position')->groupBy('content_position')->get();
        if(isset($post)){
            foreach($post as $postion){
                $grpBySlider=HomePageSetting::select("show_as")->groupBy("show_as")
                ->where("content_position",$postion->content_position)->get();
                if(isset($grpBySlider)){
                    foreach($grpBySlider as $grpBySlide){
                         $grpBYModule=HomePageSetting::select('page_module')
                        ->groupBy("page_module")->get();
                          
                         if(isset($grpBYModule)){
                             foreach($grpBYModule as $value){
                                //return $grpBYModule;
                                $pageModule=HomePageSetting::where('page_module',$value->page_module)
                                                           ->where('status',1)
                                                           ->orderBy('content_priority',"asc")->get();
                                if(isset($pageModule)){
                                  
                                    foreach($pageModule as $mod){
                                       
                                        if($mod->page_module=="Display Products"){
                                            if($mod->attributes=="best seller"){
                                                $product=Product::whereIn("categories",json_decode($mod->product_category,true))
                                                        ->orderBy('best_seller','asc')
                                                        ->take($mod->total_product_to_show)->get();
                                              $obj=new ProductApiController();
                                             
                                              $productCollection[$i++]=['title'=>$mod->content_title,
                                                                   'group'=>"best_seller",
                                                                   'module_type'=>"products",
                                                                   'description'=>$mod->contents,
                                                                   'content_position'=>$mod->content_position,
                                                                   'total_product_in_row'=>$mod->total_product_in_row,
                                                                   'products'=>$obj->product($product)];
                                                                 
                                              }elseif ($mod->attributes=="latest") {
                                               $product=Product::whereIn("categories",json_decode($mod->product_category,true))
                                                        ->orderBy('id','desc')
                                                        ->take($mod->total_product_to_show)->get();
                                                $obj=new ProductApiController();
                                                $productCollection[$i++]=['title'=>$mod->content_title,
                                                               'group'=>"new_arrival",
                                                               'module_type'=>"products",
                                                               'description'=>$mod->contents,
                                                               'content_position'=>$mod->content_position,      
                                                               'total_product_in_row'=>$mod->total_product_in_row,
                                                               'products'=>$obj->product($product)]; 
                                                              
                                                 }
                                        }if($mod->page_module=="Offer Banner" || $mod->page_module=="Product Banner"){
                                        if($mod->show_as=="slider"){
                                          $slider[$j++]=array('pricing_type'=>$mod->pricing_type,
                                                              "min_pricing"=>$mod->min_pricing,
                                                              "max_pricing"=>$mod->max_pricing,
                                                              "banner_url"=>url('').'/'.$mod->images
                                                             );
                                             $tempCollect=['title'=>$mod->content_title,
                                                            'group'=>$mod->attributes,
                                                            "type"=>"slider",
                                                            'module_type'=>$mod->page_module,
                                                            'description'=>$mod->contents,
                                                            'content_position'=>$mod->content_position,            
                                                            'pricing_type'=>$mod->pricing_type,
                                                            "min_pricing"=>$mod->min_pricing,
                                                            "max_pricing"=>$mod->max_pricing,
                                                            "banner_url"=>$slider];                     
                                          }elseif($mod->show_as=="single"){
                                            $productCollection[$i++]=['title'=>$mod->content_title,
                                            'group'=>$mod->attributes,
                                            "type"=>"single",
                                            'module_type'=>$mod->page_module,
                                            'description'=>$mod->contents,
                                            'content_position'=>$mod->content_position,                          
                                            'pricing_type'=>$mod->pricing_type,
                                            "min_pricing"=>$mod->min_pricing,
                                            "max_pricing"=>$mod->max_pricing,
                                            "banner_url"=>url('').'/'.$mod->images]; 
                                           
                                        }
                                      } 
                              
                                   }
                                   //return  $productCollection;      
                                }
                            
                             }
                             array_push($productCollection,$tempCollect);
                             return response()->json($productCollection,200) ;
                         }
                    }
                }
            }
           
        }
     }
}

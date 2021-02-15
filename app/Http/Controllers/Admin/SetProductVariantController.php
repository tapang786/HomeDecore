<?php

namespace App\Http\Controllers\Admin;

use App\Fabric;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductGallaryImage;
use App\ProductSize;
use App\ProductSizeValue;
use App\ProductStyleCustomization;
use App\SetProductVariant;
use App\StyleVariant;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SetProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    function removeProductGallary($id){
       SetProductVariant::destroy($id); 
    }
    public function setProductFabric(Request $r,$fabid=null)
    {
        $id=0;
        if($r->has('clrid')){
            $id=$r->clrid;
        }elseif($fabid!=""){
            $id=$fabid;
        }
        $pd= SetProductVariant::findOrFail($id);
        $pd->fabric_type=$r->fabric;
        $pd->update();                      
        return back()->with('msg','Fabric type get applied successfully');
    }
    public function editProductFabric($id)
    {
        $d['title']="Change Fabric";
        $d['fabric']=Fabric::all();
        $d['editFab']= $product=SetProductVariant::findOrFail($id);
        $d['pid']=$product->product_id;
        session()->put('clrid',$id);
        session()->pull('addVariantStyle');
        session()->put('setFabric',true);
        return view('admin.product.customization-setting',$d);
    }
     public function setProductColorVariant(Request $r)
    {
       $pd= SetProductVariant::updateOrCreate(['id'=>$r->clrid],
        [
            'color_id'=>$r->color,
            'product_id'=>$r->pid,
            'color_vary_price'=>$r->pv
        ]);
        $product=SetProductVariant::select('product_id')
                                   ->groupBy('product_id')
                                   ->where('color_id',$r->color)
                                   ->where('product_id','!=',$r->pid)->get();
          if(isset($product)){
            $p=Product::select('id','pname')->whereIn('id',$product)->get();                                 $r->session()->put('product',$p);
          }
          $r->session()->put('colorid',$pd->id); 
            $r->session()->put('clrid',$pd->id);
          return back()->with('msg','color variant applied successfully');
    }

    public function setProductGallary(Request $r)
    {
        if($r->has('gid')|| $r->gid!=""){
            $pg=ProductGallaryImage::findOrFail($r->gid);
            if($r->has('gallaryImage')){
                if(Storage::exists(url('public/product-gallary'.'/'.$pg->image))){
                    Storage::delete(url('public/product-gallary'.'/'.$pg->image));
                }
                $pg->image=$r->file('gallaryImage')->store('public/product-gallary');
            }
            $pg->product_id=$r->pid;
            $pg->set_product_variant_id=$r->colorid;
            $pg->update();
        }else{
                   if($r->has('gallaryImage')){
                    if($files=$r->file('gallaryImage')){
                    foreach($files as $file){
                    $name=uniqid().$file->getClientOriginalName();
                    $file->move('product/product-gallary',$name);
                    $pg=new ProductGallaryImage;
                    $pg->product_id=$r->pid;
                    $pg->set_product_variant_id=$r->colorid;
                    $pg->image=$name;
                    $pg->save();
                   }
                  }
                 }
              }
        $galImg=ProductGallaryImage::where('product_id',$r->pid)->where('set_product_variant_id',$r->colorid)->get();
        $r->session()->put('gallaryProduct',$galImg);
        $r->session()->put('galimg',$pg->id);
        return back()->with('msggal','product gallary image added successfully');
    }

    public function setCustomStyle(Request $r,$id,$op=null)
    {
       if($r->rid!=""){
        $sv=StyleVariant::findOrFail($r->rid);
        $sv->product_style_customization_id=$r->style_id;
          if($r->has('rhand') && $r->has('lhand')){
               $img=json_decode($sv->image,true);
               if(Storage::exists(url('').'/'.$img['lhand'])){
                Storage::delete(url('').'/'.$img['lhand']);
               }if(Storage::exists(url('').'/'.$img['rhand'])){
                Storage::delete(url('').'/'.$img['rhand']);
               }
              $rhand=$r->file('rhand')->move('product/sleeve-style',uniqid().$r->file('rhand')->getClientOriginalName());
              $lhand=$r->file('lhand')->move('product/sleeve-style',uniqid().$r->file('lhand')->getClientOriginalName());
              $sv->image=json_encode(["rhand"=>trim($rhand),"lhand"=>trim($lhand)]);
              $sv->style_type="sleeve_style";   
              $sv->default_design=$r->defaultSleeve;
          }elseif($r->has('neckimage')){
             $img=json_decode($sv->image,true);
            if(Storage::exists(url('').'/'.$img['image'])){
                Storage::delete(url('').'/'.$img['image']);
               }
             $im= $r->file('neckimage')->move('product/neck-style',uniqid().$r->file('neckimage')->getClientOriginalName());
             $sv->image=json_encode(["image"=>trim($im)]);
             $sv->style_type="neck_style";
             $sv->default_design=$r->defaultNeck;
          }elseif($r->has('length')){
             $img=json_decode($sv->image,true);
              if(Storage::exists(url('').'/'.$img['image'])){
                Storage::delete(url('').'/'.$img['image']);
               }
              $im=$r->file('length')->move('product/length-style',uniqid().$r->file('length')->getClientOriginalName());
              $sv->image=json_encode(["image"=>trim($im)]);
              $sv->style_type="length_style";
              $sv->default_design=$r->defaultLength;
          }
         $sv->update();
       }else{
             $pid=0;
           if($r->has('pid')){
             $pid=$r->pid;
           }elseif(session()->has('pid')){
             $pid=session('pid');
           }if($id){
             $styleVar=StyleVariant::where('product_gallary_image_id',$id)->first();
           }
          $sv=new StyleVariant();
          $sv->product_gallary_image_id=$id;
          $sv->product_style_customization_id=$r->style_id;
          $sv->product_id= $pid;
          $sv->set_product_variant_id=isset($styleVar)?$styleVar->set_product_variant_id:session('colorid');
          if($r->has('rhand') && $r->has('lhand')){
              $rhand=$r->file('rhand')->move('product/sleeve-style',uniqid().$r->file('rhand')->getClientOriginalName());
              $lhand=$r->file('lhand')->move('product/sleeve-style',uniqid().$r->file('lhand')->getClientOriginalName());
              $sv->image=json_encode(["rhand"=>trim($rhand),"lhand"=>trim($lhand)]);
              $sv->style_type="sleeve_style"; 
              $sv->default_design=$r->defaultSleeve;
          }elseif($r->has('neckimage')){
          $im= $r->file('neckimage')->move('product/neck-style',uniqid().$r->file('neckimage')->getClientOriginalName());
              $sv->image=json_encode(["image"=>trim($im)]);
              $sv->style_type="neck_style";
              $sv->default_design=$r->defaultNeck;
          }elseif($r->has('length')){
              $im=$r->file('length')->move('product/length-style',uniqid().$r->file('length')->getClientOriginalName());
              $sv->image=json_encode(["image"=>trim($im)]);
              $sv->style_type="length_style";
              $sv->default_design=$r->defaultLength;
        }
        $sv->save();
       } 
    }
  

    public function getSizeValue($id)
    {
        $ps=ProductSizeValue::where("product_size_id",$id)->get();
        return response()->json(['v'=>$ps]);
     }
     public function setStandardSize(Request $r)
     {
      $pd=SetProductVariant::findOrFail(session("colorid"));
      $pd->product_size=$r->size;
      $pd->save();
    
     }
     public function setAvailableHeight(Request $r)
     {
        $pd=SetProductVariant::findOrFail(session("colorid"));
        $pd->height=$r->heigh;
        $pd->update();
     }
     public function addMatchingProducts(Request $r)
     {
        $pd=SetProductVariant::findOrFail($r->clrid);
        $pd->matched_product=isset($r->mp)?json_encode($r->mp):''; 
        $pd->update();
        $r->session()->forget('product');
        $r->session()->forget('clrid');
        $r->session()->forget('colorid');
        return back();
     }
     public function resetSession()
     {
       session()->pull('product');
       session()->pull('clrid');
       session()->pull('colorid');
       session()->pull('gallaryProduct');
        return back();
     }
     public function editVariant($id,$type=null)
     {
         session()->pull('setFabric');
         session()->put('addVariantStyle',$type);  
         $d['stedit']=StyleVariant::with('getStyleName')->findOrFail($id);
         $d['title']="Edit Style Customization";
         $d['neckline']=ProductStyleCustomization::where('style_group','Neckline')->get();
         $d['sleeve']=ProductStyleCustomization::where('style_group','Sleeve Type')->get();
         $d['length']=ProductStyleCustomization::where('style_group','Length')->get();
         return view('admin.product.customization-setting',$d);
     }
     public function removeVariant($id)
     {
        $sv=StyleVariant::findOrFail($id);
        $img=json_decode($sv->image,true);
        if($sv->style_type=="sleeve_style"){
            if(Storage::exists(url('').'/'.$img['lhand'])){
                Storage::delete(url('').'/'.$img['lhand']);
               }if(Storage::exists(url('').'/'.$img['rhand'])){
                Storage::delete(url('').'/'.$img['rhand']);
               }
        }else{
            if(Storage::exists(url('').'/'.$img['image'])){
                Storage::delete(url('').'/'.$img['image']);
               }
        }
        $sv->delete();
     }
    public function removeWholeSetVariant($id,$style)
     {
        $sv=StyleVariant::where('product_gallary_image_id',$id)
        ->where('style_type',$style)->delete();
     }
   
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Category;
use App\Product;
use Gate;
use App\Attributes;
use App\AttributeTerms;
use App\ProductAttributes;
use DB;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $d['title'] = 'Shop';
        
        $request = request();
        $terms = [];
        $attr = '';
        $valus = '';
        $i = 0;
        foreach ($request->request as $key => $value) {
            # code...
            if(is_array($request->{$key})) {
                foreach ($request->{$key} as $k => $v) {
                    # code...
                    $terms[] .= $v;
                    if($k == 0 && $i == 0) {
                        $attr.= '?'.$key.'[]='.$v;
                        $i++;
                        $valus = $v;
                    }
                    else {
                        $attr.= '&'.$key.'[]='.$v;   
                        $valus .=','. $v;
                    }


                }
                //echo $key;
            }
            else {
                $terms[] .= $value;
            }
        }

        //exit;
        // Query Filter
        $products = DB::table('products');

        if($terms) {
            //
            $products->select('product_attributes.product_id as pid', 'products.*')
                    ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id');
            foreach ($terms as $tk => $trmv) {
                if(is_numeric($trmv)) {
                    $products->orWhere('term_id', $trmv);
                }
            }
            /*foreach ($request->request as $key => $value) {
                # code...
                
                $products->whereIn('term_id', function ($query) {
                    $atr = Attributes::where('slug', '=', $key)->first();
                    $atrs = ProductAttributes::where('attribute_id', '=', $atr->id)->get();
                    $ts = [];
                    foreach ($atrs as $ky => $vls) {
                        # code...
                        //$query->orWhere('IDUser', '=', 1);
                        $ts[] .= $vls->id;
                    }
                    return $ts;
                });
                if(is_array($request->{$key})) {
                    foreach ($request->{$key} as $k => $v) {
                        # code...
                        $products->orWhere('term_id', $v);
                    }
                    //echo $key;
                }
            }*/

            $products->groupBy('product_id');
            $d['products_fillter'] = true;            
        } else {
            $d['products_fillter'] = false;
        }


        $products->where('products.parent_id', '=', 0)->where('products.status', '=', 1);
        $sortby = request()->get('sortby');
        if(isset($sortby)) {
            switch( $sortby ) {
                //case 'popularity': break;
                case 'newest': 
                    $products->orderBy('products.id', 'desc'); 
                    break;
                case 'asc': 
                    $products->orderBy('products.s_price', 'asc'); 
                    break;
                case 'desc': 
                    $products->orderBy('products.s_price', 'desc'); 
                    break;
            }
            if($attr == '') {
                $attr .= '?sortby='.$sortby;
            } else {
                $attr .= '&sortby='.$sortby;
            }
        }
        // Query Filter

        // Query Filter -- Result generated
        
        $data = $products->get();

        $d['attr'] = $attr;
        $d['terms'] = $valus;
        $d['terms_valu'] = $terms;
        
        $d['products'] = $data;
        $attributes = [];
        $attribute = Attributes::orderBy('id','desc')->get();
        if(count($attribute) > 0 ) {
            //
            foreach ($attribute as $k => $v) {
            # code...
                $temp = array(
                    'id' => $v->id,
                    'name' => $v->name,
                    'slug' => $v->slug,
                );
                $attribut = AttributeTerms::where('attribute_id',$v->id)->orderBy('id','desc')->get();
                if(count($attribut) > 0) {
                    $temp['terms'] = AttributeTerms::where('attribute_id',$v->id)->orderBy('id','desc')->get();
                }
            
                array_push($attributes, $temp);
            }
            $d['attributes'] = $attributes;
        }
        return view('frontend.Shop.index',$d);
    }


    public function productFilter(Request $request)
    {
        # code...
        $products = DB::table('products');
        $terms = explode(",",$request->filter_attr);

        if($terms && $request->filter_products == '1') {
            //$products = DB::table('product_attributes')
            $products->select('product_attributes.product_id as pid', 'products.*')
                    ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id');
            foreach ($terms as $tk => $trmv) {
                $products->orWhere('term_id', $trmv);
            }
            $products->groupBy('product_id');
            $d['products_fillter'] = true;            
        } else {   
            $d['products_fillter'] = false;
        }

        if(isset($request->sortby)) {
            switch( $request->sortby ) {
                //case 'popularity': break;
                case 'newest': 
                    $products->orderBy('products.id', 'desc'); 
                    break;
                case 'asc': 
                    $products->orderBy('products.s_price', 'asc'); 
                    break;
                case 'desc': 
                    $products->orderBy('products.s_price', 'desc'); 
                    break;
            }
        }
        // Query Filter
        // Query Filter -- Result generated
        $data = $products->where('products.parent_id', '=', 0)
                        ->where('products.status', '=', 1)
                        ->get();

        $html = '';
        foreach($data as $k => $product) {
            //foreach($product as $k => $product){
            $html .= '<div class="col-sm-4 product_'.$product->id.'">';
          
                $html .= '<a href="'.url('/product').'/'.$product->slug.'">';
                if(json_decode($product->thumbnails,true)!=null){
                    $j=1;
                    foreach(json_decode($product->thumbnails,true) as $th){
                        if($j==1){
                            $html .= '<img src="'.url('/product/thumbnail').'/'.$th.'" class="imgthumbnail" alt="'.$product->pname.'">';
                        }
                        $j++;
                    }
                }
                $html .= '</a>';
                $html .= '<a href="'.url('/product').'/'.$product->slug.'">';
                $html .= '<h6 class="text-center mt-3">'.$product->pname.'</h6></a>';
                $html .= '<p class="text-center text-danger"><b>$ '.$product->s_price.'</b></p>';
            $html .= '</div>';
            //}
        }

        return response()->json(['products' => $html, 'status' => true], 200);
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
}

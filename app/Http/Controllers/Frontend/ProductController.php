<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use App\Product;
use DB;
class ProductController extends Controller
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


    public function showProduct($slug)
    {
        # code...
        $product = Product::where('slug',$slug)->first();

        $products_variants = DB::table('products_variants')->where('parent_id','=',$product->id)->get();
        $variants = [];
        $variants_values = [];
        
        foreach ($products_variants as $pvk => $pv) {
            # code...
            $variant_value = json_decode($pv->variant_value, true);
            $variant_id = json_decode($pv->variant_id, true);
            //
            foreach ($variant_value as $key => $value) {
                # code...
                if (array_key_exists($key,$variants)) {
                //
                    if(!in_array($value, $variants[$key])) {
                        $variants[$key][] = $value;
                    }
                }
                else {
                    $variants[$key][] = $value;
                }
            }

            $variant_value['id'] = $pv->id;
            $variant_value['p_id'] = $pv->p_id;
            $variant_value['product'] = Product::findOrFail($pv->p_id);
            //
            array_push($variants_values, $variant_value);
        }

        $d['variants']=$variants;
        $d['variants_values']=$variants_values;
        
        return view('frontend.product.index', ['product'=>$product]);
    }
}

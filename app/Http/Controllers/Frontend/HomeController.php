<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Product;
use App\HomePageSetting;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $home_settings = HomePageSetting::orderBy('id','desc')->get();
        $settings = [];
        foreach ($home_settings as $key => $value) {
            # code...
            $settings[$value->slug] = $value;
        }

        $data['settings']=$settings; //HomePageSetting::orderBy('id','desc')->get();

        $data['products'] = Product::orderBy('id','desc')->where('parent_id', '=', 0)->where('parent_id', '=', 0)->take(4)->get();

        $data['feature'] = Product::orderBy('id','desc')->where('feature', '=', 1)->where('parent_id', '=', 0)->take(4)->get();

        $data['sales'] = Product::orderBy('id','desc')->where('sales', '=', 1)->where('parent_id', '=', 0)->take(4)->get();

        $data['best_seller'] = Product::orderBy('best_seller','desc')->where('best_seller', '>', 0)->where('parent_id', '=', 0)->take(4)->get();

        return view('frontend.home', $data);
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

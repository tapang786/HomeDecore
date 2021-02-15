<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Attributes;
use DB;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $attributes = Attributes::get();
        $d['title']="All Attributes";
        //$d['attributes']=Attributes::get();
        $attrs = [];

        foreach ($attributes as $ak => $avlu) {
            # code...
            $temp = array(
                'id' => $avlu->id,
                'name' => $avlu->name,
                'slug' => $avlu->slug,
            );

            $attr_values = DB::table('attribute_terms')->where('attribute_id', $avlu->id)->get();

            $vls = '';
            foreach ($attr_values as $atk => $atv) {
                # code...
                if($atk == 0){
                    $vls = $atv->value;
                } else {
                    $vls .= ', '.$atv->value;
                }
            }
            $temp['values'] = $vls;
            array_push($attrs, $temp);
        }

        $d['attributes'] = $attrs;
        return view('admin.attribute.index',$d);
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
        $categ=Attributes::updateOrCreate(['id'=>$request->id],[
           'name'=>$request->input('name'),
           //'cid'=>$request->input('pname','No Parent')
        ]);
        return redirect('/admin/attribute');
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
        //abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $attr=Attributes::find($id);
        return json_encode($attr);
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
        $sts = Attributes::find($request->id);
        $sts->name = $request->name;
        $sts->cid = $request->pname;
        $sts->update();
        return redirect('/admin/categories'); 
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
        Attributes::destroy($id);
        //$this->deleteChilds($id);
        return json_encode(['status'=> true]);
    }
}

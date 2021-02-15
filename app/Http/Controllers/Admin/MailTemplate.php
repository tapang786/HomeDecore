<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MailTemplate as Template;
class MailTemplate extends Controller
{
    public function index()
    {
        $d['msg']=Template::all();
        $d['title']="Manage Mail Template";
        return view("admin.setting.mail-template",$d);

   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $d['title']="Add New Template";
        return view('admin.setting.add-mail-template',$d);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Template::updateOrCreate([ 
            'id'=>$request->mid
               ],
            [
             'status'=>$request->status,
             'name'=>$request->name,
             'subject'=>$request->subject,
             'message'=>$request->message,
             'from_email'=>$request->fromemail,
             'reply_email'=>$request->replyemail,
             'msg_cat'=>$request->msg_cat
            ]);
            return redirect('admin/mail-template');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $d['title']="Update Message";
        $d['msg']=Template::findOrfail($id);
        return view('admin.setting.add-mail-template',$d);
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
        if(request()->ajax()){
            $mg=Template::findOrFail($id);
            $mg->delete();
            return response()->json(['msg'=>"removed successfully"],200);
        }


    }
}

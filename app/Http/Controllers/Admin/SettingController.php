<?php

namespace App\Http\Controllers\Admin;

use App\EmailSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Setting;
class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $d['title']="Business Information Setting";
        $d['setting']=$st=Setting::with('countryName')->first();
         if($st->mailtype!="" && $st->mailtype=="smtp")
        {
           $d["mail"]=DB::table("email_setting")->first();
        }
        $d['country']=DB::table('countries')->orderBy("name")->get();
        return view('admin.setting.site-setting',$d);
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
    public function store(Request $req)
    {
            $st="";

        $mailtype="";
        if($req->file('logo')!=null || !empty($req->file('logo')) || $req->hasFile('logo'))
              {
                
                 $name=$req->file("logo")->getClientOriginalName();
                 $req->file("logo")->move('logo',$name);
                 $st=$name;
              }
              if($req->mail=="smtp")
              {
                $mailtype=$req->mail;
                EmailSetting::updateOrCreate(['id' => $req->mid],[
                        'host' => $req->host,
                        'port' => $req->port,
                        'encrypt' =>$req->encrypt,
                        'name'=>$req->sname,
                        'email'=>$req->semail,
                        'password'=>$req->password
                ] );
              }elseif($req->mail=="sendmail")
              {
                $mailtype=$req->mail;
              }
       $setting= Setting::updateOrCreate([
            'id'=>$req->id],
             [
               'business_name'=>$req->bname ,
               'state'=>$req->state,
               'city'=>$req->city,
               'country'=>$req->country,
               'address'=>$req->address,
               'zip'=>$req->zip,
               'helpline'=>$req->help,
               'email'=>$req->email,
               'pan'=>$req->pan,
               'cin'=>$req->cin,
               'gstin'=>$req->gstin,
               'site_url'=>$req->site_url,
               'logo'=>$st,
               'mailtype'=>$mailtype
             ]);
       return back();
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

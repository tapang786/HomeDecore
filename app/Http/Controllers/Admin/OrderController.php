<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Controller;
use App\Order;
use App\Setting;
use App\ShippingAddress;
use App\User;
use Illuminate\Http\Request;
use PDF;
use Str;
use App\ReturnedOrders;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $d['title']="Manage Order";
       $d['order']=Order::latest()->get();
       return view('admin.order.index',$d);
    }
    public function invoicePdf(Request $r)
    {
      
       $d['order']= $orderData=Order::with(['orderItem','user','shippingAddress'])
                              ->where('id',$r->id)->first();

       $d["setting"]=Setting::findOrFail(1);
        view()->share($d);

       if($r->has('download')){
        	// Set extra option
        	PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        	// pass view file

            $pdf = PDF::loadView('admin.order.invoice')->setPaper('a4', 'landscape');
            // download pdf
            
           // return $pdf->download('inv.pdf');

            //return view('admin.order.invoicePdf');
        }   
        return view('admin.order.invoice');
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
        $d['title']="Order Detail";
        $d['order']=Order::with(['orderItem','shippingAddress','user','payment'])->findOrFail($id);
        return view('admin.order.order-detail',$d);
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
    public function orderReturn()
    {
        $d['title']="Order Return Request";
        $ro=ReturnedOrders::latest()->with('order')->get();
        $d['returnProduct']=$ro;
      return view('admin.order.return-order',$d);
    }
    public function changeOrderStatus(Request $r)
    {
      $order=Order::findOrFail($r->id);
      $order->status=Str::lower($r->ost);
      $order->update();
      //$user=User::findOrFail($order['user_id']);
      //$userDetail=ShippingAddress::findOrFail($order['shipping_address_id']);
      //$ordApi=new OrderApiController();
      //$msg=$ordApi->sendEmailToUser($user, $userDetail,$order);
      //Mail::to($user->email)->send(new Orders($msg));
      return redirect()->back();

    }
}

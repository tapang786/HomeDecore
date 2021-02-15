<?php

namespace App\Http\Controllers\Api;

use App\Carts;
use App\MailTemplate;
use App\Http\Controllers\Controller;
use App\Mail\Orders;
use App\Order;
use App\OrderedProducts;
use App\Payment;
use App\Product;
use App\ReturnedOrders;
use App\Setting;
use App\ShippingAddress;
use App\Tax;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderApiController extends Controller
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
        $ct=Carts::with(["product","colorName","sleeveName",
                         "neckName","bottomName"])
        ->where("user_id",$request->user_id)->whereIn('id',$request->cart_id)->get(); 
        $ship_add=ShippingAddress::create($request->shipping_address);
        $orderData=[];
        $in=Order::latest()->first();
        $order=new Order();
        $order->user_id=$request->user_id;
        $order->shipping_charge=$request->shipping_charge;
        $order->order_date=Carbon::now();
        $order->shipping_address_id=$ship_add->id;
        $order->customization_charge=$request->customization_charge;
        $order->order_id=mt_rand(1000000, 9999999);
        if($in){
         $st= preg_replace("/[^0-9\.]/", '', $in->invoice_number);
         $order->invoice_number="ESHK".sprintf('%04d', $st+1);
        }else{
           $order->invoice_number='ESHK0000';
        }
         $order->save();
         $pay=new Payment();
         $pay->payment_mode=$request->payment['mode'];
         $pay->payment_status=$request->payment['status'];
         $pay->amount_receipt=$request->totPrice;
         $pay->order_id=$order->id;
         $pay->save();
         $i=0;
        if(isset($ct)){
        foreach($ct as $item){
                $taxes=[];$k=0;
                if(json_decode($item->product['tax_type'],true)!=null){
                    $tax=Tax::whereIn('tax_type',json_decode($item->product['tax_type'],true))->get();
                    if(isset($tax)){
                        foreach($tax as $tx){
                            $t=round((($tx->tax/100)*($item->product['s_price']*$item->quantity)));
                            $taxes[$k++]=["tax_type"=>$tx->tax_type,"tax_rate"=>$tx->tax,'tax_amount'=>$t];
                        }
                       }
                }
                $orderedP=new OrderedProducts();
                $orderedP->product_id=$item['product_id'];
                $orderedP->product_name=$item->product['pname'];
                $orderedP->product_price=$item->product['s_price'];
                $orderedP->total_price=round($item->product['s_price']-($item->product['s_price']*$item->product['discount']/100))*$item->quantity;
                $orderedP->discount=$item->product['discount'];
                $orderedP->total_saving=round((($item->product['discount']/100)*$item->product['s_price']))*$item->quantity;
                $orderedP->thumbnail=url('customized-image').'/'.$item['customized_image'];
                $orderedP->quantity=$item->quantity;
                $orderedP->sku_id=$item->sku_id;
                $orderedP->order_id= $order->id;
                $orderedP->p_price= $item->product['p_price']*$item->quantity;
                $orderedP->return_policy=Carbon::now()->addDays($item->product['return_policy']!='None'?$item->product['return_policy']:'0');
                $orderedP->tax=json_encode($taxes);
                $orderedP->color_name=$item->colorName['colorname'];
                $orderedP->sleeve_type=$item->sleeveName['style_group_name'];
                $orderedP->bottom_type=$item->bottomName['style_group_name'];
                $orderedP->neck_type=$item->neckName['style_group_name'];
                $orderedP->size=$item['size'];
                $orderedP->height=$item['height'];
                $orderedP->optional_style=$item['optional_style'];
                $orderedP->size_type=$item['size_type'];   
                $orderedP->sleeve_design_id=$item->sleeveName['design_id'];
                $orderedP->neck_design_id=$item->neckName['design_id'];
                $orderedP->bottom_design_id=$item->bottomName['design_id'];
                $orderedP->save();
               
                $orderData[$i++]=['cart_id'=>$item['id'],
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
              //Carts::where('user_id',$request->user_id)->delete();
              $user =User::findOrFail($request->user_id);
              $shipping_add=ShippingAddress::where('id',$order->shipping_address_id)->first();
              $msg=self::sendEmailToUser($user,$shipping_add,$order);
              Mail::to($user->email)->send(new Orders($msg));
              return response()->json(["success"=>
              [
                  "msg"=>"Thank's order placed ",
                  "status"=>true
                  ]
               ],200);
        }

  }

    function sendEmailToUser(User $user,ShippingAddress $userd,Order $order){
    
          $st=Setting::first();
           $orp=Order::with('orderItem')->findOrFail($order->id);
           $shipAdd=Order::findOrFail($order->id)->shippingAddress;
           $basicinfo=['{user_name}'=>$user->name,
           '{user_address}'=>$userd->address.', '.$userd->state.', '.$userd->city.', '.$userd->zip_code,
           '{order_number}'=>"#".$order->order_id,
           '{shipping_charge}'=>$order->shipping_charge,
           '{customization_charge}'=>$order->customization_charge,
           '{shipping_address}'=>$shipAdd->address.','.$shipAdd->country.','.$shipAdd->city,
           '{billing_address}'=>$shipAdd->address.','.$shipAdd->country.','.$shipAdd->city,
           '{current_date}'=>date('D-M-Y'),
           '{site_url}'=>$st->site_url,
           '{helpline_number}'=>$st->helpline,
           '{business_name}'=>$st->business_name,
           '{logo}'=>"<img src='".url('logo'.'/'.$st->logo)."' style='height:50px;width:200px;'>",
           ];
           $tax=json_decode($order->tax,true);
           $pArr=[];
           $price=[];
           $discount=[];
           $quantity=[];
           $totprice=[];
           $grossa=[];
           $taxType=[];
           $taxAmount=[];
           $grandTotal=0;
           $taxAmount=0;
           $i=0;
           if(isset($tax)){
               foreach($tax as $t){
                 $taxType[$i]=$t->tax_type;
                 $taxAmount +=$t->tax_amount;
                 $i++;
               }
           }
           if(isset($orp)){
                foreach($orp->orderItem as $op){
               $pArr[$i]=$op->product_name.'<br>';
               $price[$i]=$op->product_price.'<br>';
               $discount[$i]=$op->total_saving.'<br>';
               $quantity[$i]=$op->quantity.'<br>';
               $totprice[$i]=$op->product_price*$op->quantity.'<br>';
               $grossa[$i]=$op->total_price.'<br>';
               $grandTotal += $op->total_price;
               $i++;
           }
          }
            $msgData=MailTemplate::where('status',trim($orp->status=="new"?"placed":$orp->status))->first();
            $replMsg=MailTemplate::where('status',trim($orp->status=="new"?"placed":$orp->status))->pluck('message')->first();
            foreach($basicinfo as $key=> $info){
                $replMsg=str_replace($key,$info,$replMsg);
               }
            if(isset($pArr)){
             $replMsg= str_replace('{product_name}',str_replace(',','',implode(",",$pArr)) , $replMsg);
             $replMsg= str_replace('{price}',str_replace(',','',implode(",",$price)) , $replMsg);
             $replMsg= str_replace('{quantity}',str_replace(',','',implode(",",$quantity)) , $replMsg);
             $replMsg= str_replace('{total_price}',str_replace(',','',implode(",",$totprice)) , $replMsg);
             $replMsg= str_replace('{gross_amount}',str_replace(',','',implode(",",$grossa)) , $replMsg);
             $replMsg= str_replace('{discount}',str_replace(',','',implode(",",$discount)) , $replMsg);
             $replMsg= str_replace('{tax_type}',str_replace(',','',implode(",",$taxType)) , $replMsg);
             $replMsg= str_replace('{tax_amount}',$taxAmount , $replMsg);
             $replMsg= str_replace('{grand_total}',$grandTotal+$order->shipping_charge+$order->customization_charge,$replMsg);
             }
            return ['fromemail'=>$msgData->from_email,"replyemail"=>$msgData->reply_email,'msg'=>$replMsg,'subject'=>$msgData->subject,'name'=>$msgData->name];
          
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order= Order::with(['orderItem','shippingAddress','payment'])
        ->where('user_id',$id)->orderBy('id',"desc")->get();
        if(count($order)>0){
            return $order;
        }
       
    }
    public function orderHistoryDetail($id)
    {
        $order= Order::with(['orderItem','shippingAddress','payment'])
        ->where('id',$id)->orderBy('id',"desc")->get();
        if(count($order)>0){
            return response()->json(["order_items"=>$order],200);
        }else{
            return response()->json(["msg"=>"No Order Placed", "status"=>false],404);
        } 
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

    public function purchaseReturn(Request $r)
    {
         $order=Order::findOrFail($r->order_id);
         $order->status='return';
         $order->status_note=$r->return_reason;
         $order->update();
         $rt=new ReturnedOrders();
         $rt->order_id=$r->order_id;
         $rt->return_date=Carbon::now();
         $rt->save();
         return response()->json(['msg'=>"Thank you! request sent for return"]);
    }
}

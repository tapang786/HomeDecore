@extends('layouts.admin')
@section('content')

<div class="card">
 <div class="card-body">
<div class="form-wrap">
    <a href="{{ route('admin.mail-template.index') }}" class="btn btn-success btn-xs">View Templates</a>
<form   method="post" enctype="multipart/form-data" action="{{ route("admin.mail-template.store") }}" >
@csrf
<div class="row">
    <div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">From Name<span class=" text-danger">*</span></label>
<input type="text" id="firstName" class="form-control" placeholder="Name" name="name" value="{{ isset($msg->name)?$msg->name:"" }}" required="">
</div>
</div>
 <div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Subject<span class=" text-danger">*</span></label>
<input type="text" id="firstName" class="form-control" placeholder="message subject" name="subject" value="{{ isset($msg->subject)?$msg->subject:"" }}" required="">
<input type="hidden" name="mid" value="{{ isset($msg->id)?$msg->id:"" }}" >
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Message Category<span class=" text-danger">*</span></label>
<select name="msg_cat" class="form-control" id="msgCatg" required="">
<option value="{{ isset($msg->msg_cat)?$msg->msg_cat:"" }}">{{ isset($msg->msg_cat)?$msg->msg_cat:"Message Category" }}</option>
    <option value="sign up">Sign up Mail</option>
    <option value="order">Order Mail</option>
    <option value="contact">Contact us Mail</option>
    <option value="distributor">Distributor Request Mail</option>
    <option value="offer">Offer</option>
</select>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Message On<span class=" text-danger">*</span></label>
<select name="status" class="form-control" id="msgype" required="">
<option value="{{ isset($msg->status)?$msg->status:"" }}">{{ isset($msg->status)?$msg->status:"" }}</option>   
</select>
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">From Email</label>
<input type="text" id="firstName" class="form-control" placeholder="From Email Id" name="fromemail" value="{{ isset($msg->from_email)?$msg->from_email:"" }}" required="">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Reply From Email<span class=" text-danger">*</span></label>
<input type="text" id="firstName" class="form-control" placeholder="Reply From Email Id" name="replyemail" value="{{ isset($msg->reply_email)?$msg->reply_email:"" }}">
</div>
</div>
<div class="col-md-12">
<div class="form-group" >
<label class="control-label mb-10 text-primary">Replace Message content with this one to make dynamic<span class=" text-danger">*</span></label>
<div class="replace_msg" style="color:black;font-weight:bold;"></div>
</div>
</div>

</div>
<!--/span-->
</div>


<div class="seprator-block"></div>
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Message</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">

<div class="panel-wrapper ">
<div class="panel-body">
<textarea  name="message" class="editor1" style="height:400px;">
   {{ isset($msg->message)?$msg->message:"" }}
</textarea>
</div>
</div>
</div>
</div>
</div>
<div class="form-actions">
<button class="btn btn-success btn-icon left-icon mr-10 pull-left " > <i class="fa fa-check"></i> <span>Save & Update</span></button>
<button type="button" class="btn btn-warning pull-left">Cancel</button>
<div class="clearfix"></div>
</div>
</form>
</div>
</div>
</div>

@push('ajax-script')
<script type="text/javascript">
  $(document).on('change','#msgCatg',function() {
    var signup={signup:'Message on Signup',
               password_reset:'Message on Reset Password'
                };
    var contact={contact_us:'Message on Contact Us',
                };    
    var distributor={distributor:'Message on Distributor Request',
                };                      
    var order={placed:'Message on Order Placed',
               packed:'Message on Order Packed',
               shipped:'Message on Order Shipped',
               delivered:'Message on Order Delivered',
               cancelled:'Message on Order Cancelled',
               out_for_delivery:'Message on Order Out for delivery',
               out_for_reach:'Message on Order Out for reach',
               return:'Message on Order Order Return Request',
               refunded:'Message on Order Refunded'
                };            
         var value=$(this).val();
         if(value!="" && value=="sign up"){
            addTrigger(signup)
         }else if(value!="" && value=="order"){
           addTrigger(order)
         }else if(value!="" && value=="contact"){
           addTrigger(contact)
          }else if(value!="" && value=="distributor"){
           addTrigger(distributor)
          }
       
         function addTrigger(arg) {
          let opt="";
          $.each(arg, function(key, val) {
            opt+='<option value="'+key+'">'+val+'</option>'
          });
          $("#msgype").html(opt)  
          }
    
  });
// For trigger

  $(document).on('change','#msgCatg',function() {
    var signup=['{name}',
               '{email}',
               '{password}',
               '{site_url}',
               '{business_name}',
                ];
    var contact=['{name}',
               '{contact_subject}',
               '{order_number}',
               '{site_url}',
               '{helpline_number}',
               '{business_name}',
                ];    
    var distributor=['{distributor_name}',
               '{distributor_country}',
               '{distributor_company}',
               '{distributor_company_type}',
               '{site_url}',
               '{helpline_number}',
               '{business_name}',
                ];                      
    var order=['{user_name}',
               '{user_address}',
               '{product_name}',
               '{order_number}',
               '{price}',
               '{discount}',
               '{quantity}',
               '{total_price}',
               '{gross_amount}',
               '{current_date}',
               '{site_url}',
               '{helpline_number}',
               '{business_name}',
               '{grand_total}'
                ];           
         var value=$(this).val();
         if(value!="" && value=="sign up"){
            addTrigger(signup)
         }else if(value!="" && value=="order"){
           addTrigger(order)
         }else if(value!="" && value=="contact"){
           addTrigger(contact)
          }else if(value!="" && value=="distributor"){
           addTrigger(distributor)
          }
       
         function addTrigger(arg) {
          let opt="";
          $.each(arg, function(key, val) {
            opt+='<span class="text-dark">'+val+'</span>,&nbsp;&nbsp;'
          });
          $(".replace_msg").html(opt) 
          }
  }); 
</script>
@endpush
@endsection

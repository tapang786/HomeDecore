@extends('layouts.admin')
@section('content')

<div class="card">
 
<div class="card-body">
  <form action="{{ route("admin.setting.store") }}"  method="post" enctype="multipart/form-data" >
@csrf
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i>About Business</h6>
<hr class="light-grey-hr"/>

<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label class="control-label mb-10">Title<span class="text-danger">*</span></label>
      <input type="text" name="site_title" required class="form-control" value="{{isset($setting->title)?$setting->title:''}}">
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
      <label class="control-label mb-10">Description<span class=" text-danger">*</span></label>
      <textarea name="site_description" required class="form-control">{{ isset($setting->desc)?$setting->desc:""}}</textarea>
    </div>
  </div>
</div>


<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Business Name <span class=" text-danger">*</span></label>
<input type="text" name="bname" class="form-control" value="{{isset($setting)?$setting->business_name:''}}">
<input type="hidden" name="id" value="{{ isset($setting->id)?$setting->id:""}}">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Country <span class=" text-danger">*</span></label>
<select name="country" class="form-control countries">
  <option value="{{isset($setting)?$setting->countryName['id']:''}}">{{isset($setting)?$setting->countryName['name']:"Select Country"}}</option>
  @isset($country)
      @foreach($country as $ct)
<option value="{{ $ct->id }}">{{ $ct->name }}</option>
      @endforeach

  @endisset
</select>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">State <span class=" text-danger">*</span></label>
<!--<select name="state" class="form-control state">
<option value="{{isset($st)?$st->id:''}}">{{isset($st)?$st->name:""}}</option>  
</select>-->
<input type="text" name="state" class="form-control " value="{{isset($setting)?$setting->state:""}}">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">City <span class=" text-danger">*</span></label>
<!--<select name="city" class="form-control city">
<option value="{{isset($city)?$city->id:''}}">{{isset($city)?$city->name:""}}</option>  
</select>-->
<input type="text" name="city" class="form-control " value="{{isset($setting)?$setting->city:""}}">
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10">Address <span class=" text-danger">*</span></label>
<textarea name="address" class="form-control">{{ isset($setting->address)?$setting->address:""}}</textarea>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Zip Code <span class=" text-danger">*</span></label>
<input type="number" class="form-control" id="s_price" placeholder="zip code" name="zip" value="{{ isset($setting->zip)?$setting->zip:""}}">
</div>
</div>
<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Helpline Number </label>
<input type="number" class="form-control" id="exampleInputuname_1" placeholder="Helpline Number" name="help" value="{{ isset($setting->helpline)?$setting->helpline:""}}">
</div>
</div>
 <div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Email </label>
<input type="email" class="form-control" id="exampleInputuname_1" placeholder="Email" name="email" value="{{ isset($setting->email)?$setting->email:""}}">
</div>
</div> 
 <div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">PAN Number </label>
<input type="text" class="form-control" id="exampleInputuname_1" placeholder="PAN NUMBER" name="pan" value="{{ isset($setting->pan)?$setting->pan:""}}">
</div>
</div> 
 <div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">CIN Number </label>
<input type="text" class="form-control" id="exampleInputuname_1" placeholder="CIN NUMBER" name="cin" value="{{ isset($setting->cin)?$setting->cin:""}}">
</div>
</div> 
 <div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">GSTIN Number </label>
<input type="text" class="form-control" id="exampleInputuname_1" placeholder="GSTIN" name="gstin" value="{{ isset($setting->gstin)?$setting->gstin:""}}">
</div>
</div> 
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Business logo </label>
<input type="file" class="form-control" id="exampleInputuname_1"  name="logo" >
</div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <img src="{{ isset($setting->logo)?url('logo'.'/'.$setting->logo):'https://image.shutterstock.com/image-vector/shield-letter-s-logosafesecureprotection-logomodern-260nw-633031571.jpg'}}" style="height:100px;width:200px;" alt="logo">
    <input type="hidden" name="old_logo" value="{{ isset($setting->logo)? $setting->logo:''}}">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label mb-10">Site Url </label>
    <input type="url" class="form-control" id="exampleInputuname_1"  name="site_url" placeholder="www.twistshake.com" value='{{ isset($setting->site_url)?$setting->site_url:""}}'
    >
  </div>
</div>
</div>
<div class="seprator-block"></div>
<h6>Mail Setting</h6>
<hr class="light-grey-hr"/>
<div class="row">
  <div class="col-sm-6">
    @if($setting->mailtype=="sendmail")
    <input type="radio" name="mail" value="sendmail" class="form-check mail" checked=""> Send Mail
    @else
    <input type="radio" name="mail" value="sendmail" class="form-check mail" > Send Mail
    @endisset
  </div>
  <div class="col-sm-6">
    @if($setting->mailtype=="smtp")
    <input type="radio" name="mail" value="smtp" class="form-check mail" checked=""> SMTP
    @else
         <input type="radio" name="mail" value="smtp" class="form-check mail" > SMTP
        @endif 
  </div>
</div>
<br>



<div class="row {{ $setting->mailtype=="sendmail"?'mailform':'' }}">
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10">SMTP HOST </label>
<input type="text" class="form-control" id="exampleInputuname_1" placeholder="smtp.gmail.com" name="host" value="{{ isset($mail->host)?$mail->host:""}}">
<input type="hidden" name="mid" value="{{ isset($mail->id)?$mail->id:'' }}">
</div>
</div>

<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10">PORT </label>
<input type="text" class="form-control" id="exampleInputuname_1" placeholder="port" name="port" value="{{ isset($mail->port)?$mail->port:""}}">
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10">Mail Encryption </label>
<select name="encrypt" class="form-control">
  <option value="{{ isset($mail->encrypt)?$mail->encrypt:''}}">{{ isset($mail->encrypt)?$mail->encrypt:"Select Mail Encryption"}}</option>
  <option>ssl</option>
  <option>tls</option>
</select>
</div>
</div>

<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10">Sender Name </label>
<input type="text" class="form-control" id="exampleInputuname_1" placeholder="name" name="sname" value="{{ isset($mail->name)?$mail->name:""}}">
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10">Email id </label>
<input type="text" class="form-control" id="exampleInputuname_1" placeholder="email" name="semail" value="{{ isset($mail->email)?$mail->email:""}}">
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10">Password </label>
<input type="password" class="form-control" id="exampleInputuname_1" placeholder="password" name="password" {{ isset($mail->password)?$mail->password:""}} autocomplete="false">
</div>
</div>
</div>


{{-- <div class="row">
  <div class="col-sm-6">
    @if($setting->mailtype=="sendmail")
    <input type="radio" name="mail" value="sendmail" class="form-check mail" checked=""> Send Mail
    @else
    <input type="radio" name="mail" value="sendmail" class="form-check mail" > Send Mail
    @endisset
  </div>
  <div class="col-sm-6">
    @if($setting->mailtype=="smtp")
    <input type="radio" name="mail" value="smtp" class="form-check mail" checked=""> SMTP
    @else
         <input type="radio" name="mail" value="smtp" class="form-check mail" > SMTP
        @endif 
  </div>
</div>
<br> --}}



</div>

<div class="form-actions">
<button class="btn btn-success btn-icon left-icon mr-10 pull-left "> <i class="fa fa-check"></i> <span>Save</span></button>
<button type="button" class="btn btn-warning pull-left">Cancel</button>
<div class="clearfix"></div>
</div>
</form>
</div>
</div>

@push('ajax-script')
<script type="text/javascript">
  $(document).ready(function() {
    $(".mailform").hide();
    $(document).on('click', '.mail', function(event) {
      var v=$(this).val();
      v=="smtp"?$(".mailform").show():$(".mailform").hide();
    });
  });
</script>
@endpush
@endsection

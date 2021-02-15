<div class="preview-pic tab-content">
  @php $i=1 @endphp
  @isset($product)
    @foreach(json_decode($product->thumbnails,true) as $thumb)
      @if($i==1)
         <div class="tab-pane active" id="product_{{ $i++ }}"><img src="{{ url('product/thumbnail') }}/{{ $thumb }}" class="img-fluid" style="margin-left:9px;height:430px;"></div> 
         @else
            <div class="tab-pane " id="product_{{ $i++ }}"><img src="{{ url('product/thumbnail') }}/{{ $thumb }}" class="img-fluid" style="margin-left:9px;height:430px;"></div> 
       @endif  
    @endforeach
  @endisset
</div>
<ul class="preview-thumbnail nav nav-tabs" style="padding-bottom: 56px;">
   @php $i=1 @endphp
  @isset($product)
    @foreach(json_decode($product->thumbnails,true) as $thumb)
      @if($i==1)
         <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#product_{{ $i++ }}"><img src="{{ url('product/thumbnail') }}/{{ $thumb }}" style="height:50px;width:50px;"></a></li>
         @else
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product_{{ $i++ }}"><img src="{{ url('product/thumbnail') }}/{{ $thumb }}" style="height:50px;width:50px;"></a></li>
       @endif  
    @endforeach
  @endisset                                    
</ul>  
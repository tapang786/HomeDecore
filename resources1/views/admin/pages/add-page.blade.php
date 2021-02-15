@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header ">
        <h4 class="card-title">
            {{ $title }} 
        </h4>
    </div>
<div class="card-body">
        <form action="{{ route("admin.pages.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Page Group*</label>
               <select class="form-control" name="page" >
                   <option>{{ isset($page->page_title)?$page->page_title:'Select page option' }}</option>
                   <option>Contact us</option>
                   <option>Orders</option>
                   <option>Partner</option>
                   <option>About</option>
               </select>
    
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Page name*</label>
                    <input type="text" id="name" name="pagename" class="form-control" value="{{ isset($page->page_sub_title)?$page->page_sub_title:'' }}" required>
                    <input type="hidden" id="name" name="pid" class="form-control" value="{{ isset($page->id)?$page->id:'' }}" required>
          
                </div>
                <div class="form-group {{$errors->has('email')?'has-error' : '' }}">
                    <label for="email">Page Contents*</label>
                <textarea style="height:400px !important;" class="editor1 form-control" name="content">{{isset($page->page_subtitle_content)?$page->page_subtitle_content:'' }}</textarea>
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Meta Title</label>
                <input type="text" id="name" name="meta_title" class="form-control" value="{{isset($page->meta_title)?$page->meta_title:'' }}" >
                </div>
                <div class="form-group {{$errors->has('email')?'has-error' : '' }}">
                    <label for="email">Meta Keyword</label>
                <textarea  class=" form-control" name="meta_keyword">{{isset($page->meta_keyword)?$page->meta_keyword:'' }}</textarea>
                </div>
          
       
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }} & Update">
            </div>
        </form>
    </div>
</div>
@endsection

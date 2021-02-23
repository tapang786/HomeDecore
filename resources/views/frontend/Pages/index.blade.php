@extends('layouts.master')
<title>{{ $page->page_title }}</title>
@section('content')


    <section class="page-content">
      <div class="container">
        {!! $page->page_subtitle_content !!}
      </div>
    </section>

    
@endsection
@section('scripts')
@parent

@endsection
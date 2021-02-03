
    <!-- Main Content -->
    @extends('front.layouts.master')
    @section('title') {{$page->title}} @endsection
    @section('time') {{$page->created_at}} @endsection
    @section('article-image') {{$page->image}} @endsection

    @section('content')     
    <div class="col-md-10 mx-auto">
        {!! $page->content !!}    
    </div>
    
    @endsection
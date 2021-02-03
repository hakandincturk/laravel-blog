
    <!-- Main Content -->
    @extends('front.layouts.master')
    @section('title') {{$article->title}} @endsection
    @section('time') {{$article->created_at}} @endsection
    @section('article-image') {{$article->image}} @endsection

    @section('content')     
    <div class="col-md-9 mx-auto">
        {!! $article->content !!}
        <br>
        <span class="text-danger">Okunma sayısı: <b>{{$article->hit}}</b></span>
    </div>
    @include('front.widgets.categoryWidget')
    
    @endsection


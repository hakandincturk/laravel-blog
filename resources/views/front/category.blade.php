    <!-- Main Content -->
    @extends('front.layouts.master')
    @section('title') {{$category->name}} Kategorisi | {{count($articles)}} Adet Yazı bulundu @endsection
    @section('content')     
    <div class="col-md-9 mx-auto">
       @include('front.widgets.articleList')
    </div>
    @include('front.widgets.categoryWidget')
    @endsection
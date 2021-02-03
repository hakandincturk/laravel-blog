@isset($categories)
<div class="col-md-3">
    <div class="card card-header">
        Kategoriler
    </div>
    <div class="list-group">
        @foreach ($categories as $category)
            <a @if(Request::segment(2) != $category->slug) href="{{route('category', $category->slug)}}" @endif class="list-group-item list-group-item-action @if(Request::segment(2) == $category->slug) active @endif">{{$category->name}} <span class="badge badge-primary badge-pill float-right text-white">{{$category->articleCount()}}</span></a>
        @endforeach
    </div>
</div>
@endisset
@if (count($articles) > 0)    
    @foreach ($articles as $article)
    <div class="post-preview">
        <a href="{{route('single', [$article->getCategoryName->slug, $article->slug])}}">
            <h2 class="post-title">{!! $article->title !!}</h2>
            <h3 class="post-subtitle"> {{ Str::limit($article->content, 75, $end='...')}}</h3>
        </a>
        <p class="post-meta">
            Kategori: <a href="#">{{$article->getCategoryName->name}}</a>  
            <span class="float-right">{{$article->created_at->diffForHumans()}}</span>    
        </p>
        
    </div>
    @if (!$loop->last) <hr>     @endif
    @endforeach
    {{$articles->links('pagination::bootstrap-4')}} 
@else <div class="alert alert-danger">Bu kategoriye ait yazı bulunamadı.</div>
@endif
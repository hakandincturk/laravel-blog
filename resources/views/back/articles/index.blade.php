@extends('back.layouts.master')
@section('title') Tüm Makaleler @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">@yield('title')
            <span class="float-right">
                {{$articles->count()}} adet makale bulundu. 
                <a href="{{route('admin.makaleler.trashed')}}" class="btn btn-warning btn-sm ml-2"><i class="fa fa-trash"> Silinen Makaleler</i></a>
            </span>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fotoğraf</th>
                        <th>Makale Başlığı</th>
                        <th>Kategori</th>
                        <th>Görüntülenme Sayısı</th>
                        <th>Oluşturma Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>
                                <img src="{{asset($article->image)}}" width="200"/>
                            </td>
                            <td>{{$article->title}}</td>
                            <td>{{$article->getCategoryName->name}}</td>
                            <td>{{$article->hit}}</td>
                            <td>{{$article->created_at->diffForHumans()}}</td>
                            <td>
                               <input class="switch" articleId="{{$article->id}}" type="checkbox" data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" @if($article->status == 1) checked @endif>
                            </td>
                            <td>
                                <a href="{{route('single', [$article->getCategoryName->slug, $article->slug])}}" target="_blank" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                <a href="{{route('admin.makaleler.edit', $article->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                                <a href="{{route('admin.delete.article', $article->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('css')
    <!-- Toggle Css -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('js')
    <!-- Toggle Js -->
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function() {
          $('.switch').change(function() {
            articleId = $(this)[0].getAttribute('articleId');
            status = $(this).prop('checked');
            $.get( "switch", {id:articleId, status:status} ,function( data, status) {});
          })
        })
      </script>
@endsection
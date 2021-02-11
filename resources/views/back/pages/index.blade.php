@extends('back.layouts.master')
@section('title') Tüm Sayfalar @endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">@yield('title')
            <span class="float-right">
                {{$pages->count()}} adet sayfa bulundu. 
            </span>
        </h6>
    </div>
    <div class="card-body">
        <div id="orderSuccess" style="display: none" class="alert alert-success">
            Sıralama başarıyla değiştirildi.
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sıralama</th>
                        <th>Fotoğraf</th>
                        <th>Sayfa Başlığı</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody id="orders">
                    @foreach ($pages as $page)
                        <tr id="page_{{$page->id}}">
                            <td style="width:4px !important;" class="text-center"><i class="fa fa-arrows-alt-v fa-2x handle" style="cursor: move"></i></td>
                            <td>
                                <img src="{{asset($page->image)}}" width="200"/>
                            </td>
                            <td>{{$page->title}}</td>
                            <td>
                               <input class="switch" pageId="{{$page->id}}" type="checkbox" data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" @if($page->status == 1) checked @endif>
                            </td>
                            <td>
                                <a href="{{route('page', $page->slug)}}" target="_blank" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                <a href="{{route('admin.pages.edit', $page->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                                <a href="{{route('admin.pages.delete', $page->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
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
    <!-- Sortable.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
    
    <script>
        $('#orders').sortable({
            handle:'.handle',
            update:function(){
                var orders = $('#orders').sortable('serialize');
                $.get("sayfalar/orders?"+orders, function(data, status){
                    $('#orderSuccess').fadeIn().delay(1000).fadeOut();
                });
            }
        });

        $(function() {
          $('.switch').change(function() {
            pageId = $(this)[0].getAttribute('pageId');
            statu = $(this).prop('checked');
            $.get( "page/switch", {id:pageId, statu:statu} ,function( data, status) {});
          })
        })
      </script>
@endsection
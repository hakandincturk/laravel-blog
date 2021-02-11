@extends('back.layouts.master')
@section('title') Tüm Kategoriler @endsection
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('admin.categories.create')}}">
                        @csrf
                        <div class="form-group">
                            <label>Kategori Adı</label>
                            <input type="text" class="form-control" name="category" required/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Ekle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-8">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Kategori Adı</th>
                                    <th>Makale Sayısı</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->articleCount()}}</td>
                                        <td>
                                           <input class="switch" categoryId="{{$category->id}}" type="checkbox" data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" @if($category->status == 1) checked @endif>
                                        </td>
                                        <td>
                                            <a title="Düzenle" catId="{{$category->id}}" class="btn btn-sm btn-primary edit-click"><i class="fa fa-pen"></i></a>
                                            <a title="Sil" categoryId="{{$category->id}}" categoryCount="{{$category->articleCount()}}" categoryName={{$category->name}} class="btn btn-sm btn-danger remove-click"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal 1 -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Kategoriyi Düzenle</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{route('admin.categories.update')}}">
                  @csrf
                  <div class="formm-group">
                      <label>Kategori Adı</label>
                      <input id="category" type="text" class="form-control" name="category"/>
                      <input type="hidden" name="id" id="categoryId" />
                  </div>
                  <div class="formm-group">
                      <label>Kategori Slug</label>
                      <input id="slug" type="text" class="form-control" name="slug"/>
                  </div>
              
            </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-success">Kaydet</button>
                </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal 2 -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Kategoriyi sil</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div id="body" class="modal-body alert alert-danger mt-3">
              <div id="articleAlert"></div>
            </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                <form method="POST" action="{{route('admin.categories.delete')}}">
                    @csrf
                    <input type="hidden" name="id" id="deleteId">
                    <button id="deleteButton" type="submit" class="btn btn-success">Sil</button>
                </form>
                </div>
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
            $('.edit-click').click(function(){
                categoryId = $(this)[0].getAttribute('catId');
                $.ajax({
                    type:'GET',
                    url:'kategori/getData',
                    data:{id:categoryId}, 
                    success:function(data){
                        $('#category').val(data.name);
                        $('#slug').val(data.slug);
                        $('#categoryId').val(data.id);
                        $('#editModal').modal();
                    }
                });
            });

            $('.remove-click').click(function(){
                categoryId = $(this)[0].getAttribute('categoryId');
                categoryCount = $(this)[0].getAttribute('categoryCount');
                categoryName = $(this)[0].getAttribute('categoryName');

                if(categoryId == 1){
                    $('#articleAlert').html(categoryName+' kategorisi silinemez. Silinen diğer kategorilere ait makaleler bu kategoriye eklenir.');
                    $('#deleteButton').hide();
                    $('#body').show();
                    $('#deleteModal').modal();
                    return;
                }

                $('#articleAlert').html('');
                $('#deleteButton').show();
                $('#body').hide();
                $('#deleteId').val(categoryId);
                if(categoryCount > 0){
                    $('#articleAlert').html('Bu kategoriye ait '+categoryCount+' adet makale bulunmaktadır. Silmek istediğinize emin misiniz?');
                    $('#body').show();
                    
                }
                $('#deleteModal').modal();
            });

          $('.switch').change(function() {
            categoryId = $(this)[0].getAttribute('categoryId');
            status = $(this).prop('checked');
            $.get( "cs", {id:categoryId, statu:status} ,function( data, status) {});
          })
        })
      </script>
@endsection
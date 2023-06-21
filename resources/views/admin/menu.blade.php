@extends('layouts.admin')

@section('content')
<div class="pagetitle">
    <h1>Menu</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Menu</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  
  <section class="section dashboard">
    <div class="card mb-5 mb-xl-8">
      <!--begin::Header-->
      <div class="card-header border-0">
        <div class="card-toolbar">
          <a class="btn btn-success text-white mt-3" onclick="$('#createModal').modal('show');"><i class="fas fa-plus mr-2"></i>Tambah Menu</a>
        </div> 
      </div>
      <!--end::Header-->
      <!--begin::Body-->
      <div class="card-body py-3">
        <!--begin::Table container-->
        <div class="table-responsive">
          <!--begin::Table-->
          <table id="table-menu" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Menu</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
                <th style="width: 100px;">Aksi</th>
              </tr>
            </thead>
          </table>
          <!--end::Table-->
        </div>
        <!--end::Table container-->
      </div>
      <!--begin::Body-->
  </div>
  </section>
  
  <!-- Modal Create -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Tambah Data Menu</h5>
          <button type="button" class="btn" onclick="$('#createModal').modal('hide');" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <form id="scopeForm" name="scopeForm" enctype="multipart/form-data" method="POST" action="{{ route('admin.menu.store') }}" class="form-horizontal">
          <div class="modal-body">
            @csrf
            <div class="form-group">
                <center><img width="100%" src="{{ asset('admin/img/default.png') }}" id="prev" alt="image"></center>
                <br>
                <center><input accept="image/*" type="file" class="form-control" name="img" id="image" required><center>
              </div>
            <div class="form-group mt-6">
                <label for="nama" class="control-label">Kategori Menu:</label>
                <div class="mt-2">
                  <select name="kategori_menu_id" class="form-control" required id="kategori_menu_id">
                    <option selected value="" disabled>Pilih Kategori Menu</option>
                    @foreach ($kategoriMenu as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="form-group mt-6">
                <label for="nama" class="control-label">Nama Menu:</label>
                <div class="mt-2">
                    <input type="text" required class="form-control" id="nama_menu" name="nama_menu" placeholder="Masukan Nama Menu...">
                </div>
            </div>
            <div class="form-group mt-6">
                <label for="nama" class="control-label">Deskripsi:</label>
                <div class="mt-2">
                    <input type="text" required class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi...">
                </div>
            </div>
            <div class="form-group mt-6">
              <label for="nama" class="control-label">Harga:</label>
              <div class="mt-2">
                  <input type="number" required class="form-control" id="harga" name="harga" placeholder="Masukan Harga...">
              </div>
            </div>
            <div class="form-group mt-6">
              <label for="nama" class="control-label">Stok:</label>
              <div class="mt-2">
                  <input type="number" required class="form-control" id="stok" name="stok" placeholder="Masukan Stok...">
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Unggah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  {{-- Modal Edit --}}
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Data Menu</h5>
          <button type="button" class="btn" onclick="$('#editModal').modal('hide');" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <form id="updateForm" name="scopeForm" enctype="multipart/form-data" method="POST" action="" class="form-horizontal">
            <div class="modal-body">
                @method('PATCH')
                @csrf
                <div class="form-group">
                  <center><img width="100%" src="" id="prevUpdate" alt="image"></center>
                  <br>
                  <center><input accept="image/*" type="file" name="img" id="imageUpdate" class="form-control"><center>
                </div>
                <div class="form-group mt-6">
                  <label for="nama" class="control-label">Kategori Menu:</label>
                  <div class="mt-2">
                    <select name="kategori_menu_id" class="form-control" required id="kategori_menu_id_update">
                      <option selected value="" disabled>Pilih Kategori Menu</option>
                      @foreach ($kategoriMenu as $item)
                          <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                      @endforeach
                    </select>
                  </div>
              </div>
                <div class="form-group mt-6">
                    <label for="nama" class="control-label">Nama Menu:</label>
                    <div class="mt-2">
                        <input type="text" required class="form-control" id="nama_menu_update" name="nama_menu" placeholder="Masukan Nama Menu...">
                    </div>
                </div>
                <div class="form-group mt-6">
                    <label for="nama" class="control-label">Deskripsi:</label>
                    <div class="mt-2">
                        <input type="text" required class="form-control" id="deskripsi_update" name="deskripsi" placeholder="Masukan Deskripsi...">
                    </div>
                </div>
                <div class="form-group mt-6">
                  <label for="nama" class="control-label">Harga:</label>
                  <div class="mt-2">
                      <input type="number" required class="form-control" id="harga_update" name="harga" placeholder="Masukan Harga...">
                  </div>
                </div>
                <div class="form-group mt-6">
                  <label for="nama" class="control-label">Stok:</label>
                  <div class="mt-2">
                      <input type="number" required class="form-control" id="stok_update" name="stok" placeholder="Masukan Stok...">
                  </div>
                </div>
              </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
{{-- AJAX READ --}}
<script>
    $(document).ready( function () {
        var table = $('#table-menu').DataTable({
            processing  : true,
            serverSide  : true,
            ajax        : "{{route('admin.menu.ajax')}}",
            columns     : [
                {data   : 'DT_RowIndex', name: 'DT_RowIndex', orderlable: false, searchable: false},
                {data   : 'img', name: 'img', render: function(data){
                    return `<a href="{{Storage::url('menu/`+data+`')}}">`+`<img src="{{Storage::url('menu/`+data+`')}}" width="100" class="prevImage" />`+`</a>`;
                }},
                {data   : 'nama_menu', name: 'nama_menu'},
                {data   : 'deskripsi', name: 'deskripsi'},
                {data   : 'harga', name: 'harga'},
                {data   : 'stok', name: 'stok'},
                {data   : 'aksi', name: 'aksi', className:'text-center', orderlable: false, searchable: false},
            ],
        });
    });

    function editModal(id){
        $.get("{{url('admin/menu/edit')}}" + "/" +id, function(data){
            $('#updateForm').attr('action', "{{ url('admin/menu/update') }}"+"/"+id);
            $('#prevUpdate').attr('src', "{{Storage::url('menu')}}" + "/" + data.img);
            $('#nama_menu_update').val(data.nama_menu);
            $('#deskripsi_update').val(data.deskripsi);
            $('#harga_update').val(data.harga);
            $('#kategori_menu_id_update').val(data.kategori_menu_id);
            $('#stok_update').val(data.stok);
            $('#editModal').modal('show');
        });
    }

    function destroy(id){
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) { 
                $.ajax({
                    type    : 'DELETE',
                    url     : "{{url('admin/menu/delete')}}" +"/"+id,
                    data    : {_token   : "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data)
                        if(data.status == 'success'){
                            Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                            )}
                        else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: data.message
                            });
                        }
                        $('#table-menu').DataTable().ajax.reload();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            } 
            else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Dibatalkan',
                    'Foto tidak jadi dihapus :)',
                    'error')
            }
        })
    }

    image.onchange = evt => {
      const [file] = image.files
    if (file) {
        prev.src = URL.createObjectURL(file)
        }
    }
    imageUpdate.onchange = evt => {
      const [file] = imageUpdate.files
    if (file) {
        prevUpdate.src = URL.createObjectURL(file)
        }
    }
</script>
@endpush
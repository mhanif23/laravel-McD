@extends('layouts.admin')

@section('content')
<div class="pagetitle">
    <h1>Meja</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Meja</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  
  <section class="section dashboard">
    <div class="card mb-5 mb-xl-8">
      <!--begin::Header-->
      <div class="card-header border-0">
        <div class="card-toolbar">
          <a class="btn btn-success text-white mt-3" onclick="$('#createModal').modal('show');"><i class="fas fa-plus mr-2"></i>Tambah Meja</a>
        </div> 
      </div>
      <!--end::Header-->
      <!--begin::Body-->
      <div class="card-body py-3">
        <!--begin::Table container-->
        <div class="table-responsive">
          <!--begin::Table-->
          <table id="table-meja" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
            <thead>
              <tr>
                <th>No</th>
                <th>Nomor Meja</th>
                <th>Status</th>
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
          <h5 class="modal-title" id="createModalLabel">Tambah Data meja</h5>
          <button type="button" class="btn" onclick="$('#createModal').modal('hide');" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <form id="scopeForm" name="scopeForm" enctype="multipart/form-data" method="POST" action="{{ route('admin.meja.store') }}" class="form-horizontal">
          <div class="modal-body">
            @csrf
            <div class="form-group mt-6">
                <label for="nomor" class="control-label">Nomor Meja:</label>
                <div class="mt-6">
                    <input type="text" required class="form-control" id="nomor_meja" name="nomor_meja" placeholder="Masukan Nomor Meja...">
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
          <h5 class="modal-title" id="editModalLabel">Edit Data Meja</h5>
          <button type="button" class="btn" onclick="$('#editModal').modal('hide');" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <form id="updateForm" name="scopeForm" enctype="multipart/form-data" method="POST" action="" class="form-horizontal">
            <div class="modal-body">
                @method('PATCH')
                @csrf
                <div class="form-group mt-6">
                    <label for="nomor" class="control-label">Nomor Meja:</label>
                    <div class="mt-2">
                        <input type="text" required class="form-control" id="nomor_meja_update" name="nomor_meja" placeholder="Masukan Nomor Meja...">
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
        var table = $('#table-meja').DataTable({
            processing  : true,
            serverSide  : true,
            ajax        : "{{route('admin.meja.ajax')}}",
            columns     : [
                {data   : 'DT_RowIndex', name: 'DT_RowIndex', orderlable: false, searchable: false},
                {data   : 'nomor_meja', name: 'nomor_meja'},
                {data   : 'aksi', name: 'aksi', className:'text-center', orderlable: false, searchable: false},
            ],
        });
    });

    function editModal(id){
        $.get("{{url('admin/meja/edit')}}" + "/" +id, function(data){
            $('#updateForm').attr('action', "{{ url('admin/meja/update') }}"+"/"+id);
            $('#nomor_meja_update').val(data.nomor_meja);
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
                    url     : "{{url('admin/meja/delete')}}" +"/"+id,
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
                        $('#table-meja').DataTable().ajax.reload();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            } 
            else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Dibatalkan',
                    'Data tidak jadi dihapus :)',
                    'error')
            }
        })
    }
</script>
@endpush
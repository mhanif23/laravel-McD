@extends('layouts.app')

@section('content')
<!--::exclusive_item_part start::-->
<section class="exclusive_item_part blog_item_section">
    <div class="container">
        <div class="row">
            <div class="col-xl-5">
                <div class="section_tittle">
                    <p>Tambah pesanan di halaman utama</p>
                    <h2>Our Keranjang</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form method="POST" action="{{ route('simpan-pesanan') }}">
                    @csrf
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Menu</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($keranjang as $key => $item)
                                <input type="hidden" name="keranjang_id[]" value="{{ $item->id }}">
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_menu }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp. {{ number_format($item->harga, 2, ",", ".") }}</td>
                                    <td>Rp. {{ number_format($item->total_harga, 2, ",", ".") }}</td>
                                    <td>
                                        <button type="button" onclick="destroy({{$item->id}})" class="btn btn-sm btn-danger ml-2"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
        
                                @php
                                    $total += $item->total_harga;
                                @endphp
                            @endforeach
                        </tbody>
                        {{-- <tfoot class="bg-secondary text-white">
                            <tr>
                                <th colspan="6">Total</th>
                                <th>Rp. {{ number_format($total, 2, ",", ".") }}</th>
                                <td></td>
                            </tr>
                        </tfoot> --}}
                    </table>

                    <div class="row">
                        <div class="col text-right">
                            Total Harga: Rp. {{ number_format($total, 2, ",", ".") }} <br>
                            <button class="btn btn-danger btn-sm mt-4" type="submit">Pesan Sekarang</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--::exclusive_item_part end::-->
<br>
<br>
<br>
<br>
@endsection


@push('js')
<script>
    function destroy(id){
        console.log('id', id)
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Akan menghapus item dari keranjang!",
          icon: 'error',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.value) { 
                $.ajax({
                    type    : 'DELETE',
                    url     : "{{url('keranjang/delete')}}" +"/"+id,
                    data    : {_token   : "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data)
                        if(data.status == 'success'){
                            Swal.fire(
                            'Deleted!',
                            'Keranjang berhasil dihapus.',
                            'success'
                            )}
                        else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: data.message
                            });
                        }
                        location.reload();
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
</script>
@endpush
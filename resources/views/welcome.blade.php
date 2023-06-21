@extends('layouts.app')

@section('content')
<!-- about part start-->
<section class="about_part">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-4 col-lg-5 offset-lg-1">
                <div class="about_img">
                    <img src="{{asset('img/about.png')}}" alt="">
                </div>
            </div>
            <div class="col-sm-8 col-lg-4">
                <div class="about_text">
                    <h5>Our History</h5>
                    <h2>Where The Food’s As Good
                        As The Root Beer.</h2>
                    <h4>Satisfying people hunger for simple pleasures</h4>
                    <p>May over was. Be signs two. Spirit. Brought said dry own firmament lesser best sixth deep
                        abundantly bearing, him, gathering you
                        blessed bearing he our position best ticket in month hole deep </p>
                    <a href="#" class="btn_3">Read More <img src="{{asset('img/icon/left_2.svg')}}" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about part end-->

<!-- food_menu start-->
@if (@Auth::user()->role_name == "guest")
    <section class="food_menu gray_bg" id="menu">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="section_tittle">
                        <p>Popular Menu</p>
                        <h2>Delicious Food Menu</h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="nav nav-tabs food_menu_nav" id="myTab" role="tablist">
                        @foreach ($menu as $key => $item)
                            <a class="{{ $key == 0 ? 'active' : '' }}" id="{{ str_replace(' ', '_', $item->nama_kategori) }}-tab" data-toggle="tab" href="#{{ str_replace(' ', '_', $item->nama_kategori) }}" role="tab"
                                aria-controls="{{ str_replace(' ', '_', $item->nama_kategori) }}" aria-selected="false">{{ $item->nama_kategori }} <img src="{{asset('img/icon/play.svg')}}"
                                    alt="play"></a>
                        @endforeach
                        {{-- <a id="Breakfast-tab" data-toggle="tab" href="#Breakfast" role="tab" aria-controls="Breakfast"
                            aria-selected="false">Breakfast <img src="{{asset('img/icon/play.svg')}}" alt="play"></a>
                        <a id="Launch-tab" data-toggle="tab" href="#Launch" role="tab" aria-controls="Launch"
                            aria-selected="false">Launch <img src="{{asset('img/icon/play.svg')}}" alt="play"></a>
                        <a id="Dinner-tab" data-toggle="tab" href="#Dinner" role="tab" aria-controls="Dinner"
                            aria-selected="false">Dinner <img src="{{asset('img/icon/play.svg')}}" alt="play"> </a>
                        <a id="Sneaks-tab" data-toggle="tab" href="#Sneaks" role="tab" aria-controls="Sneaks"
                            aria-selected="false">Sneaks <img src="{{asset('img/icon/play.svg')}}" alt="play"></a> --}}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="tab-content" id="myTabContent">
                        @foreach ($menu as $key => $item)
                            <div class="tab-pane fade {{ $key == 0 ? "show active single-member" : "" }}" id="{{ str_replace(' ', '_', $item->nama_kategori) }}" role="tabpanel"
                                aria-labelledby="{{ str_replace(' ', '_', $item->nama_kategori) }}-tab">
                                <div class="row">
                                    @foreach ($item->menu as $key2 => $item2)
                                    <div class="col-sm-6 col-lg-6">
                                        <div class="single_food_item media">
                                            <img src="{{ Storage::url('menu/' . $item2->img) }}" style="height: 140px; max-width: 160px; object-fit: cover;" class="mr-3" alt="...">
                                            <div class="media-body align-self-center">
                                                <h3>{{ $item2->nama_menu }}</h3>
                                                <p>{{ $item2->deskripsi }}</p>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5>Rp. {{ number_format($item2->harga, 2, ",", ".") }}</h5>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-danger mr-3" data-toggle="modal" data-target="#exampleModal{{ $key . $key2 }}">
                                                        Masukan ke Keranjang
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if ($item->menu->isEmpty())
                                        <h3 class="mx-auto">Menu {{ $item->nama_kategori }} belum tersedia</h3>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @foreach ($menu as $key => $item)
            @foreach ($item->menu as $key2 => $item2)
            <div class="modal fade" id="exampleModal{{ $key . $key2 }}" tabindex="-1" role="dialog" aria-labelledby="exampleModal{{ $key . $key2 }}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModal{{ $key . $key2 }}Label">Masukan Keranjang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('store-keranjang', ['menu_id' => $item2->id]) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="number" class="form-control" name="quantity" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Simpan ke keranjang</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            @endforeach
        @endforeach
    </section>
@endif
<!-- food_menu part end-->
@endsection
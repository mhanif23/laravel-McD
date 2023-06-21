<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Keranjang;
use App\Models\DetailPesanan;

class AdminController extends Controller
{
    public function index () {
        $data = Pesanan::selectRaw("
                COALESCE(SUM(pesanan.total_harga)) as total_pemasukan,
                COALESCE(SUM(CASE WHEN EXTRACT(MONTH FROM pesanan.created_at) = ". date("m") ." THEN pesanan.total_harga END)) as total_perbulan
        ")->first();

        $keranjang = Keranjang::selectRaw("
                COUNT(CASE WHEN status = 'PENDING' THEN id END) as total_pending,
                COUNT(CASE WHEN status = 'DONE' THEN id END) as total_done,
                COUNT(id) as total
        ")->first();
        
        return view('admin.index', compact("data", "keranjang"));
    }

    public function ajax (Request $request) {
        $data = Pesanan::selectRaw("pesanan.*, nomor_meja")
                ->join("meja", "meja.id", "meja_id")
                ->latest()
                ->get();
        
        return datatables()->of($data)
            ->editColumn("total_harga", function($data) {
                return 'Rp. '. number_format($data->total_harga, 2, ",", ".");
            })
            ->addColumn("detail_pesanan", function($data) {
                $data = DetailPesanan::selectRaw("keranjang.total_harga, nama_menu, quantity")
                            ->join("pesanan", "pesanan.id", "detail_pesanan.pesanan_id")
                            ->join("keranjang", "keranjang.id", "keranjang_id")
                            ->join("menu", "menu.id", "keranjang.menu_id")
                            ->join("users", "users.id", "keranjang.user_id")
                            ->where("pesanan_id", $data->id)
                            ->get();
                return $data;
            })
            ->addIndexColumn()
            ->toJson();
    }
}

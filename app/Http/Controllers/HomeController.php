<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Meja;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menu = KategoriMenu::with(["menu"])->get();

        return view('welcome', compact("menu"));
    }

    public function keranjang()
    {
        $keranjang = Keranjang::selectRaw("keranjang.id, total_harga, quantity, name as pemesan, nama_menu, deskripsi, img, total_harga, harga")
                            ->join("users", "users.id", "user_id")
                            ->join("menu", "menu.id", "menu_id")
                            ->where("users.id", Auth::user()->id)
                            ->where("status", "PENDING")
                            ->get();

        return view('keranjang', compact("keranjang"));
    }

    public function storeKeranjang (Request $request, $menu_id) {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
            return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
        }

        $menu = Menu::find($menu_id);
        if($menu) {
            if($menu->stok < $request->quantity) {
                return redirect()->back()->with('error', 'Stok menu kurang dari pesanan anda!');
            }

            $input = new Keranjang;
            $input->quantity = $request->quantity;
            $input->user_id = Auth::user()->id;
            $input->menu_id = $menu_id;
            $input->total_harga = $request->quantity * $menu->harga;

        } else {
            return redirect()->back()->with('error', 'Tidak ada menu yang anda pilih!');
        }

        if($input->save()){
            return redirect()->route('guest.keranjang')->with('success', 'Berhasil masukan menu ke keranjang');
        }else{
            return redirect()->route('guest.keranjang')->with('error', 'Gagal masukan menu ke keranjang');
        }
    }

    public function hapusKeranjang($id){
        $data = Keranjang::find($id);

        if($data->delete()){
            return response()->json(['status' => 'success','message'=>'Item keranjang berhasil dihapus.']);
        }else{
            return response()->json(['status'=>'error', 'message' => 'Item keranjang gagal dihapus']);
        }
    }

    public function simpanPesanan (Request $request) {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'keranjang_id.*' => 'required',
            ]);
    
            if ($validator->fails()) {
                $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
            }
    
            $meja = Meja::where("is_available", true)->first();
            if(!$meja) {
                return redirect()->route('guest.keranjang')->with('error', 'Tidak ada meja yang tersedia');
            }
            $meja->is_available = false;
            $meja->save();
            
            $pesanan = new Pesanan;
            $pesanan->meja_id = $meja->id;
            $pesanan->total_harga = 0;
            $pesanan->save();
    
            foreach ($request->keranjang_id as $key => $value) {
                $keranjang = Keranjang::selectRaw("keranjang.*, menu.harga, menu.stok")
                                    ->join("menu", "menu.id", "menu_id")
                                    ->where("keranjang.id", $request->keranjang_id[$key])
                                    ->first();
    
                $total_keseluruhan = 0;
                if($keranjang) {
                    if($keranjang->stok < $keranjang->quantity) {
                        return redirect()->back()->with('error', 'Stok menu kurang dari pesanan anda!');
                    }

                    $keranjang->status = "DONE";
                    $keranjang->save();
        
                    $detail = new DetailPesanan;
                    $detail->keranjang_id = $request->keranjang_id[$key];
                    $detail->pesanan_id = $pesanan->id;
                    $detail->save();

                    $menu = Menu::find($keranjang->menu_id);
                    $menu->stok = $menu->stok - $keranjang->quantity;
                    $menu->save();
                    
                    $total_keseluruhan += $keranjang->harga * $keranjang->quantity;
                } else {
                    return redirect()->back()->with('error', 'Tidak ada menu yang anda pilih!');
                }
    
                $pesanan->total_harga = $total_keseluruhan;
            }
    
            if($pesanan->save()){
                DB::commit();
                return redirect()->route('guest.keranjang')->with('success', 'Pesanan Berhasil Dipesan');
            }else{
                DB::rollback();
                return redirect()->route('guest.keranjang')->with('error', 'Pesanan gagal dipesan');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

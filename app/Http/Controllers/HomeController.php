<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
        return view('keranjang');
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
}

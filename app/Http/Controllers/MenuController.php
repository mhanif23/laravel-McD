<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index(){
        return view('admin.menu');
    }

    public function ajax(){
        // run query
        $data = Menu::latest()->get();
        
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($row){
                $btn =
                    '<div class="d-flex justify-content-between">
                        <div class="col-sm-6">
                            <button class="btn btn-sm btn-success" onclick="editModal('.$row->id.');"><i class="fas fa-edit"></i></button>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-sm ms-2 btn-danger btn-delete" onclick="destroy('.$row->id.');"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>';

                return $btn;
            })->rawColumns(['aksi'])->toJson();
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required|integer',
            'img'   => 'required|image|max:2048'
        ]);

        if ($validator->fails()) {
            $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
            return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
        }

        $input = new Menu;
        $input->nama_menu = $request->nama_menu;
        $input->deskripsi = $request->deskripsi;
        $input->harga = $request->harga;
        $input->stok = $request->stok;

        if($request->hasFile('img')){
            $file =  $request->file('img');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('menu/', $filename, 'public');
            $input->img = $filename;
        }

        if($input->save()){
            return redirect()->route('admin.menu')->with('success', 'Data berhasil disimpan');
        }else{
            return redirect()->route('admin.menu')->with('error', 'Data gagal disimpan');
        }
    }

    public function edit(Request $request, $id){
        $selectedItem = Menu::find($id);

        return response()->json($selectedItem);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'img'   => 'image|max:2048'
        ]);

        if ($validator->fails()) {
            $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
            return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
        }

        $input = Menu::find($id);
        $input->nama_menu = $request->nama_menu;
        $input->deskripsi = $request->deskripsi;
        $input->harga = $request->harga;
        $input->stok = $request->stok;

        $oldImage = "menu/".$input['img'];
        if($request->hasFile('img')){
            $file =  $request->file('img');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('menu', $filename, 'public');
            $input->img = $filename;
            Storage::disk('public')->delete($oldImage);
        }

        if($input->save()){
            return redirect()->route('admin.menu')->with('success', 'Data berhasil diperbaharui');
        }else{
            return redirect()->route('admin.menu')->with('error', 'Data gagal diperbaharui');
        }
    }

    public function destroy($id){
        $data = Menu::find($id);
        $img = "menu/" . $data->img;

        if($data->delete()){
            Storage::disk('public')->delete($img);
            return response()->json(['status' => 'success','message'=>'Data berhasil dihapus.']);
        }else{
            return response()->json(['status'=>'error', 'message' => 'Data gagal dihapus']);
        }
    }
}

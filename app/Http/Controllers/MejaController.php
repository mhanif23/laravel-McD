<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class MejaController extends Controller
{
    public function index(){
        return view('admin.meja');
    }

    public function ajax(){
        // run query
        $data = Meja::latest()->get();
        
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
            'nomor_meja' => 'required',
        ]);

        if ($validator->fails()) {
            $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
            return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
        }

        $input = new Meja;
        $input->nomor_meja = $request->nomor_meja;
        $input->is_available = true;

        if($input->save()){
            return redirect()->route('admin.meja')->with('success', 'Data berhasil disimpan');
        }else{
            return redirect()->route('admin.meja')->with('error', 'Data gagal disimpan');
        }
    }

    public function edit(Request $request, $id){
        $selectedItem = Meja::find($id);

        return response()->json($selectedItem);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nomor_meja' => 'required',
        ]);

        if ($validator->fails()) {
            $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
            return redirect()->back()->withErrors($fieldsWithErrorMessagesArray)->withInput();
        }

        $input = Meja::find($id);
        $input->nomor_meja = $request->nomor_meja;
        $input->is_available = true;

        if($input->save()){
            return redirect()->route('admin.meja')->with('success', 'Data berhasil diperbaharui');
        }else{
            return redirect()->route('admin.meja')->with('error', 'Data gagal diperbaharui');
        }
    }

    public function destroy($id){
        $data = Meja::find($id);

        if($data->delete()){
            return response()->json(['status' => 'success','message'=>'Data berhasil dihapus.']);
        }else{
            return response()->json(['status'=>'error', 'message' => 'Data gagal dihapus']);
        }
    }
}

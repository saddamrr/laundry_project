<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisCuci;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class jeniscontroller extends Controller
{
    public function store(Request $req){
        if (Auth::user()->level=='petugas') {
            $validator=Validator::make($req->all(),[
                'nama_jenis' => 'required',
                'harga_per_kilo' => 'required',
            ]);
            if($validator->fails()){
                return response()->json($validator->errors());
            }
    
            $simpan=JenisCuci::create([
                'nama_jenis' => $req->nama_jenis,
                'harga_per_kilo' => $req->harga_per_kilo,
            ]);
            if($simpan){
                $data['status']="Berhasil";
                $data['message']="Data berhasil disimpan!";
                return Response()->json($data);
            }else{
                $data['status']="Gagal";
                $data['message']="Data gagal disimpan!";
                return Response()->json($data);
            }
        } else {
            $data['status']="Gagal";
            $data['Message']="Anda bukan Petugas!";
            return Response()->json($data);
        }
    }

    public function update($id, Request $req){
        if (Auth::user()->level=='admin') {
            $validator=Validator::make($req->all(),[
                'nama_jenis' => 'required',
                'harga_per_kilo' => 'required'
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors());
            }
            $ubah=JenisCuci::where('id', $id)->update([
                'nama_jenis' => $req->nama_jenis,
                'harga_per_kilo' => $req->harga_per_kilo,
            ]);
            if($ubah){
                $data['status']="Berhasil";
                $data['message']="Data berhasil diubah!";
                return Response()->json($data);
            }else{
                $data['status']="Gagal";
                $data['message']="Data gagal diubah!";
                return Response()->json($data);
            }
        } else {
            $data['status']="Gagal";
            $data['Message']="Anda bukan Admin!";
            return Response()->json($data);
        }
    }

    public function destroy($id){
        if (Auth::user()->level=='admin') {
            $hapus=JenisCuci::where('id', $id)->delete();
            if($hapus){
                $data['status']="Berhasil";
                $data['message']="Data berhasil dihapus!";
                return Response()->json($data);
            }else{
                $data['status']="Gagal";
                $data['message']="Data gagal dihapus!";
                return Response()->json($data);
            }
        }  else {
            $data['status']="Gagal";
            $data['Message']="Anda bukan Admin!";
            return Response()->json($data);
        }
    }

    public function show(){
        if (Auth::user()->level=='admin') {
            $data_cuci=JenisCuci::get();
            $data['Jenis Cucian']=$data_cuci;
            return response()->json($data);
        } else {
            $data['status']="Gagal";
            $data['Message']="Anda bukan Admin!";
            return Response()->json($data);
        }
    } 
}

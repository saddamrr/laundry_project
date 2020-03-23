<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class pelanggancontroller extends Controller
{
    public function store(Request $req){
        if(Auth::user()->level=='petugas') {
            $validator=Validator::make($req->all(),[
                'nama' => 'required',
                'alamat' => 'required',
                'no_telp' => 'required',
              ]);
              if($validator->fails()){
                return Response()->json($validator->errors());
              }
        
              $simpan=Pelanggan::create([
                  'nama' => $req->nama,
                  'alamat' => $req->alamat,
                  'no_telp' => $req->no_telp,
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
  
    public function update($id,Request $req)
    {
        if (Auth::user()->level=='admin') {
            $validator=Validator::make($req->all(),
            [
              'nama' => 'required',
              'alamat' => 'required',
              'no_telp' => 'required',
            ]);
    
            if($validator->fails()){
                return Response()->json($validator->errors());
            }
            $ubah=Pelanggan::where('id', $id)->update([
                'nama' => $req->nama,
                'alamat' => $req->alamat,
                'no_telp' => $req->no_telp,
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
            $hapus=Pelanggan::where('id',$id)->delete();
            if($hapus){
                $data['status']="Berhasil";
                $data['message']="Data berhasil dihapus!";
                return Response()->json($data);
            }else{
                $data['status']="Gagal";
                $data['message']="Data gagal dihapus!";
                return Response()->json($data);
            }
        } else {
            $data['status']="Gagal";
            $data['Message']="Anda bukan Admin!";
            return Response()->json($data);
        }
    }
      public function show(){
        if(Auth::user()->level=='admin'){
            $data_pelanggan=Pelanggan::get();
            $arr_data=array();
            foreach($data_pelanggan as $dp) {
                $arr_data = array(
                    'nama' => $dp->nama,
                    'alamat' => $dp->alamat, 
                    'no_telp'=> $dp->no_telp,
                );
            }
            $data['Pelanggan']=$arr_data;
            return Response()->json($data_pelanggan);
        } else {
            $data['status']="Gagal";
            $data="Anda bukan Admin!";
            return Response()->json($data);
        }
      }
}

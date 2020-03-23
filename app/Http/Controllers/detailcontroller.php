<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\JenisCuci;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class detailcontroller extends Controller
{
    public function store(Request $req){
        if (Auth::user()->level=='petugas') {
            $validator=Validator::make($req->all(),[
                'id_transaksi' => 'required',
                'id_jenis' => 'required',
                'qty' => 'required',
              ]);
              if($validator->fails()){
                return Response()->json($validator->errors());
              }

              $harga = JenisCuci::where('id', $req->id_jenis)->first();
              $subtotal = $harga->harga_per_kilo * $req->qty;
        
              $simpan=Detail::create([
                  'id_transaksi' => $req->id_transaksi,
                  'id_jenis' => $req->id_jenis,
                  'qty' => $req->qty,
                  'subtotal' => $subtotal,
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
}

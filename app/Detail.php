<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table='detail_transaksi';
    protected $primaryKey='id';
    protected $fillable=[
        'id_transaksi', 'id_jenis', 'subtotal', 'qty'
    ];
    public $timestamps = false;
}

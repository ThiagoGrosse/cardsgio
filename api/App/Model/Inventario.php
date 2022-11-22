<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = "inventario";
    protected $fillable = ["id_produto", "saldo"];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $casts = [
        'created_at'=>'datetime:Y-m-d H:i:s',
        'updated_at'=>'datetime:Y-m-d H:i:s'
    ];
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Precos extends Model
{
    protected $table = "precos";
    protected $fillable = ["id_produto", "preco"];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}

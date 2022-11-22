<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Imagens extends Model
{
    protected $table = "imagens";
    protected $fillable = ["id_produto", "img_01", "img_02", "img_03", "img_04", "img_05", "img_06"];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}

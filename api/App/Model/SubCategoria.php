<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    protected $table = "subcategoria";
    protected $fillable = ["subcategoria", "id_categoria_principal", "id_sub","status"];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}

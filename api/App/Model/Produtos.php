<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $table = "produtos";
    protected $primaryKey = 'id';
    protected $fillable = ["titulo", "descricao", "categoria", "status", "qt_vendida", "destaque", "destaque_2", "created_at", "updated_at", "deleted_at"];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $casts = [
        'deleted_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}

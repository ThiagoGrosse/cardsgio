<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItensPedidos extends Model
{
    protected $table = "itens_pedidos";
    protected $fillable = ["id_pedido", "id_produto", "qt_produto" , "valor_unitario", "valor_total"];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = "pedidos";
    protected $fillable = ["nome_cliente", "email_cliente", "telefone_cliente", "valor_pedido", "status"];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
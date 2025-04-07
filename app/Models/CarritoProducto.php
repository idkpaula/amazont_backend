<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoProducto extends Model
{
    protected $fillable = ['carrito_id', 'producto', 'cantidad'];

    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'carrito_id');
    }
}


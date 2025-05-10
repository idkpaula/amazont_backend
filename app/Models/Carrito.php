<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $primaryKey = 'id_carro';
    protected $fillable = ['user_id', 'estado'];

    public function productos()
    {
        return $this->hasMany(CarritoProducto::class, 'carrito_id');
    }
}
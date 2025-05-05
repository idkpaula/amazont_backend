<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id_prod';

    protected $fillable = [
        'vendedor_id', 'nombre', 'descripcion',
        'precio', 'imagen', 'oferta'
    ];
}

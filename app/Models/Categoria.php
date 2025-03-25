<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Especificar la clave primaria en la tabla 'categorias'
    protected $primaryKey = 'id_cat';

    // Definir los campos que se pueden llenar masivamente
    protected $fillable = ['nombre', 'descripcion', 'imagen'];

    // Relación con el modelo Producto
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id', 'id_cat');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoraciones';
    protected $primaryKey = 'id_valoracion';
    protected $fillable = ['producto_id', 'usuario_id', 'puntuacion'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id_prod');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }
}

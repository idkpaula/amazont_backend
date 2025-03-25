<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    use HasFactory;

    protected $table = 'opiniones';
    protected $primaryKey = 'id_opinion';
    protected $fillable = ['producto_id', 'usuario_id', 'comentario'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id_prod');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }
}

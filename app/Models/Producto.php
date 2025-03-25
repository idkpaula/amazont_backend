<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos'; // Nombre correcto de la tabla
    protected $primaryKey = 'id_prod'; // Definir la clave primaria correcta
    public $timestamps = true; // Habilitar timestamps

    protected $fillable = ['nombre', 'descripcion', 'precio', 'en_oferta', 'categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_cat');
    }
}

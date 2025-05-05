<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'user_id', 'tipo', 'nombre', 'num_tarjeta',
        'fecha_caducidad', 'codigo_validacion',
    ];

    protected $hidden = ['num_tarjeta', 'codigo_validacion'];

    public function setNumTarjetaAttribute($value)
    {
        $this->attributes['num_tarjeta'] = encrypt($value);
    }

    public function getNumTarjetaAttribute($value)
    {
        return decrypt($value);
    }

    public function setCodigoValidacionAttribute($value)
    {
        $this->attributes['codigo_validacion'] = encrypt($value);
    }

    public function getCodigoValidacionAttribute($value)
    {
        return decrypt($value);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleado';

    protected $primaryKey = 'fkpk_id_empleado';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'fkpk_id_empleado'
    ];

    public function usuario()
    {
        return $this->belongsTo(
            Usuario::class,
            'fkpk_id_empleado',
            'id_usuario'
        );
    }
}
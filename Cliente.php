<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';

    protected $primaryKey = 'fkpk_id_cliente';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'fkpk_id_cliente'
    ];

    public function usuario()
    {
        return $this->belongsTo(
            Usuario::class,
            'fkpk_id_cliente',
            'id_usuario'
        );
    }
}
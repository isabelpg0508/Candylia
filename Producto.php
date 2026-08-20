<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table='productos';

    protected $primaryKey='id_producto';

    public $timestamps=false;

    public $incrementing=false;

    protected $keyType='int';

    protected $fillable=[
        'id_producto',
        'id_categoria',
        'nombre',
        'descripcion',
        'precio',
        'estado'
    ];

    public function categoria()
    {
        return $this->belongsTo(
            Categoria::class,
            'id_categoria',
            'id_categoria'
        );
    }
    
    public function tallas()
    {
        return $this->belongsToMany(
            Talla::class,
            'producto_talla',
            'id_producto',
            'id_talla'
        );
    }

    public function colores()
    {
        return $this->belongsToMany(
            Color::class,
            'producto_color',
            'id_producto',
            'id_color'
        );
    }

    public function imagenes()
    {
        return $this->hasMany(
            ImagenProducto::class,
            'id_producto',
            'id_producto'
        );
    }

    public function inventario()
    {
        return $this->hasOne(
            Inventario::class,
            'id_producto',
            'id_producto'
        );
    }
}
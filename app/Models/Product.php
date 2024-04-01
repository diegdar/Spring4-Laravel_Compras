<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
🗒️NOTES:
1: $guarded actúa de forma similar a $fillable, pero en lugar de indicar los campos que se deben permitir guardar, indicamos el campo que se debe proteger y por tanto no se debe guardar si se recibe a través del formulario.
      ⚠️Si no tenemos un campo que proteger y aun así queremos usar asignación masiva, debemos dejar el array vacío.
2: El nombre de la función está en plural porque estamos haciendo referencia a muchas partes (compras)

3: Aquí establecemos la relación: $this(Product) pertenece a una o muchas compras.*/

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

        // public $timestamps = false;

    protected $guarded = [];//note 1
    protected $dates = ['deleted_at'];


    public function purchases():BelongsToMany //note 2
    {
        return $this->belongsToMany(Purchase::class, 'product_purchase');//note 3
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
/*
🗒️NOTAS:
1: $guarded actúa de forma similar a $fillable, pero en lugar de indicar los campos que se deben permitir guardar, indicamos el campo que se debe proteger y por tanto no se debe guardar si se recibe a través del formulario.
      ⚠️Si no tenemos un campo que proteger y aun así queremos usar asignación masiva, debemos dejar el array vacío.
2: El nombre de la función está en plural porque hacemos referencia a muchas partes (Productos)
3: Aquí establecemos la relación: $this(Purchase) tiene muchos productos (aquí tenemos que poner el nombre de la Clase en singular).
*/
class Purchase extends Model
{
    use HasFactory;

    // public $timestamps = false;

    protected $guarded = [];//note 1

    public function products():BelongsToMany //note 2
    {
        return $this->belongsToMany(Product::class, 'product_purchase');//note 3
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*
🗒️NOTES:
1: $guarded actúa de forma similar a $fillable, pero en lugar de indicar los campos que se deben permitir guardar, indicamos el campo que se debe proteger y por tanto no se debe guardar si se recibe a través del formulario.
      ⚠️Si no tenemos un campo que proteger y aun así queremos usar asignación masiva, debemos dejar el array vacío.

*/
class ProductPurchase extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];//note 1

}

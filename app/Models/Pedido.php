<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
    {
        //Belongstomany establece una relacion de muchos a muchos
        //Tenemos que indicar cual es la tabla pivote, para que busque el id de este pedido y se traiga los productos
        //Agregamos withPivot y la columna que deseamos añadir para que se agregue esa columna y tengamos acceso a la cantidad
        return $this->belongsToMany(Producto::class, 'pedido_productos')->withPivot('cantidad');
    }
}

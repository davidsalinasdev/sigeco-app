<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Etapasproc extends Model
{
    use HasFactory;

    //relación uno a muchos inversa
    public function modalidadess()
    {
        return $this->belongsTo(Modalidades::class);
    }

}

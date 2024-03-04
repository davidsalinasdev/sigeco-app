<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidades extends Model
{
    use HasFactory;
    
    //relación uno a muchos
    public function etapasprocs()
    {
        return $this->hasMany(Etapasproc::class);
    }
}

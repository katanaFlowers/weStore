<?php

namespace App\Entify;

use Illuminate\Database\Eloquent\Model;

class TempPhoneClass extends Model
{
     protected $table = "temp_phone";
     protected $primaryKey = "id";
     public $timestamps = false;
}

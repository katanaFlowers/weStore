<?php

namespace App\Entify;

use Illuminate\Database\Eloquent\Model;

class TempEmailClass extends Model
{
     protected $table = "temp_email";
     protected $primaryKey = "id";
     public $timestamps = false;
}

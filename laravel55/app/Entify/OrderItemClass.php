<?php

namespace App\Entify;

use Illuminate\Database\Eloquent\Model;

class OrderItemClass extends Model
{
     protected $table = "order_item";
     protected $primaryKey = "id";
     public $timestamps = false;
}

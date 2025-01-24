<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    //
    protected $fillables = ['name','area','ip','manage','model','view','addedBy'];
}

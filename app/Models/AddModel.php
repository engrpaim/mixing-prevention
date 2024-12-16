<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddModel extends Model
{
    use HasFactory;
    protected $fillable = ['model','before','after','finish','process_flow'];
}

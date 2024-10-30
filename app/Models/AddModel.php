<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddModel extends Model
{
    use HasFactory;

    protected $fillable = ['model_name', 'width','ip_address' , 'max_tolerance_width', 'min_tolerance_width', 'length', 'max_tolerance_length', 'min_tolerance_length', 'thickness', 'max_tolerance_thickness', 'min_tolerance_thickness',];

}

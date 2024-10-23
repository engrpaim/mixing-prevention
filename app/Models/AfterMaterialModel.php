<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AfterMaterialModel extends Model
{
    use HasFactory;
    protected $table = 'after_material_models';
    protected $fillable = ['after_material'];
}

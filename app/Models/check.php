<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class check extends Model
{
    use HasFactory;
    protected $table = 'tbl_check_list';
    protected $fillable = ['name', 'check'];
}

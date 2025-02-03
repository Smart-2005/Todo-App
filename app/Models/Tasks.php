<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable=[
        'task_name',
        'task_description',
        'task_img',
        'task_priority'
    ];
}

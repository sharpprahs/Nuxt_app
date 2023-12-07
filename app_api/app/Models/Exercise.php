<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable = ['id_lang_task', 'id_lang_answer','id_section','name','number_task','type','content_name','description','true_answer','true_keywords'];
}

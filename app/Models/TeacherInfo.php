<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_account_no',
        'nid',
        'nid_img',
        'institute',
        'curriculum',
        'teaching_level',
    ];

}
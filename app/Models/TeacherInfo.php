<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherInfo extends Model {
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'bank_account_no',
        'nid',
        'nid_img',
        'institute',
        'curriculum',
        'teaching_level',
        'business_institute_name',
        'username',
    ];

}
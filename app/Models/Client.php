<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{

    protected $fillable = ['uuid','first_name','last_name','id_number','dob','telephone','email_address','status'];


    use HasFactory;
    use SoftDeletes;
}

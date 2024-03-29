<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['balance'];
}

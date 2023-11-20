<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tag extends Model {

    public $timestamps  = false;
    public $table = 'tag';
    public $primaryKey = 'name';
    protected $fillable = [
        'name',
    ];
}
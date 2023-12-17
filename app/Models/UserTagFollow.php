<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTagFollow extends Model {

    public $timestamps  = false;
    public $table = 'user_follow_tag';

    protected $fillable = [
        'id_user',
        'id_tag ',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function tag() {
        return $this->belongsTo('App\Models\Tag');
    }
}
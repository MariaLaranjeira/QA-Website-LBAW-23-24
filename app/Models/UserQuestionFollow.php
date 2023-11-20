<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserQuestionFollow extends Model {

    public $timestamps  = false;
    public $table = 'user_follow_question';
    public $primaryKey = ['id_user', 'id_question'];

    protected $fillable = [
        'id_user',
        'id_question',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function question() {
        return $this->belongsTo('App\Models\Question');
    }
}
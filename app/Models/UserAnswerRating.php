<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserAnswerRating extends Model {

    public $timestamps  = false;
    public $table = 'user_rating_answer';
    
    protected $fillable = [
        'id_user',
        'id_answer',
        'rating',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function answer() {
        return $this->belongsTo('App\Models\Answer');
    }
}
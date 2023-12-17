<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserQuestionRating extends Model {

    public $timestamps = false;
    public $table = 'user_rating_question';

    protected $fillable = [
        'id_user',
        'id_question',
        'rating',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function question() {
        return $this->belongsTo('App\Models\Question');
    }

}
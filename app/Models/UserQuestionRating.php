<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserQuestionRating extends Model {

    use HasCompositePrimaryKey;

    public $timestamps = false;
    public $table = 'user_rating_question';
    public $primaryKey = ['id_user', 'id_question'];
    public $incrementing = false;

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
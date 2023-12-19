<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Answer extends Model {

    public $timestamps  = false;
    public $table = 'answer';
    public $primaryKey = 'answer_id';
    protected $fillable = [
        'answer_id',
        'text_body',
        'rating',
        'media_address',
        'creation_date',
        'id_user',
        'id_question',
    ];

    public function owner() {
        return $this->belongsTo('App\Models\User');
    }

    public function root() {
        return $this->belongsTo('App\Models\Question');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_answer', 'answer_id')
            ->orderBy('creation_date', 'desc');
    }
}
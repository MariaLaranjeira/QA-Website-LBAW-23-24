<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Question extends Model {

    public $timestamps  = false;
    public $table = 'question';
    public $primaryKey = 'question_id';
    protected $fillable = [
        'question_id',
        'title',
        'text_body',
        'media_address',
        'creation_date',
        'rating',
        'id_user',
    ];

    public function owner() {
        return $this->belongsTo('App\Models\User');
    }

    public function tag(){
        return $this->hasMany('App\Models\Tag')->get();
    }
}
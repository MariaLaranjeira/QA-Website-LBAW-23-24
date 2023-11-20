<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model {

    public $timestamps  = false;
    public $table = 'comment';
    public $primaryKey = 'comment_id';
    protected $fillable = [
        'comment_id',
        'text_body',
        'creation_date',
        'id_user',
        'id_question',
        'id_answer',
        'comment_type',
    ];

    public function owner() {
        return $this->belongsTo('App\Models\User');
    }

    public function root() {
        return $this->belongsTo('App\Models\Answer');
    }
}
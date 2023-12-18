<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Tag extends Model {

    public $timestamps  = false;
    public $incrementing = false;
    public $table = 'tag';
    public $primaryKey = 'name';
    protected $fillable = [
        'name',
    ];

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'question_tag', 'id_tag', 'id_question');
    }
}
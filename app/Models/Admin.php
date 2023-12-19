<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class   Admin extends Model {

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    public $table = 'admin';
    public  $primaryKey = 'admin_id';
    public $incrementing = false;

}

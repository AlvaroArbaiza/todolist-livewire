<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ToDo extends Model
{
    use HasFactory;

    protected $table = 'to_dos';

    protected $fillable = [
        'user_id',
        'name',
        'completed'
    ];

    //collegamento many to one con tabella Users
    public function user(){
        return $this->belongsTo(User::class);
    }
}

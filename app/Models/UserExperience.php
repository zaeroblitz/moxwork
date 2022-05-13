<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserExperience extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'user_experiences';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'user_details_id',
        'experience',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user_detail()
    {
        return $this->belongsTo(UserDetail::class, 'user_details_id', 'id');
    }
}
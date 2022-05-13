<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'services';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'users_id',
        'title',
        'description',
        'delivery_time',
        'revision_limit',
        'price',
        'note',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function user_advantage()
    {
        return $this->hasMany(UserAdvantage::class, 'services_id');
    }

    public function service_advantage()
    {
        return $this->hasMany(ServiceAdvantage::class, 'services_id');
    }

    public function service_thumbnail()
    {
        return $this->hasMany(ServiceThumbnail::class, 'services_id');
    }

    public function tagline()
    {
        return $this->hasMany(Tagline::class, 'services_id');
    }

     public function order()
    {
        return $this->hasMany(Order::class, 'services_id');
    }
}
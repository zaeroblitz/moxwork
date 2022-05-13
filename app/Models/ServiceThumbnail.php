<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceThumbnail extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'service_thumbnails';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'services_id',
        'thumbnail',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'services_id', 'id');
    }
}
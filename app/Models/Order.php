<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'services_id',
        'freelancer_id',
        'buyer_id',
        'file',
        'note',
        'expired',
        'order_status_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'services_id', 'id');
    }

    public function user_freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id', 'id');
    }

    public function user_buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }
}
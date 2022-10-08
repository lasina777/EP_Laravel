<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Автоматический массив артрибутов
     *
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * Связь с таблицей orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    /**
     * связь с таблицей users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}

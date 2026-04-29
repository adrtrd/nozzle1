<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link_type',
        'link_id',
        'link_url',
        'link',
        'is_active',
        'order_index',
        'sort_order',
    ];
}


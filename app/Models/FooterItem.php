<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterItem extends Model
{
    protected $fillable = [
        'section',
        'title',
        'type',
        'url',
        'file_path',
        'sort_order',
        'is_active',
        'open_new_tab',
    ];
}

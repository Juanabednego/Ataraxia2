<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = [
        'type', 'reference_id', 'title', 'message', 'is_read'
    ];

    public function getLinkAttribute()
    {
        return route('admin.notifications.show', [$this->type, $this->reference_id]);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i',
        'due_date' => 'datetime:d-m-Y H:i',
        'complete' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

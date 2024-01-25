<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'due_date',
        'category_id',
        'content',
        'completed'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}

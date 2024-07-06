<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'year',
        'term',
        'deadline',
        'gitHub_url',
        'documentation',
        'description',
        'user_id'
    ];

    public function user() {
        return $this->BelongsTo(User::class);
    }
}

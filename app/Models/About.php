<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'phone',
        'email',
        'linkedin',
        'website',
        'address',
        'summary',
        'soft_skills',
        'hard_skills',
        'content' // Saya biarkan 'content' ini karena mungkin dipakai di halaman About publik
    ];
}
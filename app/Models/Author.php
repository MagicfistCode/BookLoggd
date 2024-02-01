<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $primaryKey = 'author_id';

    protected $fillable = [
        'author_name',
        'author_desc',
        'author_dob',
        'author_death',
        'author_nationality',
        'author_photo'

    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }
}

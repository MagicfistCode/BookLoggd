<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $primaryKey = 'book_id';

    protected $fillable=[
        'book_title',
        'book_desc',
        'book_cover',
        'book_date',
        'author_id',
        'book_genre',
        'page_num'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function readingList()
    {
        return $this->hasMany(ReadingList::class, 'book_id');
    }
}

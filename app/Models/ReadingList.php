<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingList extends Model
{
    use HasFactory;
    protected $primaryKey = 'list_id';

    protected $fillable = [
        'user_id',
        'book_id',
        'reading_status',
        'reading_page_num',
        'rating',
        'reading_note'

    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function isValidStatus($status)
    {
        return in_array($status, [
            self::READING,
            self::COMPLETED,
            self::DROPPED,
            self::PLANNING_TO_READ,
        ]);
    }

}


class ReadingStatus
{
    const READING = 'Reading';
    const COMPLETED = 'Completed';
    const DROPPED = 'Dropped';
    const PLANNING_TO_READ = 'Planning to Read';
        
}


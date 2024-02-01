<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    protected $primaryKey = 'badge_id';

    protected $fillable=[
        'badge_name',
        'badge_image',
        'badge_desc',
        'badge_book_req',
        'badge_page_num_req',
        'badge_genre_requirement',
    ];

}

?>
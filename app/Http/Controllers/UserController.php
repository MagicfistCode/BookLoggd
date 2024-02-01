<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ReadingList;
use App\Models\Badge;
use App\Models\Book;
use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
{
    $totalBooks = ReadingList::where('id', $user->id)->count();
    $badges = Badge::all();

    $posts = Post::with('user')
                ->where('id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
    
    return view('users.profile', compact('user', 'totalBooks', 'badges', 'posts'));
}

}



?>
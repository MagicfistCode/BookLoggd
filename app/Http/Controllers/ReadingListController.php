<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReadingList;
use App\Models\Book;
use App\Models\User;

class ReadingListController extends Controller
{
    //Adding new entry to reading list function
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'reading_status' => 'required',
            'rating' => ($request->input('reading_status') === 'Planning to Read') ? 'nullable' : 'nullable|numeric|between:0.1,10',
            'reading_page_num' => ($request->input('reading_status') === 'Planning to Read') ? 'nullable' : 'required|numeric|min:1',
            'reading_note' => 'nullable|string|max:255',
        ]);
    
        if ($validatedData['reading_status'] === 'Planning to Read') {
            $validatedData['rating'] = null;
            $validatedData['reading_page_num'] = null;
            $validatedData['reading_note'] = null;
        } elseif ($validatedData['reading_status'] === 'Completed') {
            // Fetch book's total page numbers and set it to reading_page_num
            $book = Book::findOrFail($request->input('book_id'));
            $validatedData['reading_page_num'] = $book->page_num;
        }
    
        $existingEntry = ReadingList::where('id', auth()->id())
            ->where('book_id', $request->input('book_id'))
            ->first();
    
        if ($existingEntry) {
            $existingEntry->update($validatedData);
            return back()->with('success', 'Book updated in your reading list!');
        }
    
        $readingList = new ReadingList();
        $readingList->id = auth()->id();
        $readingList->book_id = $request->input('book_id');
        $readingList->fill($validatedData);
        $readingList->save();
    
        return back()->with('success', 'Book added to your reading list!');
    }
    


    //Displaying reading list for current user
    public function index()
        {
            $user = auth()->user();
            $readingList = $user->readingList()->get();

            return view('books.readinglist', compact('readingList'));
        }

    //Displaying reading list for other users
    public function show(User $user)
        {
            $readingList = $user->readingList()->get();
            return view('users.readinglist', compact('readingList', 'user'));
        }


    //Deleting an entry from the reading list
    public function destroy($list_id)
        {
            $entry = ReadingList::findOrFail($list_id);

            
            if ($entry->id === auth()->id()) {
                $entry->delete();
                return redirect()->route('book.readinglist')->with('success', 'Reading list entry deleted successfully!');
            }

            return redirect()->route('book.readinglist')->with('error', 'Unauthorized to delete this entry!');
        }

}

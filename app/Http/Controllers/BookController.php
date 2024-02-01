<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    //Displaying books function for Admin
    public function index(){
        $books = Book::all();
        return view('books.index', ['books' => $books]);
    }

    //Displaying create books function
    public function create(){
        return view('books.create');
    }

    //Adding book to database function
    public function store(Request $request){
        try{

        
            $data = $request->validate([
                'book_title' => 'required',
                'book_desc' => 'required',
                'book_cover' => 'required|file', 
                'book_date' => 'required|numeric',
                'author_id' => 'required|numeric|exists:authors,author_id',
                'book_genre' => 'required',
                'page_num' => 'required'
            ]);
            

        if ($request->hasFile('book_cover')) {
            $imagePath = $request->file('book_cover')->store('book_covers', 'public');
            $data['book_cover'] = $imagePath; 
        }

        $newBook = Book::create($data);

        return redirect(route('book.index'));

        return redirect(route('book.index'))->with('success', 'Book added successfully!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator->getMessageBag()->toArray())->withInput();
    }
    }

    //Displaying edit book info page
    public function edit(Book $book){
        return view('books.edit',['book' => $book]);

    }

    //Updating book info function
    public function update(Book $book,Request $request){
        try{

        
            $data = $request->validate([
                'book_title' => 'required',
                'book_desc' => 'required', 
                'book_date' => 'required|numeric',
                'author_id' => 'required|numeric|exists:authors,author_id',
                'book_genre' => 'required',
                'page_num' => 'required'
            ]);

        $book->update($data);

        return redirect(route('book.index'))->with('success', 'Book updated successfully!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator->getMessageBag()->toArray())->withInput();
    }
    }

    //Updating book cover image function
    public function updateCover(Book $book,Request $request){
        try{

        
            $data = $request->validate([
                'book_cover' => 'required|file', 
            ]);

        if ($request->hasFile('book_cover')) {
            $imagePath = $request->file('book_cover')->store('book_covers', 'public');
            $data['book_cover'] = $imagePath; 
        }

        $book->update($data);

        return redirect(route('book.index'))->with('success','Book Cover Updated Successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator->getMessageBag()->toArray())->withInput();
    }
    }

    //Deleting book function
    public function destroy(Book $book){
        try{
            $book -> delete();
        return redirect(route('book.index'))->with('success','Book Deleted Successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }

    //Displaying all books function
    public function display()
    {
        $books = Book::all();

        return view('books.display', ['books' => $books]);
    }

    //Showing an individual book
    public function show(Book $book)
{
    $book->load('author', 'readingList.user');

    return view('books.show', compact('book'));
}

    //Searching for a book - For User
    public function search(Request $request)
{
    $query = $request->input('query');

    $books = Book::where(function ($queryBuilder) use ($query) {
        $queryBuilder->where('book_title', 'like', '%' . $query . '%')
            ->orWhere('book_desc', 'like', '%' . $query . '%');
    })
    ->orWhereHas('author', function ($queryBuilder) use ($query) {
        $queryBuilder->where('author_name', 'like', '%' . $query . '%');
    })
    ->get();


    return view('books.search_results', compact('books'));
}

    //Searching for a book - For Admin
    public function admSearch(Request $request)
{
    $query = $request->input('query');

    $books = Book::where(function ($queryBuilder) use ($query) {
        $queryBuilder->where('book_title', 'like', '%' . $query . '%')
            ->orWhere('book_desc', 'like', '%' . $query . '%');
    })
    ->orWhereHas('author', function ($queryBuilder) use ($query) {
        $queryBuilder->where('author_name', 'like', '%' . $query . '%');
    })
    ->get();

    return view('books.admSearch_results', compact('books'));
}



    
}

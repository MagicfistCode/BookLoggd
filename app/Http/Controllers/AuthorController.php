<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    //Displaying all Authors
    public function index(){
        $authors = Author::all();
        return view('authors.index', ['authors' => $authors]);
    }

    //Displaying the create page for authors
    public function create(){
        return view('authors.create');
    }

    //Storing author function - Adds new author to database
    public function store(Request $request){
        try{

        
            $data = $request->validate([
                'author_name' => 'required',
                'author_desc' => 'required',
                'author_dob' => '',
                'author_death' => '',
                'author_nationality' =>'',
                'author_photo' => 'file', 
            ]);

        if ($request->hasFile('author_photo')) {
            $imagePath = $request->file('author_photo')->store('author_photos', 'public');
            $data['author_photo'] = $imagePath; 
        }

        $newAuthor = Author::create($data);

        return redirect(route('author.index'));

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator->getMessageBag()->toArray())->withInput();
    }
    }

    //Displaying edit author page
    public function edit(Author $author){
        return view('authors.edit',['author' => $author]);

    }

    //Updating author information function
    public function update(Author $author,Request $request){
        try{

        
            $data = $request->validate([
                'author_name' => 'required',
                'author_desc' => 'required',
                'author_dob' => '',
                'author_death' => '',
                'author_nationality' =>'',
                'author_photo' => 'file', 
            ]);

        $author->update($data);

        return redirect(route('author.index'))->with('success','Author Details Updated Successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator->getMessageBag()->toArray())->withInput();
    }
    }

    //updating author picture function
    public function updateCover(Author $author,Request $request){
        try{

        
            $data = $request->validate([
                'author_photo' => 'required|file', 
            ]);

        if ($request->hasFile('author_photo')) {
            $imagePath = $request->file('author_photo')->store('author_photos', 'public');
            $data['author_photo'] = $imagePath; 
        }

        $author->update($data);

        return redirect(route('author.index'))->with('success','Author Photo Updated Successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator->getMessageBag()->toArray())->withInput();
    }
    }


    //Deleting author from database function
    public function destroy(Author $author){
        try{
            $author -> delete();
        return redirect(route('author.index'))->with('success','Author Deleted Successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }

    //Searching for an author - For Admin
    public function admSearch(Request $request)
    {
        $query = $request->input('query');

        $authors = Author::where('author_name', 'like', '%' . $query . '%')
                    ->get();

        return view('authors.admSearch_results', compact('authors'));
    }

    //Showing an individual author
    public function show(Author $author)
    {
        $author->load('books');

        return view('authors.show', compact('author'));
    }

}

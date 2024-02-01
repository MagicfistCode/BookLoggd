<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Badge;

class BadgeController extends Controller
{
    //Displaying all Badges (for admin)
    public function index(){
        $badges = Badge::all();
        return view('badges.index',['badges' => $badges]);
    }

    //Displaying the create page for badges
    public function create(){
        return view('badges.create');
    }

    //Storing badge function - Adds new badge to database
    public function store(Request $request){
        try{

        
            $data = $request->validate([
                'badge_name' => 'required',
                'badge_image' => 'file',
                'badge_desc' => 'required',
                'badge_book_req' => '',
                'badge_page_num_req' =>'',
                'badge_genre_requirement' => '', 
            ]);

        if ($request->hasFile('badge_image')) {
            $imagePath = $request->file('badge_image')->store('badge_image', 'public');
            $data['badge_image'] = $imagePath; 
        }

        $newAuthor = Badge::create($data);

        return redirect(route('badge.index'));

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator->getMessageBag()->toArray())->withInput();
    }
    }

     //Displaying edit badge page
     public function edit(Badge $badge){
        return view('badges.edit',['badge' => $badge]);

    }

    //Updating badge information function
    public function update(Badge $badge,Request $request){
        try{

        
            $data = $request->validate([
                'badge_name' => 'required',
                'badge_desc' => 'required',
                'badge_book_req' => '',
                'badge_page_num_req' =>'',
                'badge_genre_requirement' => '', 
            ]);

        $badge->update($data);

        return redirect(route('badge.index'))->with('success','Badge Details Updated Successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator->getMessageBag()->toArray())->withInput();
    }
    }

    //updating badge image function
    public function updateCover(Badge $badge,Request $request){
        try{

        
            $data = $request->validate([
                'badge_image' => 'required|file', 
            ]);

        if ($request->hasFile('badge_image')) {
            $imagePath = $request->file('badge_image')->store('badge_image', 'public');
            $data['badge_image'] = $imagePath; 
        }

        $badge->update($data);

        return redirect(route('badge.index'))->with('success','Badge Photo Updated Successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator->getMessageBag()->toArray())->withInput();
    }
    }

    //Deleting badge from database function
    public function destroy(Badge $badge){
        try{
            $badge -> delete();
        return redirect(route('badge.index'))->with('success','Badge Deleted Successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }

    //Displaying all the badges for the user
    public function display()
    {
        $badges = Badge::all(); // Retrieve all badges from the database

        return view('badges.display', ['badges' => $badges]);
    }

    //Searching for a badge - For Admin
    public function admSearch(Request $request)
    {
        $query = $request->input('query');

        $badges = Badge::where('badge_name', 'like', '%' . $query . '%')
                    ->get();

        return view('badges.admSearch_results', compact('badges'));
    }
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            background-color: #121212;
            color:white;
        }
    </style>
    <title>Edit Book</title>
</head>
<body>
    <nav class="navbar bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: white; font-size:22px; width:90px">
                <img src="{{ asset('storage/' . 'logos/B-Logo-2.png') }}" alt="Logo" width="50%" height="50%"
                    class="align-text-top">
                BookLoggd
            </a>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('book.index') }}">Manage Books</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('author.index') }}">Manage Authors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('badge.index') }}">Manage Badges</a> 
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Log Out</button>
                    </form>
                </li>
            </ul>
    </nav>
    <center><h1 class="display-2">Edit a Book</h1></center>
    <div class="container-sm" style="background-color:#212529; color:white; max-width:50%; border-radius:2%; padding:2%; font-size:18px;">
    <div>
        <div>
            @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
    <form method="post" action="{{route('book.update', ['book' => $book])}}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label class="form-label">Book Title: </label>
            <input class="form-control" type="text" name="book_title" placeholder="Title" value="{{$book->book_title}}" />
        </div>
        <div class="mb-3">
            <label class="form-label">Book Description: </label>
            <textarea class="form-control" type="text" name="book_desc" placeholder="Description" value="{{$book->book_desc}}">{{$book->book_desc}}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Book Release Date: </label>
            <input class="form-control" type="number" name="book_date" placeholder="Year of Release" value="{{$book->book_date}}"/>
        </div>
        <div class="mb-3">
            <label class="form-label">Book Author: </label>
            <input class="form-control" type="number" name="author_id" placeholder="Enter Author ID" value="{{$book->author_id}}"/>
        </div>
        <div class="mb-3">
            <label class="form-label">Book Genre: </label>
            <input class="form-control" type="text" name="book_genre" placeholder="Genre" value="{{$book->book_genre}}"/>
        </div>
        <div class="mb-3">
            <label class="form-label">No. of Pages: </label>
            <input class="form-control" type="number" name="page_num" placeholder="No. of Pages" value="{{$book->page_num}}"/>
        </div>
        <div class="d-grid gap-2">
           <input class="btn btn-outline-light" type="submit" value="Update" 
        </div>
    </form>
    <br>
    <form method="post" action="{{route('book.updateCover', ['book' => $book])}}" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
            <label class="form-label">Book Cover: </label>
            <input class="form-control" type="file" name="book_cover" accept="image/*"/>
    </div>
    <div class="d-grid gap-2">
           <input class="btn btn-outline-light" type="submit" value="Update Cover" 
    </div>
    </form>
</div>
</body>
</html>
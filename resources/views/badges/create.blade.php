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
    <title>Create Badge</title>
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
    <center>
    <h1 class="display-2">Create a Badge</h1>
    </center>
    <div class="container-sm" style="background-color:#212529; color:white; max-width:50%; border-radius:2%; padding:2%; font-size:18px;">
        <div>
            @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    <form method="post" action="{{route('badge.store')}}" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="mb-3">
            <label class="form-label">Badge Name: </label>
            <input class="form-control" type="text" name="badge_name" placeholder="Name of Badge" required/>
        </div>
        <div class="mb-3">
            <label class="form-label">Badge Description: </label>
            <textarea class="form-control" type="text" rows="3" name="badge_desc" placeholder="Description" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Badge Image: </label>
            <input class="form-control" type="file" name="badge_image" accept="image/*" required/>
        </div>
        <div class="mb-3">
            <label class="form-label">Completed No. of Books Required: </label>
            <input class="form-control" type="number" name="badge_book_req" placeholder="(optional)"/>
        </div>
        <div class="mb-3"> 
            <label class="form-label">No. of Pages Read Required: </label>
            <input class="form-control" type="number" name="badge_page_num_req" placeholder="(optional)" />
        </div>
        <div class="mb-3">
            <label class="form-label">Specific Genre Required: </label>
            <input class="form-control" type="text" name="badge_genre_requirement" placeholder="(optional)" />
        </div>
        <div class="d-grid gap-2">
           <input type="submit" class="btn btn-outline-light" value="Save a New Badge"
        </div>
    </form>
</div>
</body>
</html>
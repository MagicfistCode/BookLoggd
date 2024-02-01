<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            background-color: #121212;
            color: white;
        }
    </style>
    <title>Author Index</title>
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
    <h1 class="display-1">Author Management</h1>
    <div class="container-sm" style="background-color:#212529; color:white; margin:0%; padding:2%; font-size:18px;">
    <div>
        @if(session()->has('success'))
            {{session('success')}}
        @endif
    </div>
    <div>
        <div class="d-grid gap-2">
            <a href="{{route('author.create')}}" class="btn btn-outline-light"> Add a New Author</a>
        </div>
        <div class="my-2">
            <form action="{{ route('author.admSearch') }}" method="GET" class="mb-6 d-flex">
                <input type="text" name="query" placeholder="Search authors..." class="flex-grow-1 p-2 mx-1 rounded">
                <button type="submit" class="btn btn-primary ml-2">Search</button>
            </form>
        </div>
        <table class="table table-dark table-hover">
           <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Description</th>
            <th>Born</th>
            <th>Died</th>
            <th>Nationality</th>
            <th>Edit</th>
            <th>Delete</th>
           </tr>
           @foreach($authors as $author)
                <tr>
                    <td>{{$author->author_id}}</td>
                    <td>
                        <img src="{{ asset('storage/' . $author->author_photo) }}" alt="{{$author->author_name}} Cover" style="max-width: 100px;">
                    </td>
                    <td>{{$author->author_name}}</td>
                    <td>{{$author->author_desc}}</td>
                    <td>{{$author->author_dob}}</td>
                    <td>{{$author->author_death}}</td>
                    <td>{{$author->author_nationality}}</td>
                    <td>
                        <a href="{{route('author.edit', ['author' => $author->author_id])}}" class="btn btn-outline-primary"><i class="bi bi-pen"></i></a>
                    </td>
                    <td>
                    <form method="post" action="{{ route('author.destroy', ['author' => $author->author_id]) }}" onsubmit="return confirm('Are you sure you want to delete this author?')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
                </tr>
           @endforeach 
        </table>
    </div>
</div>
</center>  
</body>
</html>
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
    <title>Book Index</title>
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
    </div>
    <center>
        <h1 class="display-1">Book Management</h1>
        <div class="container-sm" style="background-color:#212529; color:white; margin:0%; padding:2%; font-size:18px;">
            <div>
                @if (session()->has('success'))
                    {{ session('success') }}
                @endif
            </div>
            <div>
                <div class="d-grid gap-2">
                    <a href="{{ route('book.create') }}" class="btn btn-outline-light"> Add a New Book</a>
                </div>
                <div class="my-2">
                <form action="{{ route('book.admSearch') }}" method="GET" class="mb-6 d-flex">
                    <input type="text" name="query" placeholder="Search books..." class="flex-grow-1 p-2 mx-1 rounded">
                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                </form>
                </div>                
                <table class="table table-dark table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Release Date</th>
                        <th>Author ID</th>
                        <th>Author Name</th>
                        <th>Genre</th>
                        <th>No. of Pages</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $book->book_id }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $book->book_cover) }}"
                                    alt="{{ $book->book_title }} Cover" style="max-width: 100px;">
                            </td>
                            <td>{{ $book->book_title }}</td>
                            <td>{{ $book->book_desc }}</td>
                            <td>{{ $book->book_date }}</td>
                            <td>{{$book->author_id }}</td>
                            <td>{{$book->author->author_name}}</td>
                            <td>{{ $book->book_genre }}</td>
                            <td>{{ $book->page_num }}</td>
                            <td>
                                <a href="{{ route('book.edit', ['book' => $book->book_id]) }}"
                                    class="btn btn-outline-primary"><i class="bi bi-pen"></i></a>
                            </td>
                            <td>
                                <form method="post" action="{{ route('book.destroy', ['book' => $book->book_id]) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this book?')">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-outline-danger"><i
                                            class="bi bi-trash"></i></button>
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

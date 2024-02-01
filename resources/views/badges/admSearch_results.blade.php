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
    <title>Badge Index</title>
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
        <h1 class="display-1">Badge Management</h1>
        <div class="container-sm" style="background-color:#212529; color:white; margin:0%; padding:2%; font-size:18px;">
            <div>
                @if (session()->has('success'))
                    {{ session('success') }}
                @endif
            </div>
            <div>
                <div class="d-grid gap-2">
                    <a href="{{ route('badge.create') }}" class="btn btn-outline-light"> Add a New Badge</a>
                </div>
                <div class="my-2">
                    <form action="{{ route('badge.admSearch') }}" method="GET" class="mb-6 d-flex">
                        <input type="text" name="query" placeholder="Search badges..." class="flex-grow-1 p-2 mx-1 rounded">
                        <button type="submit" class="btn btn-primary ml-2">Search</button>
                    </form>
                    </div>
                <table class="table table-dark table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Completed No. of Books</th>
                        <th>No. of Pages Read</th>
                        <th>Genre</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    @foreach ($badges as $badge)
                        <tr>
                            <td>{{ $badge->badge_id }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $badge->badge_image) }}"
                                    alt="{{ $badge->badge_name }} Cover" style="max-width: 100px;">
                            </td>
                            <td>{{ $badge->badge_name }}</td>
                            <td>{{ $badge->badge_desc }}</td>
                            <td>{{ $badge->badge_book_req}}</td>
                            <td>{{ $badge->badge_page_num_req }}</td>
                            <td>{{ $badge->badge_genre_requirement	 }}</td>
                            <td>
                                <a href="{{ route('badge.edit', ['badge' => $badge->badge_id]) }}"
                                    class="btn btn-outline-primary"><i class="bi bi-pen"></i></a>
                            </td>
                            <td>
                                <form method="post" action="{{ route('badge.destroy', ['badge' => $badge->badge_id]) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this badge?')">
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

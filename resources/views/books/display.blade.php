<x-app-layout>
    <x-slot name="header" class="bg-gray-600 text-white py-4 px-6">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Browse Books') }}
        </h2>
    </x-slot>
    

    <div class="bg-gray-900 py-6">
        <div class="container mx-auto">
            <form action="{{ route('books.search') }}" method="GET" class="mb-6 flex">
                <input type="text" name="query" placeholder="Search books..." class="flex-1 bg-gray-800 text-white p-2 rounded">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Search</button>
            </form> 
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($books as $book)
                    <div class="bg-gray-800  p-4 shadow-md rounded-lg">
                        <img src="{{ asset('storage/' . $book->book_cover) }}" alt="{{ $book->book_title }}" class="w-100 h-100 object-cover rounded mb-4">
                        <h3 class="text-lg text-white font-semibold">{{ $book->book_title }}</h3>
                        <a href="{{ route('author.show', ['author' => $book->author_id]) }}" class="text-white hover:text-blue-300"><p>{{ $book->author->author_name }}</p></a>
                        <p class="text-gray-300">{{ \Illuminate\Support\Str::limit($book->book_desc, 200) }}</p>
                        <a href="{{ route('book.show', ['book' => $book->book_id]) }}" class="text-blue-300 hover:text-white underline">View Details</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

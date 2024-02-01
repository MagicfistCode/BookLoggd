<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Author') }}
        </h2>
    </x-slot>

    <div class="bg-gray-900 py-6">
        <div class="container mx-auto py-6">
            <div class="bg-gray-800 p-4 shadow-md rounded-lg flex">
                <!-- Author Details -->
                <div class="w-1/4 pr-6 text-gray-300">
                    <img src="{{ asset('storage/' . $author->author_photo) }}" alt="{{ $author->author_name }}" class="w-full h-100 object-cover rounded mb-4">
                </div>
                <div class="w-3/4 text-gray-300">
                    <h2 class="text-2xl font-semibold">{{ $author->author_name }}</h2>
                    <h2 class="text-lg font-semibold">Description:</h2>
                    <p>{{ $author->author_desc }}</p>
                    <h2 class="text-lg font-semibold">Born:</h2>
                    <p>{{ $author->author_dob }}</p>
                    @if ($author->author_death)
                    <!-- Display date of death only if the author is dead-->
                    <h2 class="text-lg font-semibold">Died:</h2>
                    <p>{{ $author->author_death }}</p>
                @endif
                    <h2 class="text-lg font-semibold">Nationality:</h2>
                    <p>{{ $author->author_nationality }}</p>              
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-gray-900 py-6">
        <div class="container mx-auto py-6">
            <h2 class="text-2xl font-semibold text-gray-300 mb-4">All Books</h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-5">
                @foreach($author->books as $book)
                    <div class="bg-gray-800 p-4 shadow-md rounded-lg">
                        <img src="{{ asset('storage/' . $book->book_cover) }}" alt="{{ $book->book_title }}" class="w-full h-100 object-cover rounded mb-4">
                        <h3 class="text-lg text-white font-semibold">{{ $book->book_title }}</h3>
                        <p class="text-l text-white italic">{{ $book->author->author_name }}</p>
                        <p class="text-gray-300">{{ \Illuminate\Support\Str::limit($book->book_desc, 100) }}</p>
                        <a href="{{ route('book.show', ['book' => $book->book_id]) }}" class="text-blue-300 hover:text-white underline">View Details</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>    


</x-app-layout>

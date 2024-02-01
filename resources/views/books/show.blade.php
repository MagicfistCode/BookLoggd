<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Browse Books') }}
        </h2>
    </x-slot>

    <div class="bg-gray-900 py-6">
        <div class="container mx-auto py-6">
            <div class="bg-gray-800 p-4 shadow-md rounded-lg flex">
                <!-- Book Details -->
                <div class="w-1/3 pr-6 text-gray-300">
                    <img src="{{ asset('storage/' . $book->book_cover) }}" alt="{{ $book->book_title }}"
                        class="w-full h-100 object-cover rounded mb-4">
                        <h2 class="text-2xl font-semibold text-center">{{ $book->book_title }}</h2>
                    <a href="{{ route('author.show', ['author' => $book->author_id]) }}" class="hover:text-blue-300 text-center italic">
                        <p>{{ $book->author->author_name }}</p>
                    </a>    
                </div>
                <div class="w-2/3 text-gray-300">
                    <h2 class="text-lg font-semibold">Synopsis:</h2>
                    <p>{{ $book->book_desc }}</p>
                    <h2 class="text-lg font-semibold">Release Date:</h2>
                    <p>{{ $book->book_date }}</p>
                    <h2 class="text-lg font-semibold">Genre:</h2>
                    <p>{{ $book->book_genre }}</p>
                    <h2 class="text-lg font-semibold">Length:</h2>
                    <p>{{ $book->page_num }} pages</p>

                    @php
                        // Calculate average rating for the book
                        $totalRatings = 0;
                        $totalEntries = 0;

                        foreach ($book->readingList as $entry) {
                            if ($entry->rating !== null) {
                                $totalRatings += $entry->rating;
                                $totalEntries++;
                            }
                        }

                        $averageRating = $totalEntries > 0 ? $totalRatings / $totalEntries : 0;
                    @endphp

                    <h2 class="text-lg font-semibold">Average Rating:</h2>
                    <p>{{ number_format($averageRating, 2) }}/10</p>
                    <h2 class="text-lg font-semibold">Total Members:</h2>
                    <p>{{ $totalEntries }}</p>


                    <div class="bg-gray-800 p-4 shadow-md rounded-lg">
                        <center>
                            <h2 class="text-2xl font-semibold">Add to Reading List</h2>
                        </center>
                        <!-- Adding to reading list -->
                        <form method="post" action="{{ route('readinglist.store') }}">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->book_id }}">

                            @php
                                $readingListEntry = \App\Models\ReadingList::where('id', auth()->id())
                                    ->where('book_id', $book->book_id)
                                    ->first();
                            @endphp

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div class="col-span-1">
                                    <label for="status" class="block text-white">Reading Status:</label>
                                    <select id="status" name="reading_status" class="form-select bg-gray-900">
                                        <option value="Reading"
                                            {{ isset($readingListEntry) && $readingListEntry->reading_status === 'Reading' ? 'selected' : '' }}>
                                            Reading</option>
                                        <option value="Completed"
                                            {{ isset($readingListEntry) && $readingListEntry->reading_status === 'Completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="Dropped"
                                            {{ isset($readingListEntry) && $readingListEntry->reading_status === 'Dropped' ? 'selected' : '' }}>
                                            Dropped</option>
                                        <option value="Planning to Read"
                                            {{ isset($readingListEntry) && $readingListEntry->reading_status === 'Planning to Read' ? 'selected' : '' }}>
                                            Planning to Read</option>
                                    </select>
                                </div>
                                <div class="col-span-1">
                                    <label for="rating" class="block text-white">Rating:</label>
                                    <input type="number" step="0.1" min="0.1" max="10" id="rating"
                                        name="rating" class="form-input bg-gray-900"
                                        value="{{ isset($readingListEntry) ? $readingListEntry->rating : '' }}">

                                </div>
                                <div class="col-span-1">
                                    <label for="page_num" class="block text-white">Page Number:</label>
                                    <input type="number" id="page_num" name="reading_page_num"
                                        class="form-input bg-gray-900"
                                        value="{{ isset($readingListEntry) ? $readingListEntry->reading_page_num : '' }}"
                                        @isset($book)
                                            max="{{ $book->page_num }}"
                                        @endisset>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="note" class="block text-white">Review:</label>
                                <textarea id="note" name="reading_note" class="form-textarea w-full bg-gray-900" rows="3">{{ isset($readingListEntry) ? $readingListEntry->reading_note : '' }}</textarea>
                            </div>
                            <button type="submit"
                                class="bg-purple-800 hover:bg-purple-900 text-white font-bold py-2 px-4 w-full mt-4 rounded">
                                Save to Reading List
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-900 py-6">
        <div class="container mx-auto py-6">
            <h2 class="text-2xl font-semibold text-gray-300 mb-4">User Ratings and Reviews</h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($book->readingList as $entry)
                    @if ($entry->reading_status !== 'Planning to Read' && $entry->rating !== null && $entry->reading_note !== null)
                        <div class="bg-gray-800 p-4 shadow-md rounded-lg">
                            <a href="{{ route('user.profile', ['user' => $entry->user->id]) }}">
                                <div class="flex items-center mb-2">
                                    <img src="{{ $entry->user->image }}" alt="{{ $entry->user->name }}"
                                        class="w-8 h-8 rounded-full mr-2">
                                    <h3 class="text-white">{{ $entry->user->name }} ● {{ $entry->reading_status }} ●
                                        {{ $entry->rating }} / 10 </h3>
                                </div>
                            </a>
                            <p class="text-gray-300">{{ $entry->reading_note }}</p>
                            <br>
                            <p class="text-gray-300">Pages Read: {{ $entry->reading_page_num }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>



</x-app-layout>

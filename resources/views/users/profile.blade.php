<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            User Profile - {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Profile Information --}}
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-800 text-white flex items-end">
                    {{-- Showing user profile pic --}}
                    @if ($user->image)
                        <img src="{{ $user->image }}" alt="{{ $user->name }}" style="width: 170px; height: 170px;"
                            class="border border-gray-700 mr-4">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-300 mr-4"></div>
                    @endif

                    <div>
                        {{-- Showing user's name --}}
                        <h1 class="text-4xl font-semibold">{{ $user->name }}</h1>
                    </div>
                </div>
            </div>

            <div>
                {{-- Showing reading list --}}
                <div class="bg-gray-800 mt-5 mx-2 shadow-sm sm:rounded-lg text-white">
                    <button class="bg-purple-800 font-bold py-1 px-4 rounded w-full hover:bg-purple-900">
                        <a href="{{ route('readinglist.show', ['user' => $user]) }}">View Reading List</a>
                    </button>
                </div>

                <div class="bg-gray-900 my-3 shadow-sm sm:rounded-lg flex text-white">
                    <div class="bg-gray-800 m-2 w-1/3 p-5 sm:rounded-lg">
                        <h1>Badges</h1>
                        <div class="flex flex-wrap">
                            @foreach ($badges as $badge)
                                <div>
                                    @php
                                        $meetsCriteria = true;

                                        // Check if the badge has a Completed No. Books requirement
                                        if ($badge->badge_book_req !== null) {
                                            // Calculating total completed books by the user
                                            $completedBooks = $user->readingList->where('reading_status', 'Completed')->count();

                                            // Check if the user meets the Completed Books requirement
                                            if ($completedBooks < $badge->badge_book_req) {
                                                $meetsCriteria = false;
                                            }
                                        }

                                        // Check if the badge has a Number of Pages Read requirement
                                        if ($badge->badge_page_num_req !== null) {
                                            // Calculating total pages read by the user
                                            $totalPagesRead = $user->readingList->whereNotNull('reading_page_num')->sum('reading_page_num');

                                            // Check if the user meets the Number of Pages Read requirement
                                            if ($totalPagesRead < $badge->badge_page_num_req) {
                                                $meetsCriteria = false;
                                            }
                                        }

                                        // Check if the badge has a Genre requirement
                                        if ($badge->badge_genre_requirement !== null) {
                                            // Retrieve the completed reading list entries of the user
                                            $completedReadingList = $user->readingList->where('reading_status', 'Completed');

                                            // Extract the book IDs from completed reading list entries
                                            $completedBookIds = $completedReadingList->pluck('book_id')->toArray();

                                            // Count the number of completed entries that match the badge's genre requirement
    $genreReq = $user
        ->books()
        ->where('book_genre', $badge->badge_genre_requirement)
                                                ->count();

                                            // Check if the user meets the Genre requirement
                                            if ($genreReq < $badge->badge_book_req) {
                                                $meetsCriteria = false;
                                            }
                                        }

                                    @endphp

                                    @if ($meetsCriteria)
                                        <img src="{{ asset('storage/' . $badge->badge_image) }}"
                                            alt="{{ $badge->badge_name }}" class="w-20 h-20">
                                    @endif
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="w-2/3">
                        <div class="bg-gray-800 m-2 p-5 sm:rounded-lg flex">

                            <div class="bg-gray-700 m-2 w-1/3 p-5 sm:rounded-lg text-center">
                                <p class="text-4xl font-semibold">{{ $totalBooks }}</p>
                                <p class="text-gray-400 text-xs">Total Books</p>
                            </div>

                            {{-- Calculate total pages read --}}
                            @php
                                $totalPagesRead = 0;
                                foreach ($user->readingList as $entry) {
                                    if ($entry->reading_page_num) {
                                        $totalPagesRead += $entry->reading_page_num;
                                    }
                                }
                            @endphp

                            <div class="bg-gray-700 m-2 w-1/3 p-5 sm:rounded-lg text-center">
                                <p class="text-4xl font-semibold">{{ $totalPagesRead }}</p>
                                <p class="text-gray-400 text-xs">Pages Read</p>
                            </div>

                            {{-- Calculate mean rating --}}
                            @php
                                $totalRatings = 0;
                                $numRatings = 0;
                                foreach ($user->readingList as $entry) {
                                    if ($entry->rating !== null) {
                                        $totalRatings += $entry->rating;
                                        $numRatings++;
                                    }
                                }
                                $meanRating = $numRatings > 0 ? $totalRatings / $numRatings : 0;
                                //fixing the mean rating to one decimal place
                                $formatMeanRating = number_format($meanRating, 1);
                            @endphp

                            <div class="bg-gray-700 m-2 w-1/3 p-5 sm:rounded-lg text-center">
                                <p class="text-4xl font-semibold">{{ $formatMeanRating }}</p>
                                <p class="text-gray-400 text-xs">Mean Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap text-white">
                    <div class="w-1/3">
                    </div>
                    <div class="w-2/3 text-xl p-6">
                        <h1>Activity</h1>
                        @if (auth()->check() && auth()->id() === $user->id)
                            <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div
                                    class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                    <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                                        <textarea id="content" name="content" rows="2"
                                            class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                            placeholder="Write a Post..." required></textarea>
                                    </div>
                                    <div
                                        class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                                        <button type="submit"
                                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-purple-700 rounded-lg focus:ring-4 focus:ring-purple-200 dark:focus:ring-purple-900 hover:bg-purple-800">
                                            Publish
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif

                        @if (isset($posts) && $posts->isNotEmpty())
                            <div class="bg-gray-800 my-2 p-5 sm:rounded-lg">
                                @foreach ($posts as $post)
                                    <div class="rounded-lg p-4 mb-4 bg-gray-700">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <img src="{{ $post->user->image }}" alt="{{ $post->user->name }}"
                                                    class="w-10 h-10 rounded-full mr-3">
                                                <h3 class="text-lg font-semibold">{{ $post->user->name }}</h3>
                                            </div>
                                            <p class="text-xs text-right">{{ $post->created_at }}</p>
                                        </div>
                                        <p>{{ $post->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No posts available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


</x-app-layout>

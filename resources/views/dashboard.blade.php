<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="bg-gray-900 py-6 text-white">
        <div class="flex">
            <div class="m-4 p-5 text-white w-2/3 rounded-sm shadow-sm">
                <h1 class="text-3xl my-2">Activity</h1>
                <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div
                        class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                            <textarea id="content" name="content" rows="1"
                                class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                placeholder="Write a Post..." required></textarea>
                        </div>
                        <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                            <button type="submit"
                                class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-purple-700 rounded-lg focus:ring-4 focus:ring-purple-200 dark:focus:ring-purple-900 hover:bg-purple-800">
                                Publish
                            </button>
                        </div>
                    </div>
                </form>
                @if (isset($posts) && $posts->isNotEmpty())
                    <div class="bg-gray-800 p-5 text-white w-full rounded-sm shadow-sm">
                        @foreach ($posts as $post)
                            <div class="border border-gray-600 rounded-md mb-4 p-4">
                                <div class="flex items-center justify-between mb-2">
                                    @if ($post->user)
                                        <div class="flex items-center">
                                            <a href="{{ route('user.profile', ['user' => $post->user->id]) }}">
                                            {{-- user profile picture --}}
                                            <img src="{{ $post->user->image }}" alt="{{ $post->user->name }}"
                                                class="w-10 h-10 rounded-full mr-3">
                                            </a>
                                            <a href="{{ route('user.profile', ['user' => $post->user->id]) }}">
                                            {{-- user's name --}}
                                            <h3 class="text-lg font-semibold">{{ $post->user->name }}</h3>
                                            </a>
                                        </div>
                                        {{-- date the post was made --}}
                                        <p class="text-xs text-right">{{ $post->created_at }}</p>
                                    @else
                                        {{-- Checking if user exists (testing purposes) --}}
                                        <p>User not found</p>
                                    @endif
                                </div>

                                {{-- Display post content --}}
                                <p>{{ $post->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No posts available</p>
                @endif
            </div>
            <div class="bg-gray-900 m-4 p-5 text-white w-1/3 h-1/2">
                <h1 class="font-bold">Books in Progress</h1>
                <div class="grid grid-cols-3 mt-4 bg-gray-800 my-5 p-2 rounded-sm shadow-sm">
                    @foreach (auth()->user()->readingList as $entry)
                        @if ($entry->reading_status === 'Reading')
                            <div>
                                <a href="{{ route('book.show', ['book' => $entry->book_id]) }}">
                                    <img src="{{ asset('storage/' . $entry->book->book_cover) }}"
                                        alt="{{ $entry->book->book_title }}" class="w-32 py-1 object-cover rounded-md">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div> 
                <h1 class="font-bold">Most Recent Reviews</h1>
                <div class="bg-gray-800 text-white p-2 my-3 rounded-sm shadow-sm">
                    <div class="h-1/2">
                        {{-- Fetch and display recent reviews --}}
                        @foreach (\App\Models\ReadingList::whereNotNull('rating')->whereNotNull('reading_note')->where('reading_status', '!=', 'Planning to Read')->orderBy('created_at', 'desc')->take(6)->get() as $entry)
                            <div class="bg-gray-800 p-4 my-2 shadow-md rounded-lg">
                                <a href="{{route('book.show', ['book'=>$entry->book_id])}}">
                                <h2 class="text-gray-300 ">{{ $entry->book->book_title}}</h2>
                                </a>
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
                        @endforeach
                    </div>
                </div> 
            </div>
        </div>
    </div>
</x-app-layout>

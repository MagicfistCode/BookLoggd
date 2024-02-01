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


            <div class="bg-gray-800 mt-5 mx-2 shadow-sm sm:rounded-lg text-white">
                <a href="javascript:void(0)" onclick="window.history.back()">
                    <button class="bg-purple-800 font-bold py-1 px-4 rounded w-full hover:bg-purple-900">
                        Overview
                    </button>
                </a>
            </div>
            

            <div class="bg-gray-900 py-6">
                @if ($readingList->isEmpty())
                    <p class="text-white">No books in your reading list yet.</p>
                @else
                    <div class="row">
                        <div>
                            <table class="w-full text-white">
                                <thead class="bg-black">
                                    <tr>
                                        <th class="text-left px-1">Cover</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Page Number</th>
                                        <th>Rating</th>
                                        <th>Review</th>

                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($readingList as $entry)
                                        <tr class="border border-gray-700">
                                            <td>
                                                <a href="{{ route('book.show', ['book' => $entry->book->book_id]) }}">
                                                <img src="{{ asset('storage/' . $entry->book->book_cover) }}"
                                                    alt="{{ $entry->book->book_title }}" width="100" height="100">
                                                </a>
                                            </td>
                                            <td>{{ $entry->book->book_title }}</td>
                                            <td>{{ $entry->reading_status }}</td>
                                            <td>{{ $entry->reading_page_num }}</td>
                                            <td>{{ $entry->rating }}</td>
                                            <td>{{ $entry->reading_note }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
</x-app-layout>

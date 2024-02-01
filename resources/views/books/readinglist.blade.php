<x-app-layout>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="your-integrity-code" crossorigin="anonymous">
    </head>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Reading List') }}
        </h2>
    </x-slot>

    <div class="bg-gray-900 py-6 px-40">
    <div class="container">
        @if ($readingList->isEmpty())
            <p class="text-white">No books in your reading list yet.</p>
        @else
            <div class="row mx-5">
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
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($readingList as $entry)
                                <tr class="border border-gray-700">
                                    <td>
                                        <a href="{{ route('book.show', ['book' => $entry->book->book_id]) }}">
                                        <img src="{{ asset('storage/' . $entry->book->book_cover) }}" alt="{{ $entry->book->book_title }}" width="100" height="100">
                                        </a>
                                    </td>
                                    <td>{{ $entry->book->book_title }}</td>
                                    <td>{{ $entry->reading_status }}</td>
                                    <td>{{ $entry->reading_page_num }}</td>
                                    <td>{{ $entry->rating }}</td>
                                    <td>{{ $entry->reading_note }}</td>
                                    <td>
                                        <a href="{{ route('book.show', ['book' => $entry->book->book_id]) }}" class="text-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('readinglist.destroy', $entry->list_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>                                    
                                    </td>
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

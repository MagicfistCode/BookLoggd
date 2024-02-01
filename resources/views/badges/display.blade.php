<x-app-layout>
    <x-slot name="header" class="bg-gray-600 text-white py-4 px-6">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Badges') }}
        </h2>
    </x-slot>

    <div class="bg-gray-800 p-6">
        <div class="grid grid-cols-2 gap-4">
            @foreach($badges as $badge)
                <div class="bg-gray-700 p-4 rounded-lg text-white flex items-center">
                    <div class="mr-4">
                        <img src="{{ asset('storage/' . $badge->badge_image) }}" alt="{{ $badge->badge_name }}" class="w-20 h-20 rounded-full mb-2">
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">{{ $badge->badge_name }}</h2>
                        <p>{{ $badge->badge_desc}}</p>
                    </div>
                </div>
            @endforeach
        </div>
        
    </div>
</x-app-layout>

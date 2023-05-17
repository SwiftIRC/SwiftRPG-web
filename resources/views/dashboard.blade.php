<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Items: {{ $user->items->count() }}

                    <ol class="list-decimal">
                        @foreach ($user->items as $item)
                            <li>{{ $item->name }}
                                @if ($item->quantity > 1)
                                    x{{ $item->quantity }}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Skills

                    <ol class="list-decimal">
                        @foreach ($user->skills as $skill)
                            <li class="ml-4">
                                {{ ucwords($skill->name) }}: {{ xp_to_level($skill->pivot->quantity) }}
                                ({{ $skill->pivot->quantity }}xp)
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

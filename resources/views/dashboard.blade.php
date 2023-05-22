<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 mt-0 text-4xl font-medium leading-tight text-primary">Items</h2>
                    <p>
                        Total Items:
                        {{ $user->items->sum('quantity') }}
                    </p>
                    <p>
                        Total Unique Items:
                        {{ $user->items->count() }}
                    </p>

                    <ol class="list-decimal">
                        @foreach ($user->items as $item)
                            <li>
                                <b>{{ $item->name }}</b>
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
                    <h2 class="mb-2 mt-0 text-4xl font-medium leading-tight text-primary">Skills</h2>

                    <ol class="list-decimal">
                        @foreach ($user->skills as $skill)
                            <li class="ml-4">
                                <b>{{ ucwords($skill->name) }}</b>: {{ xp_to_level($skill->pivot->quantity) }}
                                ({{ $skill->pivot->quantity }}xp)
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

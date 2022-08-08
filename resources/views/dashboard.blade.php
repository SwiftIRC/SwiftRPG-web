<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Items: {{ $user->items->count() }}/{{ $user->inventory_size }}

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
                        <li>
                            Thieving:
                            {{ xp_to_level($user->thieving) }}
                            ({{ $user->thieving }}xp)
                        </li>
                        <li>
                            Woodcutting:
                            {{ xp_to_level($user->woodcutting) }}
                            ({{ $user->woodcutting }}xp)
                        </li>
                        <li>
                            Firemaking:
                            {{ xp_to_level($user->firemaking) }}
                            ({{ $user->firemaking }}xp)
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

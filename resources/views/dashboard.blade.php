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
                    Items: {{ $items->count() }}/{{ $inventory_size }}
                    @foreach ($items as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm leading-5 text-gray-900">
                                    {{ $item->name }}
                                    @if ($item->quantity > 1)
                                        x{{ $item->quantity }}
                                    @endif
                                </p>
                            </div>
                            {{-- <div class="flex-shrink-0">
                                <a href="{{ route('items.edit', $item->id) }}"
                                    class="text-sm leading-5 text-gray-500 hover:text-gray-700">
                                    Edit
                                </a>
                            </div> --}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

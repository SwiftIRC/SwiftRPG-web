<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ol class="list-decimal">
                        @foreach ($users as $user)
                            <li>
                                <strong>{{ $user->name }}</strong>
                                {{ xp_to_level($user->total_xp) }} ({{ $user->total_xp }}xp)

                                @foreach ($user->skills as $skill)
                                    <span class="ml-4">
                                        {{ $skill->name }}: {{ xp_to_level($skill->pivot->quantity) }}
                                        ({{ $skill->pivot->quantity }}xp)
                                    </span>
                                @endforeach
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

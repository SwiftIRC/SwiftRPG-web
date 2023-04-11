<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div x-data="{
                        token: null,
                    
                        getToken() {
                            fetch('{{ route('auth.token') }}')
                                .then((response) => response.json())
                                .then((json) => this.token = json.token);
                            event.target.style.display = 'none';
                        }
                    }">
                        <button @click="getToken()">Get Token</button>
                        <p x-text="token"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

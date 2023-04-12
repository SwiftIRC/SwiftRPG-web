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
                        <button @click="getToken()">Click Here to generate a login token</button>
                        <p x-text="token"></p>
                        <br>
                        <h1>What is a token?</h1>
                        You can messag the bot the token to log in. It's usually `/login` or `.login` depending on your
                        platform.<br>
                        <br>
                        <code>
                            /login 11|1aatijh8eIMxCEye2Rs4K0HW12T4mXFr5ts7gEP8
                        </code>
                        <br>
                        OR
                        <br>
                        <code>
                            .login 11|1aatijh8eIMxCEye2Rs4K0HW12T4mXFr5ts7gEP8
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

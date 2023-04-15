<x-app-layout>
    <div class="py-12" x-data="{
        codeblock: '<token>',
    
        getToken() {
            fetch('{{ route('auth.token') }}')
                .then((response) => response.json())
                .then((json) => this.codeblock = json.token);
            event.target.style.display = 'none';
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <button @click="getToken()"
                            class="px-4 py-2 font-bold text-sm bg-cyan-500 rounded-full shadow-sm`">
                            Click Here to generate a login token
                        </button>
                        <br>
                        <x-code-block></x-code-block>
                        <br>
                        <h1>What is a token?</h1>
                        You can message the bot the token to log in. It's usually `/login` or `.login` depending on your
                        platform.<br>
                        <br>
                        <code class="bg-slate-600 text-slate-100">/login</code>
                        and enter <x-code-block></x-code-block>
                        <br>
                        or
                        <br>
                        <code class="bg-slate-600 text-slate-100">
                            .login <x-code-block></x-code-block>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

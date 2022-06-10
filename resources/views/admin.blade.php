<form method="POST" action="{{ route('token.create') }}">
    @csrf
    <input name="token_name" type="text" placeholder="Token Name">
    <input type="submit">
</form>

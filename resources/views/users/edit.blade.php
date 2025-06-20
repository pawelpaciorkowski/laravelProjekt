<x-app-layout>
    <x-slot name="header">
        <h2>Edytuj rolę: {{ $user->name }}</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')

            <label for="role">Rola:</label>
            <select name="role" id="role" class="block mt-1">
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Użytkownik</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
            </select>

            <button type="submit" class="mt-4 btn btn-primary">Zapisz</button>
        </form>
    </div>
</x-app-layout>
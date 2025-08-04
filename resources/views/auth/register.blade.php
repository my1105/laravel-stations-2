<x-guest-layout>
    <form method="POST" action="/register">
        @csrf

        <div>
            <label for="name">Name</label>
            <input id="name" name="name" type="text" required autofocus>
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required>
        </div>

        <div>
            <button type="submit">Register</button>
        </div>
    </form>
</x-guest-layout>

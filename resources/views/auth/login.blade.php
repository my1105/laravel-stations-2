<x-guest-layout>
    <form method="POST" action="/login">
        @csrf

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required autofocus>
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
        </div>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</x-guest-layout>

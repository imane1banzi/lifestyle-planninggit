<form action="{{ route('lifestyle.store') }}" method="POST">
    @csrf <!-- This generates a CSRF token required for POST requests in Laravel -->
    <label for="name">Profile Name:</label>
    <input type="text" id="name" name="name" required>
    <button type="submit">Create Profile</button>
</form>
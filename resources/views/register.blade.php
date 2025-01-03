<!-- resources/views/register.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h1>Registration Form</h1>

    <form action="{{ route('register.store') }}" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required value="{{ old('name') }}">

        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="{{ old('email') }}">

        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <br><br>

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>

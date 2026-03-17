<!DOCTYPE html>
<html>
<head>
    <title>Add Admin</title>
</head>
<body>

<h2>Add New Admin</h2>

<form method="POST" action="{{ route('admins.store') }}">
    @csrf

    <div>
        <label>Name</label><br>
        <input type="text" name="name" required>
    </div>

    <div>
        <label>Email</label><br>
        <input type="email" name="email" required>
    </div>

    <div>
        <label>Password</label><br>
        <input type="password" name="password" required>
    </div>

    <button type="submit">Create Admin</button>
</form>

</body>
</html>

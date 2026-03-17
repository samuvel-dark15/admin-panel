<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f7fb;
        }

        header {
            background: linear-gradient(90deg, #11998e, #38ef7d);
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 22px;
        }

        .container {
            padding: 20px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            text-align: center;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }

        .card h3 {
            margin: 0;
            color: #333;
        }

        .card p {
            color: #777;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: linear-gradient(90deg, #11998e, #38ef7d);
            color: white;
            border-radius: 25px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .logout {
            display: block;
            margin: 30px auto;
            width: 150px;
            text-align: center;
            background: #ff4b5c;
            padding: 10px;
            border-radius: 25px;
            color: white;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            header {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

<header>
    🧑‍💼 Admin Dashboard  
    <div style="font-size:14px;">Welcome, {{ auth()->user()->name }}</div>
</header>

<div class="container">
    <div class="cards">

       <div class="card">
    <h3>View Users</h3>
    <p>See all registered users</p>
    <a href="{{ route('admins.index') }}" class="btn">Open</a>
</div>

<div class="card">
    <h3>Remove Users</h3>
    <p>Delete normal users</p>
    <a href="{{ route('admins.index') }}" class="btn">Open</a>
</div>

    </div>

    <a href="/logout" class="logout">Logout</a>
</div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Add Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Segoe UI, sans-serif;
            background: #f4f7fb;
            padding: 30px;
        }

        .card {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
        }

        h2 {
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 18px;
            font-size: 15px;
        }

        textarea {
            min-height: 140px;
            resize: vertical;
        }

        button {
            padding: 14px 28px;
            border-radius: 30px;
            border: none;
            background: linear-gradient(90deg,#2575fc,#6a11cb);
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="card">

    <h2>Add Blog Field</h2>

<form method="POST" action="{{ route('blog-fields.store') }}">
    @csrf

    <div>
        <label>Field Name</label>
        <input type="text" name="name" required>
    </div>

    <div>
        <label>Label</label>
        <input type="text" name="label" required>
    </div>

    <div>
        <label>Type</label>
        <select name="type" required>
            <option value="text">Text</option>
            <option value="textarea">Textarea</option>
            <option value="file">Image</option>
        </select>
    </div>

    <div>
        <label>Order</label>
        <input type="number" name="sort_order" value="0">
    </div>

    <div>
        <label>
            <input type="checkbox" name="nullable"> Nullable
        </label>
    </div>

    <button type="submit">Save Field</button>
</form>

</div>

</body>
</html>

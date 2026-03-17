<!DOCTYPE html>
<html>
<head>
    <title>Blog Fields</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Segoe UI, sans-serif;
            background: #f4f7fb;
            padding: 30px;
        }

        .card {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        .actions {
            margin-bottom: 20px;
            text-align: right;
        }

        .actions a {
            padding: 10px 18px;
            border-radius: 25px;
            background: linear-gradient(90deg,#2575fc,#6a11cb);
            color: white;
            text-decoration: none;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f1f3f8;
            font-weight: 600;
        }

        tr:hover {
            background: #fafafa;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 13px;
            background: #e0e7ff;
            color: #3730a3;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #888;
        }
    </style>
</head>

<body>

<div class="card">
@extends('superadmin.layout')

    <h2>Blog Fields</h2>

    <div class="actions">
        <a href="{{ route('blog-fields.create') }}">+ Add New Field</a>
    </div>

    <table>
        <tr>
            <th>Order</th>
            <th>Name</th>
            <th>Label</th>
            <th>Type</th>
        </tr>

        @forelse($fields as $field)
            <tr>
                <td>{{ $field->sort_order }}</td>
                <td>{{ $field->name }}</td>
                <td>{{ $field->label }}</td>
                <td>
                    <span class="badge">{{ ucfirst($field->type) }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="empty">
                    No blog fields created yet.
                </td>
            </tr>
        @endforelse

    </table>

</div>

</body>
</html>

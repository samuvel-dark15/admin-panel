<!DOCTYPE html>
<html>
<head>
    <title>Add Blog</title>

    <style>
        body {
            font-family: Segoe UI, sans-serif;
            background: #f4f6fb;
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

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
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
@extends('superadmin.layout')

@section('title', 'Create Blog')

@section('content')
<div class="card">
    <h2>Create Blog</h2>

    <form method="POST"
          action="{{ route('blogs.store') }}"
          enctype="multipart/form-data">
        @csrf

        @foreach($fields as $field)
            <div style="margin-bottom:15px;">
                <label>{{ $field->label }}</label>

                @if($field->type === 'text')
                    <input type="text"
                           name="field_{{ $field->id }}"
                           {{ $field->nullable ? '' : 'required' }}>

                @elseif($field->type === 'textarea')
                    <textarea
                        name="field_{{ $field->id }}"
                        {{ $field->nullable ? '' : 'required' }}></textarea>

                @elseif($field->type === 'file')
                    <input type="file"
                           name="field_{{ $field->id }}"
                           {{ $field->nullable ? '' : 'required' }}>
                @endif
            </div>
        @endforeach

        <button class="btn btn-primary">Save Blog</button>
    </form>
</div>
@endsection

</body>
</html>

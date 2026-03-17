<!DOCTYPE html>
<html>
<head>
    <title>Edit Blog</title>
</head>
<body>

@extends('superadmin.layout')

@section('title', 'Edit Blog')

@section('content')
<div class="card">
    <h2>Edit Blog</h2>

    <form method="POST"
          action="{{ route('blogs.update', $blog) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @foreach($fields as $field)
            @php
                $saved = $values[$field->id]->value ?? '';
            @endphp

            <div style="margin-bottom:15px;">
                <label>{{ $field->label }}</label>

                @if($field->type === 'text')
                    <input type="text"
                           name="field_{{ $field->id }}"
                           value="{{ $saved }}">

                @elseif($field->type === 'textarea')
                    <textarea name="field_{{ $field->id }}">{{ $saved }}</textarea>

                @elseif($field->type === 'file')
                    @if($saved)
                        <img src="{{ asset('storage/'.$saved) }}"
                             style="max-width:120px;display:block;margin-bottom:10px;">
                    @endif
                    <input type="file" name="field_{{ $field->id }}">
                @endif
            </div>
        @endforeach

        <button class="btn btn-primary">Update Blog</button>
    </form>
</div>
@endsection

</body>
</html>

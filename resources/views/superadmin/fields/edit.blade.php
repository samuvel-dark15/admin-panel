@extends('superadmin.layout')

@section('title', 'Edit Field')

@section('content')

<style>
    .card {
        background: white;
        max-width: 650px;
        margin: 40px auto;
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0 10px 25px rgba(0,0,0,.12);
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }

    input, select {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 15px;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        margin-top: 25px;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 25px;
        border-radius: 25px;
        border: none;
        cursor: pointer;
        font-size: 15px;
        text-decoration: none;
        text-align: center;
    }

    .btn-back {
        background: linear-gradient(90deg,#2575fc,#6a11cb);
        color: white;
    }

    .btn-save {
        background: linear-gradient(90deg,#28a745,#20c997);
        color: white;
    }
</style>


<div class="card">

    <h2>Edit Field</h2>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div style="color:red; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST"
          action="{{ route('fields.update', $field->id) }}">

        @csrf
        @method('PUT')


        {{-- Field Name --}}
        <div class="form-group">
            <label>Field Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $field->name) }}"
                   required>
        </div>


        {{-- Label --}}
        <div class="form-group">
            <label>Label</label>
            <input type="text"
                   name="label"
                   value="{{ old('label', $field->label) }}"
                   required>
        </div>


        {{-- Module --}}
        <div class="form-group">
            <label>Module</label>

            <select name="module" required>
                <option value="employee"
                    {{ $field->module=='employee' ? 'selected' : '' }}>
                    Employee
                </option>

                <option value="blog"
                    {{ $field->module=='blog' ? 'selected' : '' }}>
                    Blog
                </option>
            </select>
        </div>


        {{-- Type --}}
        <div class="form-group">
            <label>Type</label>

            <select name="type" required>

                <option value="text"
                    {{ $field->type=='text'?'selected':'' }}>
                    Text
                </option>

                <option value="number"
                    {{ $field->type=='number'?'selected':'' }}>
                    Number
                </option>

                <option value="select"
                    {{ $field->type=='select'?'selected':'' }}>
                    Select
                </option>

                <option value="textarea"
                    {{ $field->type=='textarea'?'selected':'' }}>
                    Textarea
                </option>

            </select>
        </div>


        {{-- Length --}}
        <div class="form-group">
            <label>Length</label>
            <input type="number"
                   name="length"
                   value="{{ old('length', $field->length) }}">
        </div>


        {{-- Placeholder --}}
        <div class="form-group">
            <label>Placeholder</label>
            <input type="text"
                   name="placeholder"
                   value="{{ old('placeholder', $field->placeholder) }}">
        </div>


        {{-- Options --}}
        <div class="form-group">
            <label>Options (Comma Separated)</label>
            <input type="text"
                   name="options"
                   value="{{ old('options', $field->options) }}">
        </div>


        {{-- Sort Order --}}
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number"
                   name="sort_order"
                   value="{{ old('sort_order', $field->sort_order) }}">
        </div>


        {{-- Nullable --}}
        <div class="form-group">
            <label>
                <input type="checkbox"
                       name="nullable"
                       value="1"
                       {{ $field->nullable ? 'checked' : '' }}>
                Nullable
            </label>
        </div>


        {{-- Buttons --}}
        <div class="actions">

            <a href="{{ route('fields.index') }}"
               class="btn btn-back">
                ⬅ Back
            </a>

            <button type="submit"
                    class="btn btn-save">
                💾 Update Field
            </button>

        </div>

    </form>

</div>

@endsection

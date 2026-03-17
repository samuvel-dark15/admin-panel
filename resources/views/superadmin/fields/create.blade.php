@extends('superadmin.layout')

@section('title','DB Field Creator')

@section('content')

<style>

body{
    background:#f4f7fb;
}

/* ===== CARD ===== */
.field-card{
    background:#fff;
    max-width:1100px;
    margin:30px auto;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

/* ===== HEADER ===== */
.field-header{
    text-align:center;
    margin-bottom:25px;
}

.field-header h2{
    margin:0;
    font-size:26px;
}

/* ===== FORM GRID ===== */
.field-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:18px;
}

/* FULL WIDTH */
.full{
    grid-column:1 / -1;
}

/* ===== INPUTS ===== */
.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-weight:600;
    margin-bottom:6px;
    color:#374151;
}

.form-group input,
.form-group select{
    padding:11px 14px;
    border-radius:10px;
    border:1px solid #d1d5db;
    font-size:14px;
}

.form-group input:focus,
.form-group select:focus{
    outline:none;
    border-color:#6366f1;
    box-shadow:0 0 0 2px rgba(99,102,241,.15);
}

/* ===== CHECKBOX ===== */
.check-group{
    display:flex;
    align-items:center;
    gap:10px;
    font-weight:600;
}

/* ===== BUTTON ===== */
.btn-add{
    background:linear-gradient(90deg,#6366f1,#4f46e5);
    color:#fff;
    border:none;
    padding:12px 26px;
    border-radius:25px;
    font-size:15px;
    cursor:pointer;
    box-shadow:0 6px 15px rgba(0,0,0,.15);
    transition:.25s;
}

.btn-add:hover{
    transform:translateY(-2px);
}

/* ===== LIST ===== */
.field-row{
    background:#f9fafb;
    padding:12px 15px;
    border-radius:10px;
    margin-bottom:8px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 3px 8px rgba(0,0,0,.08);
}

/* ===== MOBILE ===== */
@media(max-width:768px){

    .field-card{
        margin:15px;
        padding:22px;
    }

    .field-grid{
        grid-template-columns:1fr;
    }

    .btn-add{
        width:100%;
    }
}

</style>


<div class="field-card">

    {{-- HEADER --}}
    <div class="field-header">
        <h2>🛠 DB Field Creator</h2>
        <p style="color:#6b7280;margin-top:5px;">
            Create and manage dynamic fields
        </p>
    </div>


    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:10px;border-radius:10px;margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif


    {{-- ERROR MESSAGE --}}
    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:10px;border-radius:10px;margin-bottom:15px;">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- FORM --}}
    <form method="POST" action="{{ route('fields.store') }}">
        @csrf

        <div class="field-grid">

            {{-- NAME --}}
            <div class="form-group">
                <label>Field Name</label>
                <input type="text"
                       name="name"
                       placeholder="emp_name"
                       value="{{ old('name') }}"
                       required>
            </div>

            {{-- LABEL --}}
            <div class="form-group">
                <label>Label</label>
                <input type="text"
                       name="label"
                       placeholder="Employee Name"
                       value="{{ old('label') }}"
                       required>
            </div>

            {{-- MODULE --}}
            <div class="form-group">
                <label>Module</label>
                <select name="module" required>
                    <option value="">-- Select Module --</option>
                    <option value="employee">Employee</option>
                    <option value="blog">Blog</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            {{-- TYPE --}}
            <div class="form-group">
                <label>Field Type</label>
                <select name="type" required>
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="email">Email</option>
                    <option value="textarea">Textarea</option>
                    <option value="file">Image</option>
                    <option value="select">Select</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="radio">Radio</option>
                </select>
            </div>

            {{-- LENGTH --}}
            <div class="form-group">
                <label>Length</label>
                <input type="number"
                       name="length"
                       placeholder="255"
                       value="{{ old('length') }}">
            </div>


            {{-- DEFAULT --}}
            <div class="form-group">
                <label>Default Value</label>
                <input type="text"
                       name="default_value"
                       value="{{ old('default_value') }}">
            </div>


            {{-- PLACEHOLDER --}}
            <div class="form-group">
                <label>Placeholder</label>
                <input type="text"
                       name="placeholder"
                       value="{{ old('placeholder') }}">
            </div>


            {{-- OPTIONS --}}
            <div class="form-group">
                <label>Options</label>
                <input type="text"
                       name="options"
                       placeholder="Admin,Staff,HR"
                       value="{{ old('options') }}">
            </div>


            {{-- ORDER --}}
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number"
                       name="sort_order"
                       value="{{ old('sort_order') }}">
            </div>


            {{-- NULLABLE --}}
            <div class="form-group full">
                <div class="check-group">
                    <input type="checkbox" name="nullable" value="1">
                    <label>Allow Empty (Nullable)</label>
                </div>
            </div>


            {{-- BUTTON --}}
            <div class="form-group full" style="text-align:center;">

                <button type="submit" class="btn-add">
                    ➕ Add Field
                </button>

            </div>


        </div>

    </form>


    {{-- FIELD LIST --}}
    <hr style="margin:35px 0;">


    <h3 style="margin-bottom:15px;">📋 Existing Fields</h3>


    @forelse($fields as $f)

        <div class="field-row">

            <div>
                <strong>{{ $f->label }}</strong>
                <br>
                <small style="color:#6b7280;">
                    {{ $f->name }} ({{ $f->type }})
                </small>
            </div>

            <div>
                <small style="color:#4f46e5;">
                    {{ ucfirst($f->module) }}
                </small>
            </div>

        </div>

    @empty

        <p style="color:#6b7280;">No fields created yet.</p>

    @endforelse


</div>

@endsection

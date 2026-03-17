@extends('superadmin.layout')

@section('title','Manage Fields')

@section('content')

<style>
/* Page Container */
.fields-container{
    max-width:1200px;
    margin:auto;
    padding:20px;
}

/* Card */
.card-box{
    background:#fff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    margin-bottom:25px;
}

/* Title */
.page-title{
    font-size:26px;
    font-weight:700;
    margin-bottom:20px;
}

/* Form Grid */
.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
}

/* Inputs */
.form-control{
    width:100%;
    padding:10px 14px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:14px;
}

.form-control:focus{
    outline:none;
    border-color:#4f46e5;
}

/* Button */
.btn-main{
    background:linear-gradient(90deg,#6366f1,#4f46e5);
    color:white;
    border:none;
    padding:10px 22px;
    border-radius:25px;
    cursor:pointer;
    font-weight:600;
}

.btn-main:hover{
    opacity:.9;
}

/* Table */
.table-wrap{
    overflow-x:auto;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th{
    background:#f1f5f9;
    padding:12px;
    text-align:left;
    font-weight:600;
}

.table td{
    padding:12px;
    border-bottom:1px solid #eee;
}

/* Badge */
.badge{
    background:#e0e7ff;
    color:#3730a3;
    padding:4px 12px;
    border-radius:20px;
    font-size:12px;
}

/* Actions */
.action-btn{
    text-decoration:none;
    margin-right:10px;
    font-size:14px;
}

.edit-btn{ color:#2563eb; }
.del-btn{ color:#dc2626; }

/* Mobile */
@media(max-width:600px){
    .page-title{
        font-size:22px;
        text-align:center;
    }
}
</style>

<div class="fields-container">

    {{-- Success Message --}}
    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:10px;border-radius:10px;margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif


    {{-- ADD FIELD --}}
    <div class="card-box">

        <h2 class="page-title">➕ Add New Field</h2>

        <form method="POST" action="{{ route('fields.store') }}">
            @csrf

            <div class="form-grid">

                <input class="form-control"
                       name="name"
                       placeholder="Field Name (emp_name)"
                       required>

                <input class="form-control"
                       name="label"
                       placeholder="Label (Employee Name)"
                       required>

                <select class="form-control"
                        name="module"
                        required>
                    <option value="">-- Select Module --</option>
                    <option value="employee">Employee</option>
                    <option value="blog">Blog</option>
                    <option value="admin">Admin</option>
                </select>

                <select class="form-control"
                        name="type">
                    <option value="varchar">Text</option>
                    <option value="int">Number</option>
                    <option value="email">Email</option>
                    <option value="text">Textarea</option>
                    <option value="file">Image</option>
                    <option value="select">Select</option>
                </select>

                <input class="form-control"
                       name="length"
                       placeholder="Length (255)">

                <input class="form-control"
                       name="default"
                       placeholder="Default Value">

                <input class="form-control"
                       name="placeholder"
                       placeholder="Placeholder">

                <input class="form-control"
                       name="options"
                       placeholder="Options (A,B,C)">

                <input class="form-control"
                       name="sort_order"
                       placeholder="Order (1,2,3)">
            </div>

            <br>

            <label>
                <input type="checkbox" name="nullable">
                Nullable
            </label>

            <br><br>

            <button class="btn-main">
                + Add Field
            </button>

        </form>

    </div>


    {{-- FIELD LIST --}}
    <div class="card-box">

        <h2 class="page-title">📋 Existing Fields</h2>

        <div class="table-wrap">

            <table class="table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Label</th>
                        <th>Name</th>
                        <th>Module</th>
                        <th>Type</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($fields as $key => $f)

                    <tr>

                        <td>{{ $key+1 }}</td>

                        <td>{{ $f->label }}</td>

                        <td>
                            <span class="badge">
                                {{ $f->name }}
                            </span>
                        </td>

                        <td>{{ ucfirst($f->module) }}</td>

                        <td>{{ $f->type }}</td>

                        <td>{{ $f->sort_order }}</td>

                        <td>

                            <a href="{{ route('fields.edit',$f->id) }}"
                               class="action-btn edit-btn">
                               Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('fields.destroy',$f->id) }}"
                                  style="display:inline">

                                @csrf
                                @method('DELETE')

                                <button class="action-btn del-btn"
                                        onclick="return confirm('Delete this field?')"
                                        style="border:none;background:none;cursor:pointer;">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

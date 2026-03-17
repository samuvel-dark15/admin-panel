@extends('superadmin.layout')

@section('title','Edit Employee')

@section('content')

<style>
/* ========== CARD ========== */
.edit-card{
    max-width:750px;
    margin:40px auto;
    background:#fff;
    padding:30px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
}

/* ========== HEADINGS ========== */
.edit-card h2{
    text-align:center;
    margin-bottom:25px;
}

.edit-card h4{
    margin:20px 0 10px;
    color:#2563eb;
    border-bottom:1px solid #e5e7eb;
    padding-bottom:6px;
}

/* ========== FORM GRID ========== */
.form-group{
    margin-bottom:15px;
}

.form-group label{
    font-weight:600;
    display:block;
    margin-bottom:6px;
}

.form-control{
    width:100%;
    padding:10px 12px;
    border:1px solid #d1d5db;
    border-radius:8px;
    font-size:15px;
}

.form-control:focus{
    border-color:#2563eb;
    outline:none;
}

/* ========== GRID FOR DESKTOP ========== */
.form-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

/* ========== BUTTONS ========== */
.btn-row{
    display:flex;
    justify-content:space-between;
    margin-top:25px;
    gap:10px;
    flex-wrap:wrap;
}

.btn{
    padding:10px 22px;
    border-radius:20px;
    border:none;
    cursor:pointer;
    font-size:14px;
    text-decoration:none;
    text-align:center;
}

/* Save */
.btn-save{
    background:linear-gradient(90deg,#22c55e,#16a34a);
    color:#fff;
}

/* Back */
.btn-back{
    background:linear-gradient(90deg,#3b82f6,#2563eb);
    color:#fff;
}

/* ========== ERROR BOX ========== */
.error-box{
    background:#fee2e2;
    color:#b91c1c;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
}

/* ========== MOBILE ========== */
@media(max-width:640px){

    .edit-card{
        margin:15px;
        padding:20px;
    }

    .form-row{
        grid-template-columns:1fr;
    }

    .btn{
        width:100%;
    }

    .btn-row{
        flex-direction:column;
    }
}
</style>


<div class="edit-card">

    <h2>✏️ Edit Employee</h2>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST"
          action="{{ route('employees.update', $employee->id) }}">

        @csrf
        @method('PUT')

        {{-- ================= LOGIN ================= --}}
        <h4>Login Details</h4>

        <div class="form-row">

            <div class="form-group">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email',$employee->email) }}"
                       required>
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Optional">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Confirm password">
            </div>

        </div>


        {{-- ================= DETAILS ================= --}}
        <h4>Employee Details</h4>

        <div class="form-row">

            @foreach ($fields as $field)

                <div class="form-group">

                    <label>{{ $field->label }}</label>

                    {{-- SELECT --}}
                    @if($field->type === 'select')

                        <select name="{{ $field->name }}"
                                class="form-control"
                                {{ $field->nullable ? '' : 'required' }}>

                            <option value="">Select {{ $field->label }}</option>

                            @foreach(explode(',', $field->options) as $opt)

                                <option value="{{ trim($opt) }}"
                                    {{ (old($field->name,$data[$field->name] ?? '') == trim($opt)) ? 'selected' : '' }}>
                                    {{ trim($opt) }}
                                </option>

                            @endforeach

                        </select>


                    {{-- NUMBER --}}
                    @elseif($field->type === 'int')

                        <input type="number"
                               name="{{ $field->name }}"
                               class="form-control"
                               value="{{ old($field->name,$data[$field->name] ?? '') }}"
                               placeholder="{{ $field->placeholder }}">


                    {{-- TEXT --}}
                    @else

                        <input type="text"
                               name="{{ $field->name }}"
                               class="form-control"
                               value="{{ old($field->name,$data[$field->name] ?? '') }}"
                               placeholder="{{ $field->placeholder }}">

                    @endif

                </div>

            @endforeach

        </div>


        {{-- ================= BUTTONS ================= --}}
        <div class="btn-row">

            <a href="{{ route('employees.index') }}"
               class="btn btn-back">
                ⬅ Back
            </a>

            <button type="submit"
                    class="btn btn-save">
                💾 Update Employee
            </button>

        </div>

    </form>

</div>

@endsection

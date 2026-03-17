@extends('superadmin.layout')

@section('title', 'Add Employee')

@section('content')

<div class="card" style="max-width:700px; margin:auto; padding:20px;">

    <h2>Add Employee</h2>

    {{-- ================= ERRORS ================= --}}
    @if ($errors->any())
        <div style="color:red; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{ route('employees.store') }}">
        @csrf


        {{-- ================= LOGIN DETAILS ================= --}}
        <h4>Login Details</h4>

        <div style="margin-bottom:10px;">
            <input
                type="email"
                name="email"
                placeholder="Email"
                value="{{ old('email') }}"
                required
                style="width:100%; padding:8px;"
            >
        </div>

        <div style="margin-bottom:10px;">
            <input
                type="password"
                name="password"
                placeholder="Password"
                required
                style="width:100%; padding:8px;"
            >
        </div>

        <div style="margin-bottom:15px;">
            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm Password"
                required
                style="width:100%; padding:8px;"
            >
        </div>


        <hr>


        {{-- ================= EMPLOYEE DETAILS ================= --}}
        <h4>Employee Details</h4>


        @foreach ($fields as $field)

            <div style="margin-bottom:15px;">

                <label style="display:block; font-weight:bold; margin-bottom:5px;">
                    {{ $field->label }}
                </label>


                {{-- TEXT --}}
                @if ($field->type == 'text')

                    <input
                        type="text"
                        name="{{ $field->name }}"
                        placeholder="{{ $field->placeholder ?? $field->label }}"
                        value="{{ old($field->name) }}"
                        {{ $field->nullable ? '' : 'required' }}
                        style="width:100%; padding:8px;"
                    >


                {{-- NUMBER --}}
                @elseif ($field->type == 'int' || $field->type == 'number')

                    <input
                        type="number"
                        name="{{ $field->name }}"
                        placeholder="{{ $field->placeholder ?? $field->label }}"
                        value="{{ old($field->name) }}"
                        {{ $field->nullable ? '' : 'required' }}
                        style="width:100%; padding:8px;"
                    >


                {{-- TEXTAREA --}}
                @elseif ($field->type == 'textarea')

                    <textarea
                        name="{{ $field->name }}"
                        placeholder="{{ $field->placeholder ?? $field->label }}"
                        {{ $field->nullable ? '' : 'required' }}
                        style="width:100%; padding:8px;"
                    >{{ old($field->name) }}</textarea>


                {{-- SELECT (DROPDOWN) --}}
                @elseif ($field->type == 'select')

                    <select
                        name="{{ $field->name }}"
                        {{ $field->nullable ? '' : 'required' }}
                        style="width:100%; padding:8px;"
                    >

                        <option value="">
                            -- Select {{ $field->label }} --
                        </option>

                        @foreach (explode(',', $field->options) as $option)

                            <option
                                value="{{ trim($option) }}"
                                {{ old($field->name) == trim($option) ? 'selected' : '' }}
                            >
                                {{ trim($option) }}
                            </option>

                        @endforeach

                    </select>

                @endif

            </div>

        @endforeach


        {{-- ================= SUBMIT ================= --}}
        <button
            type="submit"
            style="padding:10px 20px; background:#4f46e5; color:white; border:none; border-radius:5px;"
        >
            Save Employee
        </button>

    </form>

</div>

@endsection

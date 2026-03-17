@extends('superadmin.layout')

@section('title','Employees')

@section('content')

<div class="card">

    <h2>Employees</h2>

    <a href="{{ route('employees.create') }}" class="btn btn-primary">
        + Add Employee
    </a>

    <table width="100%" cellpadding="10" cellspacing="0" style="margin-top:15px;">

        <thead style="background:#f1f5f9;">
            <tr>
                <th>Name</th>
                <th>Email</th>

                {{-- Dynamic fields --}}
                @foreach ($fields as $field)
                    <th>{{ $field->label }}</th>
                @endforeach

                {{-- Action column --}}
                <th>Action</th>
            </tr>
        </thead>


        <tbody>

            @foreach ($employees as $employee)

                <tr>

                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>

                    {{-- Dynamic values --}}
                    @foreach ($fields as $field)

                        <td>
                            {{ $employee->dynamic[$field->name] ?? '-' }}
                        </td>

                    @endforeach


                    {{-- Edit Button --}}
                    <td>
                        <a href="{{ route('employees.edit', $employee->id) }}"
                           class="btn btn-sm btn-primary">

                            Edit

                        </a>
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection

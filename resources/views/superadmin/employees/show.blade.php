@extends('superadmin.layout')

@section('title','Employee Details')

@section('content')

<div class="card">
    <h2>Employee Details</h2>

    <table width="100%">
        @foreach($values as $v)
            <tr>
                <td><strong>{{ $v->field->label }}</strong></td>
                <td>{{ $v->value }}</td>
            </tr>
        @endforeach
    </table>
</div>

@endsection

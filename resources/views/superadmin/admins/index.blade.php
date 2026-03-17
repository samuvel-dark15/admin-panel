@extends('superadmin.layout')

@section('title', 'Admins')

@section('content')

<div class="card">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h2>Admins</h2>

        <a href="{{ route('admins.create') }}" class="btn btn-primary">
            + Add Admin
        </a>
    </div>

    <table width="100%" cellpadding="12" cellspacing="0">
        <thead style="background:#f1f5f9;">
            <tr>
                <th align="left">Name</th>
                <th align="left">Email</th>
                <th align="left">Status</th>
            </tr>
        </thead>

        <tbody>
        @forelse($admins as $admin)
            <tr style="border-bottom:1px solid #e5e7eb;">
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ ucfirst($admin->status) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="text-align:center;padding:20px;">
                    No admins found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection

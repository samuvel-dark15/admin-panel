@extends('superadmin.layout')

@section('title', 'Dashboard')

@section('content')

<div class="card">
    <h2>👑 Super Admin Dashboard</h2>
    <p style="color:#6b7280;margin-top:6px;">
        Welcome, {{ auth()->user()->name ?? 'Super Admin' }}
    </p>
</div>

<div style="
    margin-top:30px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
">

    <div class="card">
        <h3>Manage Admins</h3>
        <p>Add, edit, and manage admin users</p>
        <a href="{{ route('admins.index') }}" class="btn btn-primary">Open</a>
    </div>

    <div class="card">
        <h3>Blog Fields</h3>
        <p>Manage dynamic blog fields</p>
        <a href="{{ route('blog-fields.index') }}" class="btn btn-primary">Open</a>
    </div>

    <div class="card">
        <h3>Blogs</h3>
        <p>Create and manage blog posts</p>
        <a href="{{ route('blogs.index') }}" class="btn btn-primary">Open</a>
    </div>

</div>

@endsection

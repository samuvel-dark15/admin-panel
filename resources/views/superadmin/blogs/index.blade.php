@extends('superadmin.layout')

@section('title','Blogs')

@section('content')

<style>
/* ===== CARD ===== */
.blog-card{
    background:#fff;
    max-width:1100px;
    margin:40px auto;
    padding:25px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
}

/* ===== HEADER ===== */
.blog-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    flex-wrap:wrap;
    gap:12px;
}

.blog-header h2{
    margin:0;
}

/* ===== ADD BUTTON ===== */
.btn-add{
    background:linear-gradient(90deg,#6366f1,#4f46e5);
    color:#fff;
    padding:10px 20px;
    border-radius:25px;
    text-decoration:none;
    font-size:14px;
    box-shadow:0 5px 12px rgba(0,0,0,.15);
}

/* ===== TABLE ===== */
.table-wrap{
    width:100%;
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:650px;
}

thead{
    background:#f1f5f9;
}

th,td{
    padding:12px 14px;
    text-align:left;
    font-size:14px;
}

th{
    font-weight:600;
    color:#334155;
}

tbody tr{
    border-bottom:1px solid #e5e7eb;
}

tbody tr:hover{
    background:#f9fafb;
}

/* ===== STATUS ===== */
.badge{
    padding:4px 12px;
    border-radius:15px;
    font-size:12px;
    font-weight:600;
}

.badge-draft{
    background:#64748b;
    color:#fff;
}

.badge-published{
    background:#22c55e;
    color:#fff;
}

/* ===== ACTIONS ===== */
.actions a{
    margin-right:10px;
    font-size:14px;
    text-decoration:none;
}

.actions .view{ color:#2563eb; }
.actions .edit{ color:#059669; }
.actions .delete{ color:#dc2626; }

/* ===== MOBILE ===== */
@media(max-width:640px){

    .blog-card{
        margin:15px;
        padding:20px;
    }

    .btn-add{
        width:100%;
        text-align:center;
    }

    .blog-header{
        flex-direction:column;
        align-items:stretch;
    }
}
</style>


<div class="blog-card">

    {{-- HEADER --}}
    <div class="blog-header">

        <h2>📝 Blogs</h2>

        <a href="{{ route('blogs.create') }}"
           class="btn-add">
            + Add Blog
        </a>

    </div>


    {{-- TABLE --}}
    <div class="table-wrap">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($blogs as $blog)

                    <tr>

                        <td>#{{ $blog->id }}</td>

                        <td>
                            {{ $blog->created_at->format('d M Y') }}
                        </td>

                        <td>
                            @if($blog->status == 'published')
                                <span class="badge badge-published">
                                    Published
                                </span>
                            @else
                                <span class="badge badge-draft">
                                    Draft
                                </span>
                            @endif
                        </td>

                        <td class="actions">

                            <a href="{{ route('blogs.show',$blog->id) }}"
                               class="view">
                                View
                            </a>

                            <a href="{{ route('blogs.edit',$blog->id) }}"
                               class="edit">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('blogs.destroy',$blog->id) }}"
                                  style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Delete this blog?')"
                                        style="background:none;border:none;color:#dc2626;cursor:pointer;">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" style="text-align:center;padding:20px;">
                            No blogs found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

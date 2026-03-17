<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogField;

class BlogFieldController extends Controller
{
    /**
     * Show all blog fields
     */
    public function index()
    {
        $fields = BlogField::orderBy('sort_order')->get();
        return view('superadmin.blog_fields.index', compact('fields'));
    }

    /**
     * Show add new blog field form
     */
    public function create()
    {
        return view('superadmin.blog_fields.create');
    }

    /**
     * Store a new blog field
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'label' => 'required|string',
            'type'  => 'required|string',
        ]);

        BlogField::create([
            'name'       => $request->name,
            'label'      => $request->label,
            'type'       => $request->type,
            'sort_order' => $request->sort_order ?? 0,
            'nullable'   => $request->has('nullable') ? 1 : 0,
        ]);

        return redirect()
            ->route('blog-fields.index')
            ->with('success', 'Blog field added successfully');
    }
}

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogField;
use App\Models\BlogValue;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * List all blogs (SuperAdmin)
     */
    public function index()
    {
        $blogs = Blog::latest()->get();

        return view('superadmin.blogs.index', compact('blogs'));
    }

    /**
     * Show create blog form (dynamic)
     */
    public function create()
{
    $fields = BlogField::orderBy('sort_order')->get();

    return view('superadmin.blogs.create', compact('fields'));
}

    /**
     * Store blog with dynamic fields
     */
    public function store(Request $request)
    {
        // 1️⃣ Create blog
        $blog = Blog::create([
            'created_by' => auth()->id(),
            'status'     => $request->status ?? 'draft',
        ]);

        // 2️⃣ Save dynamic field values
        $fields = BlogField::orderBy('sort_order')->get();

        foreach ($fields as $field) {

            $input = 'field_' . $field->id;

            // FILE
            if ($field->type === 'file' && $request->hasFile($input)) {

                $path = $request->file($input)
                    ->store('blogs', 'public');

                BlogValue::create([
                    'blog_id'       => $blog->id,
                    'blog_field_id' => $field->id,
                    'value'         => $path,
                ]);
            }

            // TEXT / TEXTAREA
            elseif ($request->filled($input)) {

                BlogValue::create([
                    'blog_id'       => $blog->id,
                    'blog_field_id' => $field->id,
                    'value'         => $request->input($input),
                ]);
            }
        }

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog created successfully');
    }

    /**
     * Show single blog (admin view)
     */
    public function show(Blog $blog)
    {
        $values = BlogValue::where('blog_id', $blog->id)
            ->with('blogField')
            ->get();

        return view('superadmin.blogs.show', compact('blog', 'values'));
    }

    /**
     * Edit blog (dynamic)
     */
    public function edit(Blog $blog)
    {
        $fields = BlogField::orderBy('sort_order')->get();

        $values = BlogValue::where('blog_id', $blog->id)
            ->get()
            ->keyBy('blog_field_id');

        return view(
            'superadmin.blogs.edit',
            compact('blog', 'fields', 'values')     
        );
    }

    /**
     * Update blog (dynamic)
     */
    public function update(Request $request, Blog $blog)
    {
        // Update status
        $blog->update([
            'status' => $request->status ?? $blog->status,
        ]);

        $fields = BlogField::all();

        foreach ($fields as $field) {

            $input = 'field_' . $field->id;

            $blogValue = BlogValue::firstOrNew([
                'blog_id'       => $blog->id,
                'blog_field_id' => $field->id,
            ]);

            // FILE
            if ($field->type === 'file' && $request->hasFile($input)) {

                $path = $request->file($input)
                    ->store('blogs', 'public');

                $blogValue->value = $path;
            }

            // TEXT / TEXTAREA
            elseif ($request->filled($input)) {
                $blogValue->value = $request->input($input);
            }

            $blogValue->save();
        }

        return redirect()
            ->route('blogs.show', $blog)
            ->with('success', 'Blog updated successfully');
    }

    /**
     * Delete blog
     */
    public function destroy(Blog $blog)
{
    // 1️⃣ Delete uploaded images from storage
    foreach ($blog->values as $value) {
        if ($value->field->type === 'file' && $value->value) {
            Storage::disk('public')->delete($value->value);
        }
    }

    // 2️⃣ Delete blog (blog_values auto deleted via cascade)
    $blog->delete();

    return redirect()
        ->route('blogs.index')
        ->with('success', 'Blog deleted successfully');
}

}

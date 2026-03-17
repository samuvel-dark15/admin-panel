<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::orderBy('sort_order')->get();
        return view('superadmin.fields.index', compact('fields'));
    }
     
    public function create()
{
    $fields = \App\Models\Field::orderBy('sort_order')->get();

    return view('superadmin.fields.create', compact('fields'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|regex:/^[a-z_]+$/|unique:fields,name',
            'label' => 'required|string|max:255',
            'type'  => 'required|string|max:50',
        ]);

      Field::create([
    'name' => $request->name,
    'label' => $request->label,
    'module' => $request->module, // ✅ IMPORTANT
    'type' => $request->type,
    'length' => $request->length,
    'default_value' => $request->default,
    'placeholder' => $request->placeholder,
    'options' => $request->options,
    'sort_order' => $request->sort_order,
    'nullable' => $request->has('nullable'),
]);

        return back()->with('success', 'Field added successfully');
    }

    public function edit(Field $field)
    {
        return view('superadmin.fields.edit', compact('field'));
    }

    public function update(Request $request, Field $field)
    {
        $request->validate([
            'name'  => 'required|regex:/^[a-z_]+$/|unique:fields,name,' . $field->id,
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,number,email,textarea,image,select,checkbox,radio',
        ]);

        if (in_array($request->type, ['select','radio','checkbox'])) {
    $request->validate([
        'options' => 'required'
    ]);
}

        $field->update([
            'name'          => $request->name,
            'label'         => $request->label,
            'type'          => $request->type,
            'length'        => $request->length,
            'default_value' => $request->default_value,
            'nullable'      => $request->has('nullable') ? 1 : 0,
            'placeholder'   => $request->placeholder,
            'options'       => $request->options,
            'sort_order'    => $request->sort_order ?? 0,
        ]);

        return redirect()->route('fields.index')
            ->with('success', 'Field updated successfully');
    }

    public function destroy(Field $field)
    {
        $field->delete();
        return back()->with('success', 'Field deleted');
    }
}

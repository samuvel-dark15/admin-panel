<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Field;
use App\Models\FieldValue;
use App\Models\FormValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // ✅ LIST EMPLOYEES
   public function index()
{
    $employees = User::where('role', 'employee')->get();
    $fields = Field::where('module', 'employee')->orderBy('sort_order')->get();

    foreach ($employees as $employee) {
        $dynamic = []; // ✅ TEMP ARRAY (THIS IS THE FIX)

        $values = FieldValue::where('user_id', $employee->id)->get();

        foreach ($fields as $field) {
            $dynamic[$field->name] =
                optional(
                    $values->firstWhere('field_id', $field->id)
                )->value ?? '-';
        }

        // ✅ attach safely to model
        $employee->dynamic = $dynamic;
    }

    return view('superadmin.employees.index', compact('employees', 'fields'));
}

    // ✅ SHOW CREATE FORM
    public function create()
    {
        $fields = Field::where('module', 'employee')
            ->orderBy('sort_order')
            ->get();

        return view('superadmin.employees.create', compact('fields'));
    }

    // ✅ STORE EMPLOYEE (YOUR CODE)
   public function store(Request $request)
{
    // 1️⃣ Validate login fields
    $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    // 2️⃣ Create employee user
    $employee = User::create([
        'name' => $request->name ?? 'Employee',
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'employee',
        'status' => 'active',
    ]);

    // 3️⃣ Get employee dynamic fields
    $fields = Field::where('module', 'employee')->get();

    // 4️⃣ Save dynamic values (THIS IS THE KEY FIX)
    foreach ($fields as $field) {
        if ($request->has($field->name)) {
            FieldValue::create([
                'user_id' => $employee->id,   // ✅ user_id (NOT employee_id)
                'field_id' => $field->id,
                'value' => $request->input($field->name),
            ]);
        }
    }

    return redirect()
        ->route('employees.index')
        ->with('success', 'Employee saved successfully');
}

public function edit($id)
{
    // Get employee
    $employee = User::findOrFail($id);

    // Get employee fields
    $fields = Field::where('module', 'employee')
                    ->orderBy('sort_order')
                    ->get();

    // Get saved values
    $values = FieldValue::where('user_id', $employee->id)->get();

    // Map values
    $data = [];

    foreach ($fields as $field) {
        $data[$field->name] = optional(
            $values->firstWhere('field_id', $field->id)
        )->value;
    }

    return view('superadmin.employees.edit', compact(
        'employee',
        'fields',
        'data'
    ));
}

public function update(Request $request, $id)
{
    $employee = User::findOrFail($id);

    // Validate
    $request->validate([
        'email' => 'required|email|unique:users,email,' . $employee->id,
    ]);

    // Update main user
    $employee->update([
        'name'  => $request->name ?? $employee->name,
        'email' => $request->email,
    ]);

    // Get fields
    $fields = Field::where('module', 'employee')->get();

    // Update dynamic values
    foreach ($fields as $field) {

        if ($request->has($field->name)) {

            FieldValue::updateOrCreate(
                [
                    'user_id'  => $employee->id,
                    'field_id'=> $field->id,
                ],
                [
                    'value' => $request->input($field->name),
                ]
            );
        }
    }

    return redirect()
        ->route('employees.index')
        ->with('success', 'Employee updated successfully');
}


}

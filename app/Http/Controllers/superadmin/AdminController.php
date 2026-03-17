<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%");
            });
        }

        $admins = $query->orderBy('created_at', 'desc')->get();

        return view('superadmin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('superadmin.admins.create');
    }

    // ===========================
    // STORE ADMIN (FIXED)
    // ===========================
    public function store(Request $request)
    {
        $schema = json_decode($request->schema, true) ?? [];

        // 1) Create columns dynamically (ALWAYS NULLABLE)
        Schema::table('users', function (Blueprint $table) use ($schema) {

            foreach ($schema as $col) {

                if (empty($col['name']) || Schema::hasColumn('users', $col['name'])) {
                    continue;
                }

                switch ($col['type'] ?? 'varchar') {
                    case 'int':       $column = $table->integer($col['name']); break;
                    case 'bigint':    $column = $table->bigInteger($col['name']); break;
                    case 'varchar':   $column = $table->string($col['name'], $col['length'] ?? 255); break;
                    case 'text':      $column = $table->text($col['name']); break;
                    case 'boolean':   $column = $table->boolean($col['name']); break;
                    case 'date':      $column = $table->date($col['name']); break;
                    case 'timestamp': $column = $table->timestamp($col['name']); break;
                    default:          $column = $table->string($col['name'], 255);
                }

                // 🔥 ALWAYS NULLABLE
                $column->nullable();

                if (!empty($col['index']) && $col['index'] === 'unique') {
                    $table->unique($col['name']);
                }

                if (!empty($col['index']) && $col['index'] === 'index') {
                    $table->index($col['name']);
                }
            }
        });

        // 2) Build data from ALL inputs
        $data = [];

        foreach ($request->except(['_token','schema']) as $key => $value) {

            if ($request->hasFile($key)) {

                $file = $request->file($key);
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/admins'), $filename);
                $data[$key] = 'uploads/admins/'.$filename;

            } elseif ($key === 'password' && $value) {

                $data[$key] = Hash::make($value);

            } else {

                $data[$key] = $value;
            }
        }

        // 🔥 CAPTURE MISSING NORMAL FORM INPUTS TOO  ✅ (YOUR REQUEST)
        foreach ($request->all() as $key => $value) {

            if (!array_key_exists($key, $data) && Schema::hasColumn('users', $key)) {

                if ($key === 'password' && $value) {
                    $data[$key] = Hash::make($value);
                } else {
                    $data[$key] = $value;
                }

            }

        }

        // 3) Merge first_name + last_name → name
        if (empty($data['name'])) {
            $first = $data['first_name'] ?? '';
            $last  = $data['last_name'] ?? '';

            if ($first || $last) {
                $data['name'] = trim($first.' '.$last);
            }
        }

        // 4) Mandatory fallback
        if (empty($data['name'])) {
            $data['name'] = 'Admin '.time();
        }

        if (empty($data['email'])) {
            return back()->withErrors('Email is required.');
        }

        if (empty($data['password'])) {
            return back()->withErrors('Password is required.');
        }

        // 5) Force admin identity
        $data['role']   = 'admin';
        $data['status'] = 'active';

        // 6) Force non-null defaults for NOT NULL columns
        $requiredCols = [
            'first_name',
            'last_name',
            'father_name',
            'mother_name'
        ];

        foreach ($requiredCols as $col) {
            if (Schema::hasColumn('users', $col) && (!isset($data[$col]) || $data[$col] === null)) {
                $data[$col] = '';
            }
        }

        // 7) Save admin
        User::create($data);

        return redirect()
            ->route('admins.index')
            ->with('success', 'Admin created successfully!');
    }

    public function show(User $admin)
    {
        return view('superadmin.admins.show', compact('admin'));
    }

    public function edit(User $admin)
    {
        return view('superadmin.admins.edit', compact('admin'));
    }

    // ===========================
    // UPDATE ADMIN
    // ===========================
   public function update(Request $request, User $admin)
{
    $data = $request->except(['_token','_method','photo','password']);

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/admins'), $filename);
        $data['photo'] = 'uploads/admins/'.$filename;
    }

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // Merge first_name + last_name → name
    if (empty($data['name'])) {
        $first = $data['first_name'] ?? $admin->first_name ?? '';
        $last  = $data['last_name'] ?? $admin->last_name ?? '';
        if ($first || $last) {
            $data['name'] = trim($first.' '.$last);
        }
    }

    // 🔥 Force non-null defaults for NOT NULL columns (CRASH FIX)
    $requiredCols = [
        'first_name',
        'last_name',
        'father_name',
        'mother_name'
    ];

    foreach ($requiredCols as $col) {
        if (Schema::hasColumn('users', $col) && (!isset($data[$col]) || $data[$col] === null)) {
            $data[$col] = '';
        }
    }

    $admin->update($data);

    return redirect()
        ->route('admins.show', $admin->id)
        ->with('success', 'Admin updated successfully!');
}

    public function destroy(User $admin)
    {
        if ($admin->photo && file_exists(public_path($admin->photo))) {
            unlink(public_path($admin->photo));
        }

        $admin->delete();

        return back()->with('success', 'Admin deleted successfully!');
    }

    public function toggleStatus(User $admin)
    {
        $admin->status = $admin->status === 'active' ? 'inactive' : 'active';
        $admin->save();

        return back()->with('success', 'Admin status updated!');
    }

    // ===========================
    // ADD COLUMN FROM EDIT PAGE
    // ===========================
    public function addColumn(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        $name     = trim($request->name);
        $type     = $request->type;
        $length   = $request->length ?: 255;
        $nullable = $request->nullable ?? false;

        if (Schema::hasColumn('users', $name)) {
            return back()->withErrors("Column '$name' already exists.");
        }

        Schema::table('users', function (Blueprint $table) use ($name, $type, $length, $nullable) {

            switch ($type) {
                case 'int':       $column = $table->integer($name); break;
                case 'bigint':    $column = $table->bigInteger($name); break;
                case 'varchar':   $column = $table->string($name, $length); break;
                case 'text':      $column = $table->text($name); break;
                case 'boolean':   $column = $table->boolean($name); break;
                case 'date':      $column = $table->date($name); break;
                case 'timestamp': $column = $table->timestamp($name); break;
                default:          $column = $table->string($name, 255);
            }

            if ($nullable) {
                $column->nullable();
            }
        });

        return back()->with('success', "Column '$name' added successfully!");
    }
}

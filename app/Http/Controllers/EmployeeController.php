<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Gender;  
use App\Models\User; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::where('role', 'employee')->with('gender')->orderBy('first_name')->paginate(10);
        $genders = Gender::all();

        return view('admin.employee.employeelist', compact('employees', 'genders'));
    }

    public function create()
    {
        $genders = Gender::all();
        return view('admin.employee.create', compact('genders'));
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'suffix_name' => 'nullable|string',
            'email' => 'required|email|unique:employees,email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'gender' => 'required|exists:genders,gender_id',
            'employee_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_employee' => 'nullable|boolean',
            'admin' => 'nullable|boolean',
        ]);

        if (!isset($validated['suffix_name'])) {
            $validated['suffix_name'] = '';
        }
        if ($request->has('password')) {
            $validated['password'] = bcrypt($validated['password']);
        }    
        if ($request->hasFile('employee_image')) {
            $fileNameWithExtension = $request->file("employee_image");
            $filename = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('employee_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('employee_image')->storeAs('public/img/employee', $filenameToStore);
            $validated['employee_image'] = $filenameToStore;
        }
        $validated['gender_id'] = $request->input('gender_id', 1);
        
        $employee = Employee::create($validated);
        
        $isEmployee = $request->has('is_employee') && $request->input('is_employee');
        $isAdmin = $request->has('admin') && $request->input('admin');

    if ($isAdmin) {
        // Create user record with admin privileges
        User::create([
            'name' => $request->input('first_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'admin' => true,
        ]);
        
        $employee->delete();
    } elseif ($request->has('is_employee') && $request->input('is_employee')) {
        // Create user record for employee login
        User::create([
            'name' => $request->input('first_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => 'employee',
        ]);
        $employee->save();
    }

    return redirect()->route('admin.employee.index')->with('success', 'Employee added successfully.');
}
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $genders = Gender::all();
        return view('admin.employee.edit', compact('employee', 'genders'));
    }

    public function update(Request $request, $id)
{
    $employee = Employee::findOrFail($id);

    $validated = $request->validate([
        'first_name' => 'required|string',
        'middle_name' => 'nullable|string',
        'last_name' => 'required|string',
        'suffix_name' => 'nullable|string',
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('employees')->ignore($employee->employee_id, 'employee_id'),
        ],
        'password' => 'nullable|string|min:8|confirmed',
        'password_confirmation' => 'nullable|string|min:8|same:password',
        'phone' => 'nullable|string',
        'address' => 'nullable|string',
        'gender' => 'required|exists:genders,gender_id',
        'admin' => 'boolean',
        'employee_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_employee' => 'nullable|boolean',
    ]);

    if ($request->filled('password')) {
        $validated['password'] = bcrypt($validated['password']);
    } else {
        unset($validated['password']);
    }

    if ($request->hasFile('employee_image')) {
        $fileNameWithExtension = $request->file("employee_image");
        $filename = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
        $extension = $request->file('employee_image')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;
        $request->file('employee_image')->storeAs('public/img/employee', $filenameToStore);
        $validated['employee_image'] = $filenameToStore;
    }

    if (!isset($validated['suffix_name'])) {
        $validated['suffix_name'] = '';
    }

    $employee->update(array_merge($validated, ['gender_id' => $request->input('gender')]));

    if ($request->has('is_employee')) {
        $employee->is_employee = true;
    } else {
        $employee->is_employee = false;
    }
    $employee->save();

    // Update admin privileges
    $isAdmin = $request->has('admin') && $request->input('admin');
    $user = User::where('email', $employee->email)->first();

    if ($isAdmin) {
        if (!$user) {
            User::create([
                'name' => $employee->first_name,
                'email' => $employee->email,
                'password' => bcrypt($request->input('password')),
                'role' => 'admin', // Set role as admin
            ]);
        } else {
            $user->role = 'admin'; // Set role to admin
            $user->save();
        }
        $employee->delete(); // Remove the employee record
    } else {
        // Check if the request explicitly sets admin to false
        if ($user) {
            $user->role = 'employee'; // Set role to employee
            $user->save();
        }
    }

    return redirect()->route('admin.employee.index')->with('success', 'Employee updated successfully.');
}

    public function delete($id)
    {
        $employee = Employee::find($id);
        return view('admin.employee.delete', compact('employee'));
    }

    public function destroy(Request $request, Employee $employee)
    {

        if ($employee->employee_image && Storage::exists('public/img/employee/' . $employee->employee_image)) {
            Storage::delete('public/img/employee/' . $employee->employee_image);
        }
        $employee->delete($request);

        return redirect()->route('admin.employee.index')->with('success', 'Employee deleted successfully.');
    }

    public function show(Employee $employee)
    {
        return view('admin.employee.show', compact('employee'));
    }

        public function search(Request $request)
    {
        \DB::enableQueryLog();
        $search = $request->input('search');
        $gender = $request->input('gender');

        $employees = Employee::with('gender')
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%$search%")
                    ->orWhere('middle_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', middle_name, ' ', last_name)"), 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });

        if ($gender) {
            if (is_numeric($gender)) {
                $employees->where('gender_id', $gender);
            } else {
                $employees->whereHas('gender', function ($query) use ($gender) {
                    $query->where('gender', $gender);
                });
            }
        }

        $employees->orderBy('first_name');
        $employees = $employees->paginate(10); // Adjust pagination limit as needed
        $selectedGender = $gender;
        $genders = Gender::all();

        $queries = \DB::getQueryLog();
        \Log::info(print_r($queries, true));

        return view('admin.employee.employeelist', compact('employees', 'genders', 'selectedGender', 'search'));
    }
}
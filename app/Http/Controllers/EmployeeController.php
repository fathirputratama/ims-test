<?php
   namespace App\Http\Controllers;

   use App\Models\Employee;
   use Illuminate\Http\Request;

   class EmployeeController extends Controller
   {
       public function index()
       {
           $employees = Employee::all();
           return view('admin.employees.index', compact('employees'));
       }

       public function create()
       {
           return view('admin.employees.create');
       }

       public function store(Request $request)
       {
           $request->validate([
               'name' => 'required|string|max:255',
               'position' => 'required|string|max:255',
           ]);

           Employee::create($request->only(['name', 'position']));

           return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil ditambahkan.');
       }

       public function edit(Employee $employee)
       {
           return view('admin.employees.edit', compact('employee'));
       }

       public function update(Request $request, Employee $employee)
       {
           $request->validate([
               'name' => 'required|string|max:255',
               'position' => 'required|string|max:255',
           ]);

           $employee->update($request->only(['name', 'position']));

           return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil diperbarui.');
       }

       public function destroy(Employee $employee)
       {
           $employee->delete();
           return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil dihapus.');
       }
   }
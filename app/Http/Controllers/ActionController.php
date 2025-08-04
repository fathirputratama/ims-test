<?php
   namespace App\Http\Controllers;

   use App\Models\Action;
   use Illuminate\Http\Request;

   class ActionController extends Controller
   {
       public function index()
       {
           $actions = Action::all();
           return view('admin.actions.index', compact('actions'));
       }

       public function create()
       {
           return view('admin.actions.create');
       }

       public function store(Request $request)
       {
           $request->validate([
               'name' => 'required|string|max:255',
               'price' => 'required|numeric|min:0',
           ]);

           Action::create($request->only(['name', 'price']));

           return redirect()->route('admin.actions.index')->with('success', 'Tindakan berhasil ditambahkan.');
       }

       public function edit(Action $action)
       {
           return view('admin.actions.edit', compact('action'));
       }

       public function update(Request $request, Action $action)
       {
           $request->validate([
               'name' => 'required|string|max:255',
               'price' => 'required|numeric|min:0',
           ]);

           $action->update($request->only(['name', 'price']));

           return redirect()->route('admin.actions.index')->with('success', 'Tindakan berhasil diperbarui.');
       }

       public function destroy(Action $action)
       {
           $action->delete();
           return redirect()->route('admin.actions.index')->with('success', 'Tindakan berhasil dihapus.');
       }
   }
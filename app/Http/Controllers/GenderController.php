<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gender;
use App\Models\User;

class GenderController extends Controller
{
    public function index()
    {
        $genders = Gender::all();
        return view('admin.gender.genderlist', compact('genders'));
    }

    public function create()
    {
        return view('admin.gender.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gender' => 'required|string|unique:genders',
        ]);

        Gender::create($validated);

        return redirect()->route('admin.gender.index')->with('success', 'Gender added successfully.');
    }

    public function edit($id){
        $gender = Gender::find($id);
        return view('admin.gender.edit', compact('gender'));
    }

    public function update(Request $request, Gender $gender){
        $validated = $request->validate(['gender' => ['required']]);
        $gender->update($validated);
        return redirect()->route('admin.gender.index')->with('success', 'Gender updated successfully.');
    }
    
    public function delete($id)
{
    $gender = Gender::find($id);
    return view('admin.gender.delete', compact('gender'));
}

    public function destroy(Request $request, Gender $gender)
    {
        $gender->delete($request);

        return redirect()->route('admin.gender.index')->with('success', 'Gender deleted successfully.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $genders = Gender::where('gender', 'like', "%$search%")->get();

        return view('admin.gender.genderlist', compact('genders'));
    }
    public function show($id){
        $gender = Gender::find($id);
        return view('admin.gender.show', compact('gender'));
    }
}
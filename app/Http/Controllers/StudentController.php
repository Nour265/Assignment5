<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // Display a list of students
    public function index(Request $request)
{
    $query = Student::query();

    if ($request->has('name') && $request->name !== null) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->has('minAge') && is_numeric($request->minAge)) {
        $query->where('age', '>=', $request->minAge);
    }

    if ($request->has('maxAge') && is_numeric($request->maxAge)) {
        $query->where('age', '<=', $request->maxAge);
    }

    $students = $query->get();

    if ($request->ajax()) {
        
        $html = '';
        foreach ($students as $student) {
            $html .= '
                <tr>
                    <td>' . $student->name . '</td>
                    <td>' . $student->age . '</td>
                    <td>' . $student->email . '</td>
                </tr>
            ';
        }
        return response($html);
    }

    return view('index', compact('students'));
}

    // Show the form to create a new student
    public function create()
    {
        return view('create');
    }

    // Store a newly created student
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age'  => 'required|integer|min:1|max:100',
        ]);

        Student::create([
            'name' => $request->name,
            'age'  => $request->age,
        ]);

        return redirect()->route('index')->with('success', 'Student added successfully!');
    }

    public function show($id) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}

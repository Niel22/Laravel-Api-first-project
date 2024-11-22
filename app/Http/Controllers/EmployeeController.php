<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public $rules = [
        'name' => ['required', 'unique:employees,name']
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Employee::select(['id', 'name'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if($validator->fails()){
            return $validator->errors();
        }

        $data = $validator->validated();

        Employee::create([
            'name' => $data['name']
        ]);

        return response()->json([
            'success' => 'Employee record created succesfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return $employee->only(['id', 'name']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return $employee->only(['name']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if($validator->fails()){
            return $validator->errors();
        }

        $data = $validator->validated();

        $employee->update([
            'name' => $data['name']
        ]);

        return response()->json([
            'success' => 'Employee record updated succesfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'success' => 'Employee record deleted succesfully'
        ], 200);
    }
}

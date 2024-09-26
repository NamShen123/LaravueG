<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    function show($id, $forRequest = true)
    {
        $department = Departments::where('id', $id)->firstOrFail();
        if(!$forRequest) {
            return $department;
        }

        return response()->json([
            'id' => $department->id,
            'name' => $department->name,
        ]);
    }

    function index($forRequest = true)
    {
        $departments = Departments::get();
        if(!$forRequest) {
            return $departments;
        }
        return response()->json($departments);
    }

}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Models\Department;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//api do funcionario--------------------------------------------------------------------------------------------------------------


//criar um funcionario
//Route::post('/employees', function(Request $request){
//    $employee = new Employee();
//   $employee->cpf = $request->input('cpf');
//    $employee->name = $request->input('name');
//    $employee->pis = $request-> input('pis');
//    $employee->adress = $request-> input('adress');
//    $employee->save();
//    return response()->json($employee);
//});

//buscar todas os funcionarios
Route::get('/employees', function(){
    $employee = Employee::all();
    return response()->json($employee);
});

//buscar apenas um funcionario pelo id
Route::get('/employees/{id}', function($id){
    $employee = Employee::find($id);
    return response()->json($employee);
});

//atualizar atributos da table
Route::patch('/employees/{id}', function(Request $request, $id){
    $employee = Employee::find($id);

    if($request->input('cpf') !== null){
        $employee->cpf = $request->input('cpf');
    }

    if($request->input('name') !== null){
        $employee->name = $request->input('name');
    }

    if($request->input('pis') !== null){
        $employee->pis = $request->input('pis');
    }

    if($request->input('adress') !== null){
        $employee->adress = $request->input('adress');
    }

    $employee->save();
    return response()->json($employee);

});

//deletando um registro
Route::delete('/employees/{id}', function($id){
    $employee = Employee::find($id);
    $employee->delete();
    return response()->json($employee);
});






//api do depatamento--------------------------------------------------------------------------------------------------------------


//criar um departamento
Route::post('/departments', function(Request $request){
    $department = new Department();
    $department->name = $request->input('name');
    $department->description = $request-> input('description');
    $department->save();
    return response()->json($department);
});

//buscar todas os departamentos
Route::get('/departments', function(){
    $department = Department::all();
    return response()->json($department);
});

//buscar apenas um funcionario pelo id
Route::get('/departments/{id}', function($id){
    $department = Department::find($id);
    return response()->json($department);
});

//atualizar atributos da table
Route::patch('/departments/{id}', function(Request $request, $id){
    $department = Department::find($id);

    if($request->input('name') !== null){
        $department->name = $request->input('name');
    }

    if($request->input('description') !== null){
        $department->description = $request->input('description');
    }

    $department->save();
    return response()->json($department);

});

//deletando um registro
Route::delete('/departments/{id}', function($id){
    $department = Department::find($id);
    $department->delete();
    return response()->json($department);
});


//-----------------------------------------------------------------------------------------------------------------------------------


//criando relacionamentooo---------------------------
Route::post('/employees' , function (Request $request) {
    $employee = new Employee();
    $employee->cpf = $request->input('cpf');
    $employee->name = $request->input('name');
    $employee->pis = $request-> input('pis');
    $employee->adress = $request-> input('adress');
    $department_id = $request->input('department_id');
    $department = Department::find($department_id);
    $employee->department()->associate($department);
    $employee->save();
    return response()->json($employee);
   });

   //get nos relacionamento
   Route::get('/employees/departments/{id}', function ($id) {
    $employee = Employee::find($id);
    $department = $employee->department;
    return response()->json($department);
});




Route::get('/employees/departments', function () {
    $employees = Employee::whereNull('department_id')->get();

    $employee = Employee::with('department')->get();
    return response()->json($employee);
});

Route::get('/employees/{id}/department', function ($id) {
    $employee = Employee::find($id);
    return response()->json($employee->department);
});

Route::get('/departments/employees', function () {
    $departments = Department::with('employee')->get();
    return response()->json($departments);
});

Route::get('/departments/{id}/employees', function ($id) {
    $department = Department::with('employee')->find($id);
    return response()->json($department ? $department->employee : []);
});
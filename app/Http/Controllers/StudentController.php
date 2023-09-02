<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    //function to go to index
    public function index(){
        return view('index');
    }

    //functoin to add student in table
    public function addStudent(Request $request){
        if($request->hasFile('profile')){
            $profile = $request->profile;
            $profileName = time().'.'.$profile->getClientOriginalName();
            $profile->storeAs('public/assets/images',$profileName);
        }

        $validator = Validator::make($request->all(), [
            
            'name'=> 'required',
            'email'=> 'required|email',
            'profile'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>404, 'errors'=>$validator->messages()]);
        } else {

            $studentData = [
                'name'=>$request->name,
                'email'=>$request->email,
                'profile'=>$profileName
            ];            

            Student::create($studentData);
            return response()->json(['status' => 200]);
        }

    }

    //function to show student
    public function showStudent(Request $request){
        $student = Student::all();
        $table = '';
        if(count($student) > 0){
            $table = '<table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
                        foreach($student as $stud){
                            $table .= '<tr>
                                        <td>'.$stud->id.'</td>
                                        <td><img class="img-thumbnail" width="50" src="storage/assets/images/'.$stud->profile.'"></td>
                                        <td>'.$stud->name.'</td>
                                        <td>'.$stud->email.'</td>
                                        <td>
                                            <a href="#" id="'.$stud->id.'" class="btn_edit text-success h4 mx-1"><i class="bi bi-pencil-square"></i></a>
                                            <a href="#" id="'.$stud->id.'" class="btn_delete text-danger h4 mx-1"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>';
                        }
                        $table .= '</tbody></table>';
                        echo $table;
        } else {
            echo '<h1 class="text-secondary text-center my-5">There is no student record in database</h1>';
        }

    }

    //function to get student data
    public function getStudentData(Request $request){
        $id = $request->id;
        $student = Student::find($id);
        return response()->json($student);
    }

    //fucntion to update the student data
    public function updateStudent(Request $request){
        $id = $request->id;
        $student = Student::find($id);
        if($request->hasFile('profile')){
            $profile = $request->profile;
            $profileName = time().'.'.$profile->getClientOriginalName();
            if($student->profile){
                unlink(storage_path('app/public/assets/images/'.$student->profile));
            }
            $profile->storeAs('public/assets/images', $profileName);
        } else {
            $profileName = $request->old_profile;
        }

        $validator = Validator::make($request->all(), [

            'name'=>'required',
            'email'=>'required|email'
        ]);

        if($validator->fails()){
            return response()->json(['status'=>404, 'errors'=>$validator->messages()]);
        } else {

            $student->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'profile'=>$profileName
            ]);

            return response()->json(['status'=>200]);
        }
    }

    //function to delete student
    public function deleteStudent(Request $request){
        $id = $request->id;
        $student = Student::find($id);
        if($student->profile){
            unlink(storage_path('app/public/assets/images/'.$student->profile));
        }
        Student::destroy($id);
        return response()->json(['status'=>200]);
    }


}


<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\course_code;
use App\Models\SyllabusCourses;

use App\Models\school;
use App\Models\Department;
use App\Models\program;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth', 'superadmin']);
    }

    public function addcourse(Request $request)
    {
        $status="";
        $message="";
        $request->validate([
            'course_code' => ['required'],
            'department'=>['required'],
            'course_title' => ['required'],
            'credits' => ['required'],
            'hours' => ['required'],
            'category' => ['required'],
            'semester' => ['required'],
        ]);
        try {
            course_code::create([
                'id' => Str::uuid(),
                'course_code' => strtoupper(trim($request->course_code)),
                'course_title' => $request->course_title,
                'department_id'=>$request->department,
                'credits' => $request->credits,
                'hours' => $request->hours,
                'category' => $request->category,
                'semester' => $request->semester,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
            $status = 'success';
            $message = "Course Added Successfully";
        } catch (Exception $e) {
            Log::warning('Error Adding Course',$e->getMessage());
            $status = 'error';
            $message = "Unable to Add Course";

        }

        return response()->json(['status' => $status,'message'=>$message]);
    }

     public function getCourse(){
         $courses=course_code::select('course_code','course_title','course_title','credits','hours','category','semester')->get();
         return response()->json($courses);
     }

     public function addSchool(Request $request)
     {
       $status="";
       $message="";
       $request->validate([
           'school_name' => ['required'],
       ]);
       try {
           school::create([
               'id' => Str::uuid(),
               'school_name' => strtoupper(trim($request->school_name)),
           ]);
           $status = 'success';
           $message = "School Added Successfully";
       } catch (Exception $e) {
           Log::warning('Error Adding School',$e->getMessage());
           $status = 'error';
           $message = "Unable to Add School";

       }

       return response()->json(['status' => $status,'message'=>$message]);
     }

     public function getSchool(Request $request)
     {
       $schools=school::select('school_name')->get();
       // $schools=school::find($id);
       return response()->json($schools);
     }

     public function editSchool(Request $request, $schoolId)
     {
       $status="";
       $message="";
       $request->validate([
           'school_name' => ['required'],
       ]);
       try {

           $schools = school::find($schoolId);
             // $schools = school::find($id);
             // $matching = ['id' => $schoolId];
             // $schools = school::where($matching);
             // if ($schools) {
             //   $schools->school_name = $request->school_name;
             //   $schools->save();
             //   return response()->json($schools);
             // }

           $schools->school_name = $request->input('school_name');
           $schools->save();

           $status = 'success';
           $message = "SchoolName Updated Successfully";
       } catch (Exception $e) {
           Log::warning('Error Updating SchoolName',$e->getMessage());
           $status = 'error';
           $message = "Unable to Update SchoolName";

       }

       return response()->json(['status' => $status,'message'=>$message]);


     }

     public function deleteSchool(Request $request, $schoolId)
     {
       $status="";
       $message="";
       try {
           if ($schools = school::find($schoolId)) {
             // $matching = ['id' => $schoolId];
             // $schools = school::where($matching);
             // if ($schools) {
             //   $schools->delete();
             //   $schools->save();
             //   return response()->json($schools);
             // }
             $schools->delete();
           }
           $status = 'success';
           $message = "School Deleted Successfully";
       } catch (Exception $e) {
           Log::warning('Error Deleting School',$e->getMessage());
           $status = 'error';
           $message = "Unable to Delete School";

       }

       return response()->json(['status' => $status,'message'=>$message]);
     }

     public function addDepartmentAndProgram(Request $request)
     {
       $status="";
       $message="";
       $request->validate([
           'school_id' => ['required'],
           'department_name' => ['required'],
           'program_name'=>['required'],

       ]);
       try {
           $schoolId = school::find($request->school_id, ['id',]);
           $departmentId = Str::uuid();
           Department::create([
             'id' => $departmentId,
             'school_id' => $schoolId,
             'department_name' => $request->department_name,
           ]);
           foreach ($request->program_name as $val) {
               program::create([
                   'id' => Str::uuid(),
                   'department_id' => $departmentId,
                   'program_name' => strtoupper(trim($val['program_name'])),
               ]);
           }

           $status = 'success';
           $message = "Programs Added Successfully";
       } catch (Exception $e) {
           Log::warning('Error Adding Programs',$e->getMessage());
           $status = 'error';
           $message = "Unable to Add Programs and Department";

       }

       return response()->json(['status' => $status,'message'=>$message]);
     }

     public function getDepartmentAndProgram()
     {

     }

     public function editDepartment(Request $request, $departmentId)
     {
       $status="";
       $message="";
       $request->validate([
           'department_name' => ['required'],
       ]);
       try {
           if ($department = Department::find($departmentId)) {
             // $department = Department::find($departmentId);
             // $matching = ['id' => $departmentId];
             // $schools = school::where($matching);
             // if ($department) {
             //   $department->department_name = $request->department_name;
             //   $department->save();
             //   return response()->json($department);
             // }
             $department->department_name = $request->input('department_name');
             $department->save();
           }
           $status = 'success';
           $message = "DepartmentName Updated Successfully";
       } catch (Exception $e) {
           Log::warning('Error Updating DepartmentName',$e->getMessage());
           $status = 'error';
           $message = "Unable to Update DepartmentName";

       }

       return response()->json(['status' => $status,'message'=>$message]);
     }

     public function deleteDepartment(Request $request, $departmentId)
     {
       $status="";
       $message="";
       try {
           if ($department = Department::find($departmentId)) {
             // $matching = ['id' => $schoolId];
             // $schools = school::where($matching);
             // if ($schools) {
             //   $schools->delete();
             //   $schools->save();
             //   return response()->json($schools);
             // }
             $department->delete();
           }
           $status = 'success';
           $message = "Department Deleted Successfully";
       } catch (Exception $e) {
           Log::warning('Error Deleting Department',$e->getMessage());
           $status = 'error';
           $message = "Unable to Delete Department";

       }

       return response()->json(['status' => $status,'message'=>$message]);
     }

     public function editProgram(Request $request, $programId)
     {
       $status="";
       $message="";
       $request->validate([
           'program_name' => ['required'],
       ]);
       try {
           if ($program = program::find($programId)) {
             // $program = school::find($programId);
             // $matching = ['id' => $programId];
             // $program = school::where($matching);
             // if ($program) {
             //   $program->school_name = $request->program_name;
             //   $program->save();
             //   return response()->json($program);
             // }
             $program->program_name = $request->program_name;
             $program->save();
           }
           $status = 'success';
           $message = "Program Updated Successfully";
       } catch (Exception $e) {
           Log::warning('Error Updating ProgramName',$e->getMessage());
           $status = 'error';
           $message = "Unable to Update ProgramName";

       }

       return response()->json(['status' => $status,'message'=>$message]);


     }

     public function deleteProgram(Request $request, $programId)
     {
       $status="";
       $message="";
       try {
           if ($program = program::find($programId)) {
             // $matching = ['id' => $programId];
             // $schools = program::where($matching);
             // if ($program) {
             //   $program->delete();
             //   $program->save();
             //   return response()->json($program);
             // }
             $program->delete();
           }
           $status = 'success';
           $message = "Program Deleted Successfully";
       } catch (Exception $e) {
           Log::warning('Error Deleting Program',$e->getMessage());
           $status = 'error';
           $message = "Unable to Deleting Program";

       }

       return response()->json(['status' => $status,'message'=>$message]);
     }

}

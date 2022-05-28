<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentResult;
use App\Models\Subject;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Str;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::latest('id')->paginate(10);
        return view('admin.student.index', compact('students'));
    }


    public function create()
    {
        $subjects = Subject::latest('id')->get();
        return view('admin.student.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'              => 'required',
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'subject'           => 'required',
            'achieve_number'    => 'required',
        ]);
        if ($request->hasfile('image')) {
            $image  = $request->file('image');
            $name   = Str::slug($request->input('name')) . '_' . time();
            $destinationPath = 'backend/admin/images';
            $imageName = $name . '.' . $image->getClientOriginalExtension();
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imageName);
        } else {
            $imageName = '';
        }
        $student = Student::create([
            'name' =>  $request->name,
            'image' => $imageName
        ]);
        $student_id     = $student->id;
        $subject        = $request->subject;
        $achieve_number = $request->achieve_number;
        $subject_count        = count($request->subject);
        $achieve_number_count = count($request->achieve_number);

        if ($subject_count == $achieve_number_count) {
            for ($i = 0; $i < $subject_count; $i++) {
                $input['student_id']        = $student_id;
                $input['subject_id']        = $subject[$i];
                $input['achieve_number']    = $achieve_number[$i];
                StudentResult::create($input);
            }
            return redirect()->route('students.index')->with('success', 'Student has been created successfully!');
        }
        return back()->with('error', 'Student don\'t created!');
    }

    public function show($id)
    {
        $student    = Student::findOrFail($id);
        $subjects   = Subject::latest('id')->get();
        
        return view('admin.student.show', compact('student', 'subjects'));
    }


    public function edit($id)
    {
        $subjects = Subject::latest('id')->get();
        $student = Student::findOrFail($id);
        return view('admin.student.edit', compact('subjects', 'student'));
    }

    public function update(Request $request, $id)
    {
        
        $validatedData = $request->validate([
            'name'              => 'required',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'subject'           => 'required',
            'achieve_number'    => 'required',
        ]);
        $student    = Student::findOrFail($id);
        if ($request->hasfile('image')) {
            $image  = $request->file('image');
            $name   = Str::slug($request->input('name')) . '_' . time();
            $destinationPath = 'backend/admin/images';
            $imageName = $name . '.' . $image->getClientOriginalExtension();
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imageName);
            if(  file_exists( $destinationPath.'/'. $student->image)) {
                unlink( $destinationPath .'/'. $student->image);
            }
        } else {
            $imageName = $student->image;
        }
        $student = $student->update([
            'name' =>  $request->name,
            'image' => $imageName
        ]);
        $subject                = $request->subject;
        $achieve_number         = $request->achieve_number;
        $subject_count          = count($request->subject);
        $achieve_number_count   = count($request->achieve_number);
        
        if ($subject_count == $achieve_number_count) {
            StudentResult::where('student_id', $id)->delete();
            for ($i = 0; $i < $subject_count; $i++) {
                $input['student_id']        = $id;
                $input['subject_id']        = $subject[$i];
                $input['achieve_number']    = $achieve_number[$i];
                StudentResult::create($input);
            }
            return redirect()->back()->with('success', 'Student has been updated successfully!');
        }
        return back()->with('error', 'Student don\'t updated!');
    }

    public function destroy($id)
    {
        if ($student = Student::findOrFail($id)) {
            $destinationPath = public_path('backend\admin\images');
            if(  file_exists( $destinationPath.'/'. $student->image)) {
                unlink( $destinationPath .'/'. $student->image);
            }
            $student->delete();
            StudentResult::where('student_id', $id)->delete();
            return redirect()->route('students.index')->with('success', 'Student is deleted successfully!');
        }
        return back()->with('error', 'Student don\'t deleted!');
    }
}

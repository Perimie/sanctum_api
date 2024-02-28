<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
class ProjectController extends Controller
{
    //add project (post,formdata)
    public function addProject(Request $request)
    {
        //validation 
        $request->validate([
            'title' => 'required',
            'description' =>'required'
        ]);
        $studentData = auth()->user();

        $studentId = $studentData->id;


        //project model
        Project::create([
            'student_id' => $studentId,
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration
        ]);

        //response
        return response()->json([
          'status' =>'success', 
          'message' => 'Project added successfully'   
        ]);
    }

    //student' s list project (get)
    public function getProjectList(){

        $studentId = auth()->user()->id;

        $projects = Project::where('student_id', $studentId)->get();

        if(!empty($projects))
        {

            return response()->json([
              'status' =>'success',
              'message' => 'Project Found',
                'data' => $projects
            ]);

        }

            return response()->json([
            'status' => 'error',
            'message' => 'No Project Found'
            ]);


    }

    //Single Project Details (get)

    public function getSingleProject($project_id){
        
        $student_id = auth()->user()->id;

        if(Project::where([
             'id' => $project_id,
             'student_id' => $student_id,
        ])->exists()){

            $project = Project::where([
                'id' => $project_id,
             'student_id' => $student_id,
            ])->first();

            return response()->json([
            'status' =>'success',
            'message' => 'Project Found',
                'data' => $project
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No Project Found'
        ]);


    }

    //delete project (delete)   

    public function deleteProject($project_id){
        $student_id = auth()->user()->id;


        if(Project::where([
            'id' => $project_id,
            'student_id' => $student_id

        ])->exists()){
            $project = Project::where([
                'id' => $project_id,
             'student_id' => $student_id
            ])->first();

            $project->delete();

            return response()->json([
             'status' =>'success',
             'message' => 'Project deleted successfully',
            ]);
        }
        return response()->json([
          'status' => 'error',
          'message' => 'No Project Found'
        ]);
    }
}

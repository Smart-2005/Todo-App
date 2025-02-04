<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string',
            'task_description' => 'required|string',
            'task_priority' => 'required|string',
            'task_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }
    
        // Handle image data
        $imgName = null;
        if ($request->hasFile('task_img')) {
            $imgName = time() . "." . $request->file('task_img')->extension();
            $request->file('task_img')->move(public_path('taskImages'), $imgName);
        }
    
        $task = Tasks::create([
            'task_name' => $request->input('task_name'),
            'task_description' => $request->input('task_description'),
            'task_priority' => $request->input('task_priority'),
            'task_img' => $imgName,
        ]);
    
        return response()->json([
            'message' => 'Task created successfully!',
            'task' => $task
        ], 201);
    }

    public function retrieve()
    {
        $tasks = Tasks::all();

        return response()->json([
            'message'=>"Tasks retrieve successfully!",
            'taks'=> $tasks
        ],200);
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string',
            'task_description' => 'required|string',
            'task_priority' => 'required|string',
            'task_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $task = Tasks::find($id);

        if(!$task){
            return response()->json([
                'message'=>"Task not found!"
            ],404);
        }
        
        // Handle image data
        if ($request->hasFile('task_img')) {

         // Delete older img if exists
            if ($task->task_img && file_exists(public_path('taskImages/' . $task->task_img))) {
                unlink(public_path('taskImages/' . $task->task_img)); // Delete the old image
            }

            $imgName = time() . "." . $request->file('task_img')->extension();
            $request->file('task_img')->move(public_path('taskImages'), $imgName);
            $task->update(['task_img'=>$imgName]);
        }

        $task->update($request->except('_method','task_img'));
        

        return response()->json([
            'message' => 'Task update successfully!',
            'task' => $task
        ], 201);
    }

    public function delete($id)
    {
        $task = Tasks::find($id);

        if(!$task){
            return response()->json([
                'message'=>"Task not found!"
            ],404);
        }

        $task->delete();

        return response()->json([
            'message'=>"Task delete successfully!"
        ],200);
    }
}

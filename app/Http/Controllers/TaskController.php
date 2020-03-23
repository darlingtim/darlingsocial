<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Task;
use Illuminate\Http\Request;
use illuminate\Validation;

class TaskController extends Controller
{
    //

     /**
     * @var
     */
    protected $user;

    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
 * @return mixed
 */
    public function index(){
        $tasks = $this->user->tasks()->paginate(3)->toArray();

        return $tasks;
    }

    /**
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
    public function show($id){
        $task = $this->user->tasks()->find($id);

        if (!$task) {
            return response()->json([
            'success' => false,
            'message' => 'Sorry, task with id ' . $id . ' cannot be found.'
            ], 400);
        }

        return $task;
    }

/**
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 * @throws \Illuminate\Validation\ValidationException
 */
    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        //return $this->user;
        if ($this->user->tasks()->save($task))
            return response()->json([
                'success' => true,
                'task' => $task
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, task could not be added.'
            ], 500);
    }



    /**
 * @param Request $request
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
    public function update(Request $request, $id){
        $task = $this->user->tasks()->find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, task with id ' . $id . ' cannot be found.'
            ], 400);
        }
        $updated = $task->fill($request->only('title', 'description'))->save();

        if ($updated) {
            return response()->json([
            'success' => true,
            'message'=> 'your task was updated successfully',
            'task'=> $task
            ]);
        } 
        else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, task could not be updated.'
            ], 500);
        }
    }

/**
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
    public function destroy($id){
        $task = $this->user->tasks()->find($id);

        if (!$task) {
            return response()->json([
            'success' => false,
            'message' => 'Sorry, task with id ' . $id . ' cannot be found.'
            ], 400);
        }
        //return($this->user);
        if ($task->delete()) {
            return response()->json([
            'success' => true,
            'message' => "{$this->user->username}, Task has been successfully deleted permanently..."
            ]);
        } else {
            return response()->json([
            'success' => false,
            'message' => 'Task could not be deleted.'
            ], 500);
        }
    }


}

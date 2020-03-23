<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use illuminate\Validation;
use JWTAuth;
use App\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    //

     /**
     * @var
     */
    protected $user, $task;

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
        if($tasks['data' ]== null){
            return response()->json([
                "status"=>200,
                "message"=> "You currently dont have any task. You can create a task"
                
            ]);
        }
        else{
            return response()->json([
                "status"=>200,
                "user"=> $this->user,
                "tasks"=> $tasks
            ]);
        }
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
            'message' => 'Sorry, task cannot be found.'
            ], 400);
        }

        else{
            return response()->json([
                "status"=>200,
                "tasks"=> $task
            ]);
        }
    }

/**
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 * @throws \Illuminate\Validation\ValidationException
 */
    public function store(Request $request){
        
        $validate =validator::make($request->all(),[
            'title'=>'required|string',
            'body'=>'required|string',
            'start_date'=>'required|date|after:yesterday',
            'end_date'=>'required|date|after_or_equal:start_date'
        ]);//->validate(); 
        $validateErrors= $validate->errors();
        //return $validateErrors;
        //var_dump($validateErrors);
        
        if($validateErrors->count()>0){
            return response()->json([
                'validation_Error'=>$validateErrors
            ]);
        }
        else{
            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            //return $this->user;
            if ($this->user->tasks()->save($task))
                return response()->json([
                    'success' => true,
                    'task' => $task
                ]);
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, task could not be added.'
                ], 500);
            }
        }
        
        
    }



    /**
 * @param Request $request
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
    public function update(Request $request, $id){
        $validate =validator::make($request->all(),[
            'title'=>'required|string',
            'body'=>'required|string',
            'start_date'=>'required|date|after:yesterday',
            'end_date'=>'required|date|after_or_equal:start_date'
        ]);//->validate(); 
        $validateErrors= $validate->errors();
        //return $validateErrors;
        //var_dump($validateErrors);
        
        if($validateErrors->count()>0){
            return response()->json([
                'validation_Error'=>$validateErrors
            ]);
        }
        else{
            $task = $this->user->tasks()->find($id);

            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, task with id ' . $id . ' cannot be found.'
                ], 400);
            }
            $updated = $task->fill($request->all())->save();

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

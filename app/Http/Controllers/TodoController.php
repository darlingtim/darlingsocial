<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\todo;
use App\User;
use Auth;

class TodoController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
     //

     /**
     * @var
     */
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = $this->Auth::user();
    }

    //
    

        /**
     * @return mixed
     */
    public function index(){
        //return('i got here');
        $todos = $this->user->todo()->paginate(10,['id', 'title', 'body', 'status','start_date', 'end_date', 'created_At', 'updated_at']);//get(['title', 'description']);//->toArray();

        return $todos;
    }

    /**
    * @param $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function show($id)
    {
    $todo = $this->user->todo()->findOne($id);

    if (!$todo) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, todo cannot be found.'
        ], 400);
    }

    return $todo;
    }

    /**
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    * @throws \Illuminate\Validation\ValidationException
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'start_date'=>'required|date|after:yesterday',
            'end_date'=>'required|date|after_or_equal:start_date'
        ]);

        //$todo = new todo();
        //$todo->title = $request->title;
        //$todo->description = $request->description;

        if ($this->user->todo()->save($request->all()))
            return response()->json([
                'success' => true,
                'todo' => $todo
            ]);
        else{
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo could not be added.'
            ], 500);
        }
    }

    /**
    * @param Request $request
    * @param $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'start_date'=>'required|date|after:yesterday',
            'end_date'=>'required|date|after_or_equal:start_date'
        ]);

        $todo= $this->user->todo()->find($id);

        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo cannot be found.'
            ], 400);
        }

        $updated = $todo->fill($request->all())->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo could not be updated.'
            ], 500);
        }
    }

    /**
    * @param $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function destroy($id)
    {
        $task = $this->user->todo()->find($id);

        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo cannot be found.'
            ], 400);
        }

        if ($todo->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'todo could not be deleted.'
            ], 500);
        }
    }


}



<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Note;
use App\User;
use Auth;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class NoteController extends Controller
{
    //



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
        //$this->middleware('auth');
        $this->user =  JWTAuth::parseToken()->authenticate();;
    }

    //
    

    /**
 * @return mixed
 */
    public function index(){
        //return('i got here');
        $notes = $this->user->notes()->paginate(10);//get(['title', 'description']);//->toArray();

        return response()->json([
            "status"=>200,
            "success" => true,
            "notes"=>$notes
        ]);
    }

    /**
    * @param $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function show($id)
    {
    $note = $this->user->notes()->find($id);
        return $note;
    if (!$note) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, Note cannot be found.'
        ], 400);
    }

    return response()->json([
        "status"=>200,
        "success" => true,
        "note" => $note
    ]);
    }

    /**
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    * @throws \Illuminate\Validation\ValidationException
    */
    public function store(Request $request)
    {
        $validate =validator::make($request->all(),[
            'title'=>'required|string',
            'body'=>'required|text'
            
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
            $note =new Note;
        //$todo -> nickname = Auth::user()->username;
        //$todo->status= 0;
            if ($note->fill($request->all())->save()){
                return response()->json([
                    'success' => true,
                    'message'=>'Your Note was created successfully!',
                    'note' => $note
                ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, Note could not be created.'
                ], 500);
            }

        }


    }


    /**
    * @param Request $request
    * @param $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function update(Request $request, $id)
    {
        $validate =validator::make($request->all(),[
            'title'=>'required|string',
            'body'=>'required|text'
        ]);//->validate(); 
        $validateErrors= $validate->errors();
        //return $validateErrors;
        //var_dump($validateErrors);
        
        if($validateErrors ->count()>0){
            return response()->json([
                'validation_Error'=>$validateErrors
            ]);
        }
        else{
            $note= $this->user->notes()->find($id);

            if (!$note) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, Note cannot be found.'
                ], 400);
            }

            $updated = $note->fill($request->all())->save();

            if ($updated) {
                return response()->json([
                    "status"=>200,
                    "success" => true,
                    "message" => "Your Note list was successfully updated!"
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, Note could not be updated.'
                ], 500);
            }
        }


    }

    /**
    * @param $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function destroy($id)
    {
        $note = $this->user->notes()->find($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Note cannot be found.'
            ], 400);
        }

        if ($note->delete()) {
            return response()->json([
                'success' => true,
                "message" => 'Your Note list has been deleted!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Note could not be deleted. TRY AGAIN'
            ], 500);
        }
    }






}

<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use App\Http\Requests\ArticleFormRequest;
use Auth;
use JWTAuth;
//use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
//use paginate;

class ArticleController extends Controller
{
    
    //

     /**
     * @var
     */
    protected $user;

    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        
        $article=  $this->user->articles()->paginate(5)->toArray(); /*DB::table('articles')
        ->where('user_id', '=', $this->user->id)->select('id','title')->latest()->paginate(10);//*/
        if($article !=null){
            return response()->json([
                "status"=>200,
                 "article"=>$article
             ]);
             
          }
          else{
              return response()->json([
                  "status"=>201,
                  "message"=>"Sorry, you dont have any Article. Please create an Article."
                 
              ]);
          }
        return $article;
    }
 
    public function show($id)
    {
        $article= $this->user->articles->find($id);
        if($article != null){
           return response()->json([
               "status"=>200,
                "article"=>$article
            ]);
            
         }
         else{
             return response()->json([
                 "status"=>401,
                 "warning"=>"You are not permited to view this Article or it doesn't exist"
                
             ]);
         }
    }

    public function store(ArticleFormRequest $request)
    {
        $article =new article;
        $article -> user_id = Auth::user()->id;
        
        //$article -> title = $request->get('title');
        //$article -> body = $request->get('body');
        
        if($article->fill($request->all())->save()){
            return response()->json([
                "status"=>200,
                "success"=>"Your Article was successfully created",
                
            ]);
        }
        else{
            return response()->json([
                "error"=>"sorry, your article could not be created; Try Again"
            ]);
        }
    }

    public function update(ArticleFormRequest $request, $id)
    {
        //return $request;
         $article = $this->user->articles->find($id);//where('id', '=', $id);
         if($article !=null){
            //$article -> title = $request->get('title');
            //$article -> body = $request->get('body');
            if($article->fill($request->all())->save()){
                $data = array();
                $data['Message'] = "your article: '{$article->title}', has been successfully updated";
                $data['updated_article'] =$article;
                return response()->json($data, 200);
            }
            else{
                return response()->json([
                    "error"=>"something went wrong while updating your Article. TRY AGAIN"
                ]);
            }
         }
         else{
             return response()->json([
                 "status"=>401,
                 "warning"=>"sorry, You are not permitted to edit this article or it doesn't exist"
                
             ]);
         }
        
    }

    public function delete(Request $request, $id)
    {
        $article = $this->user->articles->find($id);
        $data = array();
        $deleted_article = $article;
        if($article != null){
            if($article->delete()){
                $data = array();
                $data['Message'] = "your article: '{$deleted_article->title}', has been successfully deleted";
                $data['deleted_article'] =$deleted_article;
    
                 return response()->json($data);//->json($data, 204);
            }
    
            else {return response()->json([
                "error"=>"Sorry, Article was not Deleted. Try Again"
            ]);};
        }
        else{
            return response()->json([
                "status"=>401,
                "warning"=>"You are not Authorized to Delete this Article or it doesn't Exist"
            ]);
        }

        
    }

     // FUNCTIONS FOR ROUTE MODEL IMPLICIT BINDING 
/*

    public function index()
    {
        return Article::all();
    }

    public function show(Article $article)
    {
        return $article;
    }

    public function store(Request $request)
    {
        $article = Article::create($request->all());

        return response()->json($article, 201);
    }

    public function update(Request $request, Article $article)
    {
        $article->update($request->all());

        return response()->json($article, 200);
    }

    public function delete(Article $article)
    {
        $article->delete();

        return response()->json(null, 204);
    }
    */
}

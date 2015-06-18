<?php namespace App\Http\Controllers;

//use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Comment;
use App\Cases;
use Auth;
use Log;

//use Request;

class CommentController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['comment' => 'required|max:10000']);
        $comment = new Comment;
        $input = $request->all();
        $comment->case_id = $input['case_id'];
        $comment->text = $input['comment'];
        $comment->author_id = Auth::user()->id;
        $comment->save();

        $case = Cases::find($comment->case_id)->touch();

        Log::info(Auth::user()->name . '(' . Auth::user()->server . ')' . ' left a comment at case number ' . $comment->case_id);

        return redirect('/case/' . $comment->case_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}

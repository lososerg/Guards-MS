<?php namespace App\Http\Controllers;

use App\Cases;
use App\Comment;
use Auth;
use Illuminate\Http\Request;
use Log;

//use Request;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, ['comment' => 'required|max:30000']);
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

    public function edit($id)
    {
        $comment = Comment::find($id);

        return view('comments.edit')->with(['comment' => $comment]);
    }

    public function update(Request $request)
    {
        $this->validate($request, ['comment' => 'required|max:30000']);
        $input = $request->all();
        $comment = Comment::find($input['id']);

        $comment->text = $input['comment'];
        //$comment->author_id = Auth::user()->id;
        $comment->save();

        $case = Cases::find($comment->case_id)->touch();

        Log::info(Auth::user()->name . '(' . Auth::user()->server . ') edited a comment #' . $comment->id . ' at case #' . $comment->case_id);

        return '<script>window.opener.location.reload(false); this.close();</script>';
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (isset($comment)) {
            if (!empty($comment)) {
                if (Auth::user()->id === $comment->author_id) {
                    $comment->deleted_at = date("Y-m-d H:i:s", time());
                    $comment->save();
                    Log::info(Auth::user()->name . '(' . Auth::user()->server . ') deleted comment number ' . $comment->id);
                } else {
                    // Do nothing
                }
            }
        }

        return redirect()->back();
    }

}

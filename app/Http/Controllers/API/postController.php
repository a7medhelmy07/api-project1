<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NewPostJob;
use App\Mail\PostMail;
use App\Models\SentPost;
use App\Models\subscribes;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);
        return response()->json($posts);
    }



    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);
        $data = $post->response()->setStatusCode(200);
        $emailPost = subscribes::with('user')->where('website_id',$request->website_id)->get();
        NewPostJob::dispatch($post , $emailPost);
        return $data;
        // return response()->json($post, 201);
    }

    public function show()
    {
        $post = Post::where()->firstOrFail();
        return response()->json($post);
    }

    public function edit($id, Request $request)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return response()->json($post);
    }

    public function postsTrashed()
    {
        $posts = Post::onlyTrashed()->paginate(10);
        return response()->json($posts);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function hdelete($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        return response()->json(['message' => 'Post permanently deleted']);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        return response()->json(['message' => 'Post restored successfully']);
    }

    public function sendPost($postId , $email)
    {
        $sent = sentPost::where('post_id' , $postId)->where('email' , $email)->exisit();
        if (!$sent) {
            $post = Post::findOrFail($postId);
            Mail::to($email)->send(new PostMail($post));

            SentPost::create([
                'post_id'=>$postId,
                'email'=>$email
            ]);
            return response()->json(['message'=>'post sent'],200);

        }else{
            return response()->json(['message'=>'post did not sent'],409);
        }
    }
}


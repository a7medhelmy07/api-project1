<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Website;
use App\Models\subscribes;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Jobs\postJob;
use App\Models\post;



class subscribeController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscription = subscribes::paginate(10);
        return response()->json($subscription);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'user_id' => 'required|exists:users,id',
            'website_id' => 'required|exists:websites,id'
        ]);

        $subscription = subscribes::create([
            'user_id' => $request->user_id,
            'website_id' => $request->website_id,
        ]);
        $data = $subscription->response()->setStatusCode(200);

        $email = auth()->user()->email;
        $posts = post::where('website_id' , $request->website_id)->get();
        PostJob::dispatch($posts , $email);

        return $data;    }

    /**
     * Display the specified resource.
     */
    public function show( $userId)
    {
        $subscription = subscribes::where('user_id' , $userId)->paginate(10);
        return response()->json($subscription);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId ,$websiteId)
    {
        $subscription = subscribes::where('user_id' , $userId)
        ->where('website_id' , $websiteId)
        ->findOrFail();

        $subscription->delete();
        return response()->json(['message' => 'Subscription deleted']);
    }
}

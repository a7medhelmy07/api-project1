<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use Illuminate\Foundation\Validation\ValidatesRequests;
class WebsiteController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $website =Website::paginate(10);
        return response()->json($website);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request ,[
            'name'=>'required|string|max:255',
            'url'=>'required|url',
        ]);

        $website = Website::creat([
            'name' => $request->name,
            'url'=> $request->url
        ]);
        return response()->json($website, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $website = Website::findOrFail($id);
        return response()->json($website);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request ,[
            'name'=>'required|string|max:255',
            'url'=>'required|url',
        ]);
        $website = Website::findOrFail($id);
        $website ->update([
            'name' => $request->name,
            'url'=> $request->url
        ]);
        return response()->json($website);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $website = Website::findOrFail($id);
        $website ->delete();

        return response()->json(['message' => 'website deleted']);

    }
}

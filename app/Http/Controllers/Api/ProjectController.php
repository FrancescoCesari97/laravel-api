<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::select(['id', 'type_id', 'title', 'content', 'image', 'slug'])
            ->orderBy('updated_at', 'DESC')
            ->with(['type:id,label,color', 'technology:id,label,color'])
            ->paginate();

        foreach ($projects as $project) {
            $project->image = !empty($project->image) ? asset('/storage/' . $project->image) : 'https://placehold.jp/600x400.png';
        }

        return response()->json([
            'result' => $projects,
            'success' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $project = Project::select(['id', 'type_id', 'title', 'content', 'image', 'slug'])
            ->where('slug', $slug)
            ->with(['type:id,label,color', 'technology:id,label,color'])
            ->first();

        if (empty($project)) {
            return response()->json([
                'message' => 'project not found',
                'success' => false,
            ]);
        }

        $project->image = !empty($project->image) ? asset('/storage/' . $project->image) : 'https://placehold.jp/600x400.png';

        return response()->json([
            'result' => $project,
            'success' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

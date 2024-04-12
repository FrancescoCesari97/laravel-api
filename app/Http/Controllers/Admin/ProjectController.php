<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = new Project();
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.form', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        // valido la richiesta
        $request->validated();

        // recupero i dati della  richiesta
        $data = $request->all();

        // istanzio un nuovo progetto
        $project = new Project();

        // fillo il progetto con i dati del form
        $project->fill($data);

        // genero lo slug
        $project->slug = Str::slug($project->title);

        // dd($data['image']);

        // dd($img_path);
        // \uploads\projects\7BVUWbAHvkqtKM34ZV0LDgvg5RmJigvzsCJqs8zj.jpg

        // gestisco l'immagine e ne recupero il path
        // se è arrivata l'immagine
        if (Arr::exists($data, 'image')) {
            $img_path = Storage::put('uploads/projects', $data['image']);
            $project->image = $img_path;
        }

        // salvo il progetto in db
        $project->save();

        // relaziono il progetto alle tecnologie associate
        if (Arr::exists($data, 'technologies')) {
            $project->technology()->attach($data['technologies']);
        }

        // $project->technology()->attach($data['technologies']);

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.form', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $request->validated();

        $data = $request->all();

        $project->fill($data);

        if (Arr::exists($data, 'image')) {
            // se ce n'era una prima cancella la vecchia immagine

            if (!empty($project->image)) {
                Storage::delete($project->image);
            }

            // salva la nuova immagine
            $img_path = Storage::put('uploads/projects', $data['image']);
            $project->image = $img_path;
        }

        $project->save();

        if (Arr::exists($data, 'technologies')) {
            $project->technology()->sync($data['technologies']);
        } else {
            $project->technology()->detach();
        }

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        if (!empty($project->image)) {
            Storage::delete($project->image);
        }
        return redirect()->route('admin.projects.index') /* ->with('message-class', 'alert-danger ')->with('message', 'progetto eliminato ') */;
    }

    public function deleteImg(Project $project)
    {
        Storage::delete($project->image);
        $project->image = null;

        $project->save();

        return redirect()->back();
    }
}

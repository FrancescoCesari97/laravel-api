@extends('layouts.app')

@section('title', (empty($project->id) ? 'Creazione' : 'Modifica') . 'project')

@section('content')
    <div class="container">

        <h2 class=" my-4">
            {{ empty($project->id) ? 'Creazione' : 'Modifica' }} progetto
        </h2>

        <form enctype="multipart/form-data"
            action="{{ empty($project->id) ? route('admin.projects.store') : route('admin.projects.update', $project) }}"
            class="py-5 row g-5" method="POST">

            @if (!empty($project->id))
                @method('PATCH')
            @endif

            @csrf

            <div class="col-4">
                <label class="form-label" for="title">Titolo</label>
                <input class="form-control @error('title') is-invalid @enderror" type="text" id="title" name="title"
                    value="{{ old('title', $project->title) }}" {{-- required --}}>

                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="col-4">
                <label class="form-label" for="type_id">Categoria</label>
                <select class="form-select @error('type_id') is-invalid @enderror" name="type_id" id="type_id">
                    <option value="">seleziona una categoria</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}"
                            {{ $type->id == old('type_id', $project->type_id) ? 'selected' : '' }}>
                            {{ $type->label }}
                        </option>
                    @endforeach
                </select>
                @error('type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            <div class="col-4 d-flex align-items-end">

                @foreach ($technologies as $technology)
                    <div class="px-3 ">
                        <input {{ $project->technology->contains($technology->id) ? 'checked' : '' }}
                            id="technologies-{{ $technology->id }}" name="technologies[]" type="checkbox"
                            value="{{ $technology->id }}" class="form-check-input ">
                        <label class="form-check-label" for="technologies-{{ $technology->id }}">{{ $technology->label }}
                        </label>
                    </div>
                @endforeach

            </div>

            <div class="col-12">
                <label class="form-label" for="image">Immagine progetto</label>

                <input class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                    type="file">

                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror


                @if (!empty($project->image) && !empty($project->id))
                    <div class="preview-image-container">
                        <div class="delete-button">
                            <span>x</span>
                        </div>

                        <img class="img-fluid @error('image') is-invalid @enderror"
                            src="{{ asset('storage/' . $project->image) }}" alt="">
                    </div>
                @endif

                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>



            <div class="col-12">
                <label class="form-label" for="content">Contenuto</label>
                <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="5">{{ old('content', $project->content) }}</textarea>
            </div>


            <div class="col-3">

                <button class="btn btn-success">{{ empty($project->id) ? 'Creazione' : 'Modifica' }} progetto</button>
            </div>

        </form>


        @if (!empty($project->id))
            <form class="d-none" method="POST" id="delete-image-form"
                action="{{ route('admin.projects.delete-img', $project) }}">
                @method('DELETE')
                @csrf
            </form>
        @endif
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
    @if (!empty($project->id))
        <script>
            const deleteButton = document.querySelector('.delete-button');
            const deleteImageForm = document.querySelector('#delete-image-form');

            deleteButton.addEventListener('click', () => {
                deleteImageForm.submit();
            })
        </script>
    @endif
@endsection

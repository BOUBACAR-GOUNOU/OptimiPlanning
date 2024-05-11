@extends('master')

@section('content')

<div class="container-fluid">


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 border-left-primary">
        <h1 class="h3 mb-0 mt-4 ml-4 text-gray-800  font-weight-bold ">Importation de fichier</h1>
    </div>
    <p class="mb-4 mt-4">Ce système fonctionne grâce à l'importaion des différents fichiers spécifiés. Veuillez donc les
        importer. </p>

    <!-- alerte de sucess ou erreur -->
    <div class=" mb-4"></div>
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('import.excel') }}" method="post" enctype="multipart/form-data">
        @csrf
        <!-- importation de fichier -->
        <div class="form-group">
            <label for="exampleFormControlFile1">Sélectionner fichier filière</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="etudiant_file">
        </div>
        @error('etudiant_file')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @enderror
        <div class="form-group">
            <label for="exampleFormControlFile1">Sélectionner fichier filière</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="enseignant_file">
        </div>
        @error('enseignant_file')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @enderror
        <div class="form-group">
            <label for="exampleFormControlFile1">Sélectionner fichier filière</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="salle_file">
        </div>
        @error('salle_file')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @enderror
        <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2 mt-3">Importer</button>
        </div>
    </form>


    <!-- bouton suivant  -->
    <div class="row justify-content-end mb-5 ">
        <div class="col-auto">
            <a href="constitution.html" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">Suivant</span>
            </a>
        </div>
    </div>
</div>
@endsection
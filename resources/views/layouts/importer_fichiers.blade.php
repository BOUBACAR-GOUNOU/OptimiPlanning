@extends('master')

@section('content')

    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 border-left-primary">
            <h1 class="h3 mb-0 mt-4 ml-4 text-gray-800  font-weight-bold ">Importation de fichier</h1>
        </div>
        <p class="mb-4 mt-4">Ce système fonctionne grâce à l'importaion des différents fichiers spécifiés. Veuillez donc les importer. </p>

        <div class="card shadow mb-4"></div>

        <!-- importation de fichier -->
        <div class="form-group">
            <label for="exampleFormControlFile1">Sélectionner fichier filière</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Sélectionner fichier filière</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Sélectionner fichier filière</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2 mt-3">Importer</button>
        </div>


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

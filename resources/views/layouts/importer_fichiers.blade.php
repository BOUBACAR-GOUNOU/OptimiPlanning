@extends('master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 border-left-primary">
        <h1 class="h3 mb-0 mt-4 ml-4 text-gray-800  font-weight-bold ">Importation de fichier</h1>
    </div>
    <p class="mb-4 mt-4">Ce système fonctionne grâce à l'importation des différents fichiers spécifiés. Veuillez donc les
        importer. </p>

    <!-- alerte de succès ou erreur -->
    <div class="mb-4">
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
    </div>

    <!-- Formulaire d'importation -->
    <form id="importForm" action="{{ route('import.excel') }}" method="post" enctype="multipart/form-data">
        @csrf
        <!-- Importation de fichier -->
        <div class="form-group">
            <label for="etudiantFile">Sélectionner fichier étudiant</label>
            <input type="file" class="form-control-file" id="etudiantFile" name="etudiant_file">
            <div class="progress mt-2" style="display: none;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0"
                    aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="enseignantFile">Sélectionner fichier enseignant</label>
            <input type="file" class="form-control-file" id="enseignantFile" name="enseignant_file">
        </div>

        <div class="form-group">
            <label for="salleFile">Sélectionner fichier salle</label>
            <input type="file" class="form-control-file" id="salleFile" name="salle_file">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2 mt-3">Importer</button>
        </div>
    </form>

    <!-- Bouton suivant -->
    <div class="row justify-content-end mb-5">
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

@push('scripts')
<script>
    // Événement de soumission du formulaire
    document.getElementById('importForm').addEventListener('submit', function(event) {
        // Affichage de la barre de progression
        var progressBar = document.querySelector('.progress');
        progressBar.style.display = 'block';

        // Simulation de l'importation pendant 20 secondes (à remplacer par votre logique d'importation réelle)
        var progress = 0;
        var interval = setInterval(function() {
            progress += 5;
            if (progress <= 100) {
                progressBar.querySelector('.progress-bar').style.width = progress + '%';
                progressBar.querySelector('.progress-bar').setAttribute('aria-valuenow', progress);
            } else {
                clearInterval(interval);
                progressBar.style.display = 'none'; // Cacher la barre de progression une fois terminée
                // Afficher le message de succès ou d'erreur (simulé ici)
                var success = Math.random() < 0.5; // Simuler une importation réussie ou échouée
                if (success) {
                    document.querySelector('.alert-success').style.display = 'block';
                } else {
                    document.querySelector('.alert-danger').style.display = 'block';
                }
            }
        }, 1000);
        
        // Empêcher la soumission du formulaire par défaut
        event.preventDefault();
    });
</script>
@endpush

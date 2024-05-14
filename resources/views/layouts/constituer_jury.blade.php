@extends('master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 border-left-primary">
        <h1 class="h3 mb-0 mt-4 ml-4 text-gray-800  font-weight-bold ">Constitutions de Jury</h1>
    </div>
    <p class="mb-4 mt-4">La constitions des jury se fait de manière automatique grâce à nos algos tout en tenant compte
        des points suivant : </p>
    <div class="mb-5">


        <div class="mb-2">
            <a href="#" class="btn btn-primary btn-circle btn-sm">
                <i class="fas fa-info-circle"></i>
            </a> <span>Les enseignants ne peuvent pas être dans le jury de leur propre étudiant.</span>
        </div>

        <div class="mb-2">
            <a href="#" class="btn btn-primary btn-circle btn-sm">
                <i class="fas fa-info-circle"></i>
            </a> <span>Les enseignants sont dans le jury de leur propre étudiant.</span>
        </div>

        <div class="mb-2">
            <a href="#" class="btn btn-primary btn-circle btn-sm">
                <i class="fas fa-info-circle"></i>
            </a> <span>Les enseignants ne peuvent pas être dans le jury de leur propre étudiant.</span>
        </div>

        <div class="mb-2">
            <a href="#" class="btn btn-primary btn-circle btn-sm">
                <i class="fas fa-info-circle"></i>
            </a> <span>Les enseignants sont dans le jury de leur propre étudiant.</span>
        </div>


    </div>


    <!-- Liste -->
    <div class="card shadow mb-4">

    </div>

    <div class="mb-4">
        @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
        @endif

        <!-- Affichage du message d'erreur -->
        @if (session('error'))
        <div class="error-message ">
            {{ session('error') }}
        </div>
        @endif
    </div>

    <div class=" mb-5">
        <form action="{{ route('maker.jury') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="date">Date de début des soutenances</label>
                <input type="date" class="form-control form-control-user rounded-pill" id="date" name="date"
                    placeholder="Date début" style="width: 200px;" required>
                @error('date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <button class="btn btn-primary" type="submit">Générer</button>
        </form>
    </div>

    <!-- bouton suivant  -->
    <div class="row justify-content-end mb-5  ">
        <div class="col-auto">

            <a class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">Suivant</span>
            </a>

        </div>
    </div>

</div>

@endsection
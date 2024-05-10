@extends('master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 border-left-primary">
        <h1 class="h3 mb-0 mt-4 ml-4 text-gray-800  font-weight-bold ">Constitutions de Jury</h1>
    </div>
    <p class="mb-4 mt-4">La constitions des jury se fait de manière automatique grâce à nos algos tout en tenant compte des points suivant :  </p>
    <div class="mb-5" >
        <div class="mb-2" >
            <a href="#" class="btn btn-primary btn-circle btn-sm">
                <i class="fas fa-info-circle" ></i>
            </a> <span>Les enseignants ne peuvent pas être dans le jury de leur propre étudiant.</span>
        </div>

        <div class="mb-2" >
            <a href="#" class="btn btn-primary btn-circle btn-sm">
                <i class="fas fa-info-circle" ></i>
            </a> <span>Les enseignants sont dans le jury de leur propre étudiant.</span>
        </div>

        <div class="mb-2" >
            <a href="#" class="btn btn-primary btn-circle btn-sm">
                <i class="fas fa-info-circle" ></i>
            </a> <span>Les enseignants ne peuvent pas être dans le jury de leur propre étudiant.</span>
        </div>

        <div class="mb-2" >
            <a href="#" class="btn btn-primary btn-circle btn-sm">
                <i class="fas fa-info-circle" ></i>
            </a> <span>Les enseignants sont dans le jury de leur propre étudiant.</span>
        </div>


    </div>


    <!-- Liste -->
    <div class="card shadow mb-4">

    </div>

    <div class=" mb-5" >
        <button class="btn btn-primary" type="submit">Générer</button>
    </div>

    <!-- bouton suivant  -->
    <div class="row justify-content-end mb-5  ">
        <div class="col-auto">
            <a href="generation.html" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                <span class="text">Suivant</span>
            </a>
        </div>
    </div>

</div>

@endsection

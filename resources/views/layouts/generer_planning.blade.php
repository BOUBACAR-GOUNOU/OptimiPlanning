@extends('master')

@section('content')

    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 border-left-primary">
            <h1 class="h3 mb-0 mt-4 ml-4 text-gray-800  font-weight-bold ">Génération du planning</h1>
        </div>
        <p class="mb-4 mt-4">La génération de planning est la dernière étape de la procedure de plannification. Les données sont généreé en fonction de :  </p>
        <div class="mb-5" >
            <div class="mb-2" >
                <a href="#" class="btn btn-primary btn-circle btn-sm">
                    <i class="fas fa-info-circle" ></i>
                </a> <span>Des enseignants.</span>
            </div>

            <div class="mb-2" >
                <a href="#" class="btn btn-primary btn-circle btn-sm">
                    <i class="fas fa-info-circle" ></i>
                </a> <span>Salles.</span>
            </div>

            <div class="mb-2" >
                <a href="#" class="btn btn-primary btn-circle btn-sm">
                    <i class="fas fa-info-circle" ></i>
                </a> <span>Jury.</span>
            </div>

            <div class="mb-2" >
                <a href="#" class="btn btn-primary btn-circle btn-sm">
                    <i class="fas fa-info-circle" ></i>
                </a> <span>Date et heures de soutenance.</span>
            </div>



            <!-- trait -->
            <div class="card shadow mb-4">

            </div>

            <!-- Boutton de génération -->
            <div class=" mb-10" >
                <button class="btn btn-primary" type="submit">Générer</button>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>

@endsection

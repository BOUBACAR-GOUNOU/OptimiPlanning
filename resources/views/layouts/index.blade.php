@extends('master')

@section('content')

    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 border-left-primary">
            <h1 class="h3 mb-0 mt-4 ml-4 text-gray-800  font-weight-bold ">Planning de soutenance</h1>
        </div>
        <p class="mb-4 mt-4">Ce planning a été généré automatiquement à partir du système. Il peut être modifier à partir des options présentes. </p>


        <!-- Liste -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">#</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Noms des binômes</th>
                            <th>Thème</th>
                            <th>Salle de soutenance</th>
                            <th>Heure et Dates de soutenance</th>
                            <th>Membre de Jury</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Emanuel & Merveille</td>
                            <td>Plateforme d'optimisation</td>
                            <td>Salle 10</td>
                            <td>2011/04/25 à 08h30</td>
                            <td><p> Dr X </p>
                                <p> Ph X </p>
                                <p> M X </p>
                            </td>
                            <td>Modif | Sup </td>
                        </tr>
                        <tr>
                            <td>Emanuel & Merveille</td>
                            <td>Plateforme d'optimisation</td>
                            <td>Salle 10</td>
                            <td>2011/04/25 à 08h30</td>
                            <td><p> Dr X </p>
                                <p> Ph X </p>
                                <p> M X </p>
                            </td>
                            <td>Modif | Sup </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 border-left-primary">
        <h1 class="h3 mb-0 mt-4 ml-4 text-gray-800 font-weight-bold">Planning de soutenance</h1>
    </div>
    <p class="mb-4 mt-4">Ce planning a été généré automatiquement à partir du système. Il peut être modifié à partir des
        options présentes.</p>

    <!-- Liste -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">#</h6>
            <div class="mt-3 mb-3">
                <button class="btn btn-primary ml-auto" id="printButton"><i class="fas fa-print"></i> Imprimer</button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered print-only" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <div class="input-group justify-content-end mt-3 mb-3 mr-5">
                            <select class="custom-select col-3" id="inputGroupSelect03">
                                <option selected disabled>Filière</option>
                                <option value="GT-TIC">GT-TIC</option>
                                <option value="IIM">IIM</option>
                                <option value="ELN">ELN</option>
                                <option value="ELT">ELT</option>
                            </select>
                            <select class="custom-select col-3" id="inputGroupSelect04">
                                <option selected disabled>Période</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                            <div class="input-group-append ml-2">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <h2 class="print-only text-dark">Programme des soutenances filière : GT-TIC</h2>
                        <tr>
                            <th>Noms des binômes</th>
                            <th>Thème</th>
                            <th>Salle de soutenance</th>
                            <th>Heure et Dates de soutenance</th>
                            <th>Membre de Jury</th>
                            <th class="no-print">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($planifications as $planification)
                        <tr class="text-center">
                            @foreach($binomes as $binome)
                            @if($binome->id == $planification->id_binome)
                            <td>{{ $binome->binome1 }} <br> {{ $binome->binome2 }}</td>
                            @break
                            @endif
                            @endforeach
                            @foreach($binomes as $binome)
                            @if($binome->id == $planification->id_binome)
                            <td>{{ $binome->theme }}</td>
                            @break
                            @endif
                            @endforeach
                            <td>{{ $planification->salle }}</td>
                            <td>{{ $planification->date_soutenance }} <br> à <br> {{ $planification->heure_soutenance }}
                            </td>
                            <td>
                                <p>Président : {{ $planification->president }}</p>
                                <p>Examinateur : {{ $planification->examinateur }}</p>
                                <p>Rapporteur : {{ $planification->rapporteur }}</p>
                            </td>
                            <td class="exclude-from-print">
                                <button class="btn edit-button" data-toggle="modal" data-target="#editModal"
                                    data-id="{{ $planification->id }}" data-binome1="{{ $binome->binome1 }}"
                                    data-binome2="{{ $binome->binome2 }}" data-theme="{{ $binome->theme }}"
                                    data-salle="{{ $planification->salle }}"
                                    data-date="{{ $planification->date_soutenance }}"
                                    data-heure="{{ $planification->heure_soutenance }}"
                                    data-president="{{ $planification->president }}"
                                    data-examinateur="{{ $planification->examinateur }}"
                                    data-rapporteur="{{ $planification->rapporteur }}">
                                    <h4 class="text-primary"><i class="fas fa-edit"></i></h4>
                                </button>
                                <a href="" class="btn" data-toggle="tooltip" data-placement="top" title="Supprimer"
                                    onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')) { document.getElementById('deleteUserForm{{$planification->id }}').submit(); }">
                                    <h4 class="text-danger"><i class="fas fa-trash"></i></h4>
                                </a>
                                <form id="deleteUserForm{{ $planification->id }}" action="" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editForm" method="POST" action="{{ route('planifications.update', $planification->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modifier la planification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="binome1">Binôme 1</label>
                        <input type="text" class="form-control" id="binome1" name="binome1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="binome2">Binôme 2</label>
                        <input type="text" class="form-control" id="binome2" name="binome2" readonly>
                    </div>
                    <div class="form-group">
                        <label for="theme">Thème</label>
                        <input type="text" class="form-control" id="theme" name="theme" readonly>
                    </div>
                    <div class="form-group">
                        <label for="president">Président</label>
                        <select class="form-control" id="president" name="president">
                            @foreach($enseignants as $enseignant)
                            <option value="{{ $enseignant->nom }}">{{ $enseignant->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="examinateur">Examinateur</label>
                        <select class="form-control" id="examinateur" name="examinateur">
                            @foreach($enseignants as $enseignant)
                            <option value="{{ $enseignant->nom }}">{{ $enseignant->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rapporteur">Rapporteur</label>
                        <input type="text" class="form-control" id="rapporteur" name="rapporteur" readonly>
                    </div>

                    <div class="form-group">
                        <label for="salle">Salle de soutenance</label>
                        <select class="form-control" id="salle" name="salle">
                            @foreach($salles as $salle)
                            <option value="{{ $salle->salle }}"
                                {{ $planification->salle == $salle->salle ? 'selected' : '' }}>{{ $salle->salle }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date">Date de soutenance</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <div class="form-group">
                        <label for="heure">Heure de soutenance</label>
                        <input type="time" class="form-control" id="heure" name="heure">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.edit-button').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const binome1 = this.getAttribute('data-binome1');
        const binome2 = this.getAttribute('data-binome2');
        const theme = this.getAttribute('data-theme');
        const salle = this.getAttribute('data-salle');
        const date = this.getAttribute('data-date');
        const heure = this.getAttribute('data-heure');
        const president = this.getAttribute('data-president');
        const examinateur = this.getAttribute('data-examinateur');
        const rapporteur = this.getAttribute('data-rapporteur');

        document.getElementById('editId').value = id;
        document.getElementById('binome1').value = binome1;
        document.getElementById('binome2').value = binome2;
        document.getElementById('theme').value = theme;
        document.getElementById('salle').value = salle;
        document.getElementById('date').value = date;
        document.getElementById('heure').value = heure;
        document.getElementById('president').value = president;
        document.getElementById('examinateur').value = examinateur;
        document.getElementById('rapporteur').value = rapporteur;

        // Set the form action URL dynamically
        document.getElementById('editForm').action = '/planifications/' + id;
    });
});

document.getElementById('printButton').addEventListener('click', function() {
    window.print();
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>
document.getElementById('downloadButton').addEventListener('click', function() {
    var doc = new jsPDF();
    doc.autoTable({
        html: '#dataTable'
    });
    doc.save('tableau.pdf');
});

window.onbeforeprint = function() {
    var elementsToExclude = document.querySelectorAll('.exclude-from-print');
    elementsToExclude.forEach(function(element) {
        element.classList.add('exclude-from-print');
    });
};

window.onafterprint = function() {
    var elementsToExclude = document.querySelectorAll('.exclude-from-print');
    elementsToExclude.forEach(function(element) {
        element.classList.remove('exclude-from-print');
    });
};
</script>

@endsection
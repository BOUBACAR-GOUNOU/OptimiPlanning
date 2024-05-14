@extends('master')

@section('content')

<div class="container-fluid">


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 border-left-primary">
        <h1 class="h3 mb-0 mt-4 ml-4 text-gray-800  font-weight-bold ">Planning de soutenance</h1>
    </div>
    <p class="mb-4 mt-4">Ce planning a été généré automatiquement à partir du système. Il peut être modifier à partir
        des options présentes. </p>


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
                                <option value="GT-TIC"> GT-TIC</option>
                                <option value="IIM">IIM</option>
                                <option value="ELN">ELN</option>
                                <option value="ELT">ELT</option>
                            </select>
                            <select class="custom-select col-3" id="inputGroupSelect04">
                                <option selected disabled>Période</option>
                                <option value="2023"> 2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                            <div class="input-group-append ml-2">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>



                        <h2 class=" print-only text-dark">Pogramme des soutenances filière :  GT-TIC</h2>
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
                            @if($binome->id == $planification ->id_binome)
                            <td> {{ $binome->binome1 }} <br> {{ $binome->binome2 }}</td>
                            @break
                            @endif
                        @endforeach
                        @foreach($binomes as $binome)
                            @if($binome->id == $planification ->id_binome)
                            <td> {{ $binome->theme }}</td>
                            @break
                            @endif
                        @endforeach
                            <td>{{ $planification->salle}}</td>
                            <td >{{ $planification->date_soutenance}}  <br> à
                            <br > {{ $planification->heure_soutenance}}</td>
                            <td>
                            
                                <p> Président :  {{ $planification->president }} </p>
                                <p> Examinateur : {{ $planification->examinateur }} </p>
                                <p> Rapporteur {{ $planification->rapporteur }} </p>
                            </td>
                            
                            <td class="exclude-from-print">Modif | Sup </td>
                        </tr>
                    @endforeach
                        

                    </tbody>
                </table>
            
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('searchButton').addEventListener('click', function() {
    var selectedOption = document.getElementById('inputGroupSelect04').value;
    window.location.href =
        ""
        .replace(':id', selectedOption);
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>
document.getElementById('printButton').addEventListener('click', function() {
    window.print();
});

document.getElementById('downloadButton').addEventListener('click', function() {
    var doc = new jsPDF();
    doc.autoTable({
        html: '#dataTable'
    });
    doc.save('tableau.pdf');
});
</script>
<script>
// Appliquer la classe exclude-from-print aux éléments lors de l'impression
window.onbeforeprint = function() {
    var elementsToExclude = document.querySelectorAll('.exclude-from-print');
    elementsToExclude.forEach(function(element) {
        element.classList.add('exclude-from-print');
    });
};

// Supprimer la classe exclude-from-print des éléments après l'impression
window.onafterprint = function() {
    var elementsToExclude = document.querySelectorAll('.exclude-from-print');
    elementsToExclude.forEach(function(element) {
        element.classList.remove('exclude-from-print');
    });
};
</script>

@endsection
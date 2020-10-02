@extends('layout.layout-main')

@section('mainSection', 'testWare')

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <x-dashborarditem>
                <h2 class="h5">Prüfungen</h2>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Gerät</th>
                        <th>Vorgang</th>
                        <th>Fällig</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(\App\ControlEquipment::all() as $controlEquipment)
                        <tr>
                            <td>
                                <a href="{{ route('equipment.show',$controlEquipment->Equipment) }}"> {{ $controlEquipment->Equipment->produkt->prod_name_kurz }}</a>
                                <br>
                                <x-notifyer>Inventar-Nr: {{ $controlEquipment->Equipment->eq_inventar_nr }}</x-notifyer>
                            </td>
                            <td>{{ $controlEquipment->AnforderungControlItem->aci_name_lang }}</td>
                            <td>{!! $controlEquipment->checkDueDate($controlEquipment) !!}</td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-notifyer>Keine Vorgänge verfügbar!</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </x-dashborarditem>
            <x-dashborarditem>
                <h2 class="h5"><a href="#">Mitteilungen</a></h2>
                <x-systemmessage msg="Hier ist was passiert!!!!"/>
                <x-systemmessage msg="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, alias autem doloribus dolorum eligendi est, et fugit illum iure molestias nam neque nulla quisquam repellat tempore unde ut vitae voluptate?"/>
                <x-systemmessage msg="Hier ist was passiert!!!!"/>
                <x-systemmessage msg="Hier ist was passiert!!!!"/>
            </x-dashborarditem>
        </div>
        <div class="row">
            <x-dashborarditem>
                <h2 class="h5">Geräte</h2>
                <div class="card p-2 mb-3">
                    <p class="lead">80% der Geräte sind einsatzbereit</p>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-warning " style="width: 80%;" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                    </div>
                    <hr class="dropdown-divider">
                    @foreach (App\Location::all() as $location)
                        <?php $per = random_int(75,100);
                        if ($per > 90 ) $class = 'bg-success text-light';
                        if ($per <=90 && $per >= 80 ) $class = 'bg-warning text-light';
                        if ($per < 80 ) $class = 'bg-danger text-light';
                        ?>
                        <div class="small bm-2 p-2">Standort: {{ $location->l_name_kurz }}
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar {{ $class }}" style="width: {{ $per }}%;" role="progressbar" aria-valuenow="{{ $per }}" aria-valuemin="0" aria-valuemax="100">{{ $per }}%</div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </x-dashborarditem>
            <x-dashborarditem>
                <h2 class="h5">Schadensmeldungen</h2>
                <div class="card p-2 mb-3">
                    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
                    <nav>
                        <div class="nav nav-pills justify-content-end" id="nav-tab" role="tablist">
                            <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Woche</a>
                            <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Monat</a>
                            <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Jahr</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <canvas id="myChart" aria-label="Schadensmeldungen pro Woche" role="img"></canvas>
                            <script>
                                const dmgItemWeek = document.getElementById('myChart').getContext('2d');
                                const dmgWeek = new Chart(dmgItemWeek, {
                                    type: 'bar',

                                    // The data for our dataset
                                    data: {

                                        labels: ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'],
                                        datasets: [{
                                            label: 'Schadensmeldungen',
                                            backgroundColor: 'rgb(255,20,68,002)',
                                            borderColor: 'rgb(96,17,34)',
                                            data: [0, 1, 1, 8, 2, 1, 0],
                                            borderWidth:2,
                                            borderSkipped:'bottom',
                                        }]
                                    },

                                    // Configuration options go here
                                    options: {}
                                });
                            </script>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                            <canvas id="myChart4"></canvas>
                            <script>
                                const dmgItemMonth = document.getElementById('myChart4').getContext('2d');
                                const chartMonth = new Chart(dmgItemMonth, {
                                    type: 'bar',

                                    // The data for our dataset
                                    data: {

                                        labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9','10','11','12','13'],
                                        datasets: [{
                                            label: 'Schadensmeldungen',
                                            backgroundColor: 'rgb(255,20,68,002)',
                                            borderColor: 'rgb(96,17,34)',
                                            data: [0, 4, 3, 8, 2, 1, 4,1,4,3,2,1,4],
                                            borderWidth:2,
                                            borderSkipped:'bottom',
                                        }]
                                    },

                                    // Configuration options go here
                                    options: {}
                                });
                            </script>

                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
                    </div>
                </div>
            </x-dashborarditem>
        </div>

    </div>
@endsection


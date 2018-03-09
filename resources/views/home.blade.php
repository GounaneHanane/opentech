@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/search.js"></script>
    <script  src="/js/delete.js"></script>
    <link rel="stylesheet" href="/css/alerte.css"/>
    <script  src="/js/chart.js"></script>
@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body">
        <div class="panel">
            <div class="panel-heading">
                <div class="form" style="margin-top: 0%;">
                    <h3><strong>Alerts d'expiration</strong></h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-div">
                    <table class="table table-bordered" id="vehicles_table">
                        <thead>
                        <tr>
                            <th class="text-center" style="width:12.5%">NOM</th>
                            <th class="text-center" style="width:12.5%">TELEPHONE</th>
                            <th class="text-center" style="width:12.5%">CONTACT</th>
                            <th class="text-center" style="width:12.5%">TEL CONTACT</th>
                            <th class="text-center" style="width:12.5%">ADRESSE</th>
                            <th class="text-center" style="width:12.5%">DATE DE FIN</th>
                            <th class="text-center" style="width:12.5%">PRIX</th>
                            <th class="text-center" style="width:12.5%">COCHER</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
    </script>
    <canvas id="myChart" width="400" height="400"></canvas>
    <script src="path/to/chartjs/dist/Chart.js"></script>
    @endsection
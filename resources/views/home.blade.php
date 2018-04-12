@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/search.js"></script>
    <script  src="/js/add_contrat.js"></script>
    <script src="/js/alert.js"></script>
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
                    <div class="form-group col-md-3">

                    <select id="alert" class="selectpicker">
                        <option value="7">Semaine</option>
                        <option value="15">15 jours</option>
                        <option value="30">1 mois</option>
                        <option value="90">3 mois</option>
                    </select>

                    </div>

                </div>
            </div>


            <div class="panel-body">
                <div class="table-div">
                    <table class="table table-bordered" id="vehicles_table">
                        <thead>
                        <tr>
                            <th class="text-center" style="width:12.5%">NOM</th>
                            <th class="text-center" style="width:12.5%">CONTACT</th>
                            <th class="text-center" style="width:12.5%">TEL CONTACT</th>
                            <th class="text-center" style="width:12.5%">ADRESSE</th>
                            <th class="text-center" style="width:12.5%">DATE DE FIN</th>
                            <th class="text-center" style="width:12.5%">PRIX</th>
                            <th class="text-center" style="width:12.5%">TailleDeParc</th>
                            <th class="text-center" style="width:12.5%">COCHER</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alert as $a)
                        <tr>
                            <td class="text-center" style="width:12.5%">{{$a->name}}</th>
                            <td class="text-center" style="width:12.5%">{{$a->contact}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->phone_number}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->adress}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->end_contract}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->price}}</td>
                            <td class="text-center" style="width:12.5%">{{$a->park}}</td>

                            <td class="text-center" style="width:12.5%">
                                <a onclick="renewal({{ $a->id }})">
                                <span class="btn btn-success glyphicon glyphicon-ok"  onclick="document.getElementById('add_dialog').showModal();"  style=" float: inherit;"></span>
                                </a>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <dialog id="add_dialog"  class="abonnement_dialog add_dialog ">

        <div class="container-fluid body">
            <div class="panel">
                <div id="add_title">
                    <h4>Ajouter un Contrat</h4>
                </div>



                <div class="panel-body">
                    <div class="form" >

                        <form id="contrat">

                            <div>
                                <input type="date" class="form-control" id="dated" name="dated" value="{{date('Y-m-d')}}">
                            </div>
                            <div class="form-group" style="    width: 41%;margin-top: 3%">
                                <select size="10" id="OldVehicles" name="OldVehicles" class="form-control selectpicker">
                                </select>
                            </div>
                            <div class="form-group" style="     margin-left: 43%; margin-top: -37%;">
                               <button type="button" class="form-control" id="AllOut" style="width: 17%"><<</button>
                                <button type="button" class="form-control" id="OneOut" style="width:17%"><</button>
                                <button type="button" class="form-control" id="OneIn" style="width: 17%">></button>
                                <button type="button" class="form-control" href="#" id="AllIn" style="width: 17%">>></button>
                            </div>

                            <div class="form-group" style="    width: 37%;margin-left: 57%;margin-top: -33%;">
                                <select size="10" id="NewVehicles" name="NewVehicles" data-live-search="true" tabindex="-98" class="form-control selectpicker">
                                </select>
                            </div>

                            <span >Nombre de Vehicules :</span>
                            <span id="NbVehicles" alt=""></span>

                        </form>

                        <form id="vehicles" method="POST">
                            <input type="hidden" id="GammeToken"   name="_token" value="{{ csrf_token() }}">
                            <div >

                                <div class="form-group" style="    width: 25%;    margin-bottom: -7%;">
                                    <input type="Text" value="Avancé"  id="Advanced"disabled class="form-control">
                                </div>

                                <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                    <input type="number"  class="form-control"  placeholder="Nombre des vehicules" id="nbVehiclesAdvanced" value="0" min="0" step="1" >


                                </div>

                                <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">

                                    <input type="text" id="defaultAdvanced"  class="form-control"  placeholder="Defaut" >

                                </div>
                                <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">
                                    <input type="text"  class="form-control" id="priceVehiclesAdvanced"  placeholder="Prix" >

                                </div>

                            </div>
                            <div  style="margin-bottom: 11%;">

                                <div class="form-group" style="    width: 25%;    margin-bottom: -7%;">
                                    <input type="Text" value="simple" id="Simple" disabled class="form-control">

                                </div>

                                <div class="form-group" style="    width: 25%;    margin-left: 25%;">
                                    <input type="number" min="0" step="1"  class="form-control" id="nbVehiclesSimple"  value="0" placeholder="Nombre des vehicules" >

                                </div>
                                <div class="form-group" style="    width: 25%;margin-left: 49%;margin-top: -49px;">

                                    <input type="text" id="defaultSimple" class="form-control"  placeholder="Defaut" >
                                </div>
                                <div class="form-group" style="    width: 20%; margin-left: 73%;   margin-top: -49px">
                                    <input type="text"  class="form-control" id="priceVehiclesSimple"  placeholder="Prix" >

                                </div>

                            </div>

                            <center><button class="btn btn-info" type="button" id="AddDetailGamme" >Enregistrer</button></center>
                        </form>
                        <center> <button class="btn btn-info" id="btnCancel" onclick="document.getElementById('add_dialog').close();">Cancel</button></center>
                    </div>


                </div>




            </div>
        </div>


    </dialog>
    @endsection
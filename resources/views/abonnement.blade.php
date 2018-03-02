@extends('layout')

@section('title', 'Abonnement')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css" />
    <script  src="/js/delete.js"></script>

@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
    <div class="container-fluid body">

        <div class="panel">
            <div class="panel-heading">
                <div class="form" style="margin-top: 0%;" >
                    <h3><strong>Les abonnements</strong></h3>
                </div>





                <span class="glyphicon glyphicon-plus edit" id="add_abonnement"></span>
            </div>

            <div class="panel-body">

                <div class="table-div">
                    <table class="table table-bordered" id="vehicles_table">
                        <thead>
                        <tr>
                            <th class="text-center" style="width:16.66%">TYPE D'ABONNEMENT</th>
                            <th class="text-center" style="width:16.66%">TYPE DE CLIENT</th>
                            <th class="text-center" style="width:16.66%">PRIX</th>
                            <th class="text-center" style="width:16.66%">NOMBRE DE CLIENTS</th>
                            <th class="text-center" style="width:16.66%">NOMBRE DE VEHICULES</th>
                            <th class="text-center" style="width:16.66%">COCHER</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($abonnement as $A)
                            <tr id="{{ $A->id }}" style="cursor: pointer;" >


                                <td class="text-center">{{ $A->ClientType}}</td>
                                <td class="text-center">{{ $A->AbonnementType}}</td>
                                <td class="text-center">{{ $A->price }}</td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"><a class="btn btn-danger" href="{{URL::to('/deleteAbonnement/'.$A->id) }}"> <span class="glyphicon glyphicon-trash edit trash " ></span></a>
                                    <a class=" btn btn-primary"  id="edit_abonnement"><span class="glyphicon glyphicon-pencil edit edit_pencil "></span></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <dialog id="add_dialog"  class="abonnement_dialog add_dialog">

        <div class="container-fluid body">
            <div class="panel">

                    <h4>Ajouter une abonnement</h4>

                <div class="panel-body">
                    <div class="form" >

                        <form method="POST" action="/add_type" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <select name="type_abonnement" class="form-control">
                                    <option disabled selected>Type d'abonnement</option>
                                    @foreach ($abonnementTypes as $AbonnementType)
                                        <option value="{{$AbonnementType->AbonnementTypeId}}">{{ $AbonnementType->AbonnementType}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="type_client" class="form-control">
                                    <option disabled selected>Type de client</option>
                                    @foreach ($clientTypes as $ClientType)
                                        <option value="{{$ClientType->ClientTypeId}}">{{ $ClientType->ClientType}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="price" placeholder="Prix" name="price">
                            </div>
                            <center><button class="btn btn-info" onclick="window.open('abonnements.html','_self');">Ajouter</button>

                            </center>
                        </form>
                        <center><button class="btn btn-info" type="button"id="add_cancel" >Cancel</button></center>
                    </div>
                </div>
                </div>
            </div>

    </dialog>
    <dialog id="edit_dialog"  class="abonnement_dialog edit_dialog">

        <div class="container-fluid body">
            <div class="panel">

                    <h4>Modifier une abonnement</h4>

                <div class="panel-body">
                    <div class="form" >

                        <form >
                            <div class="form-group">
                                <select name="type_abonnement" class="form-control">
                                    <option disabled selected>Type d'abonnement</option>
                                    @foreach ($abonnementTypes as $AbonnementType)
                                        <option value="{{$AbonnementType->AbonnementTypeId}}">{{ $AbonnementType->AbonnementType}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="type_client" class="form-control">
                                    <option disabled selected>Type de client</option>
                                    @foreach ($clientTypes as $ClientType)
                                        <option value="{{$ClientType->ClientTypeId}}">{{ $ClientType->ClientType}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="prix" placeholder="Prix" name="prn">
                            </div>
                            <center><button class="btn btn-info">Modifier</button>
                            </center>
                        </form>
                        <center>
                        <button class="btn btn-info" id="edit_cancel" >Cancel</button>
                        </center>
                    </div>
                </div>
                </div>
            </div>

    </dialog>
    <script>
        (function() {
            var addButton = document.getElementById('add_abonnement');
            var updateButton = document.getElementById('edit_abonnement');
            var EditCancelButton = document.getElementById('edit_cancel');
            var AddCancelButton = document.getElementById('add_cancel');
            // Update button opens a modal dialog
            updateButton.addEventListener('click', function() {
                document.getElementById('edit_dialog').showModal();
            });
            addButton.addEventListener('click', function() {
                document.getElementById('add_dialog').showModal();
            });
            // Bouton pour fermer la boîte de dialogue
            EditCancelButton.addEventListener('click', function() {
                document.getElementById('edit_dialog').close();
            });
            AddCancelButton.addEventListener('click', function() {
                document.getElementById('add_dialog').close();
            });
        })();
    </script>
  	@endsection
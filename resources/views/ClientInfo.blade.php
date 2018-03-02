@extends('layout')

@section('title', 'Client')

@section('import')
    @parent
    <link rel="stylesheet" href="/css/form.css"/>
    <script  src="/js/search.js"></script>
    <script  src="/js/delete.js"></script>

@endsection


@section('sidebar')
    @parent

@endsection

@section('content')
<div class="container-fluid body">
    <div class="panel">
        <div class="panel-heading"></div>
        <div class="panel-body" style="margin-top: 10%;">
            <form class="form" onsubmit="event.preventDefault();" method="post">
                <table id="client_info">
                    <tr>
                        <div class="form-group">
                            <td><label>Nom : </label></td>
                            <td><label id="nom"></label></td><br>
                        </div></tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Télèphone : </label></td>
                            <td><label id="ville"></label></td><br>
                        </div></tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Type de client : </label></td>
                            <td><label id="type"></label></td><br>
                        </div></tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Mail : </label></td>
                            <td><label id="mail"></label></td>
                        </div></tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Ville : </label></td>
                            <td><label id="ville"></label></td>
                        </div></tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Contact : </label></td>
                            <td><label id="contact"></label>	</td>
                        </div></tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Tèl contact: </label></td>
                            <td><label id="Tel_contact"></label></td>
                        </div></tr>
                    <div class="form-group">
                        <td><label>Adresse : </label></td>
                        <td><label id="adresse"></label>	</td>
                    </div></tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Nombre de vehicule : </label></td>
                            <td><label id="taille_de"></label>	</td>
                        </div></tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Total de prix : </label></td>
                            <td><label id="taille_de"></label>	</td>
                        </div></tr>
                </table>
                <div class="form-group buttons">
                    <button class="form-control btn btn-info">Contrat</button>
                    <button class="form-control btn btn-info" onclick="window.open('editClient.html','_self')">Modifier le client</button>
                    <button class="btn btn-info">Supprimer le client</button>
                    </center>
                </div>
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="form-group">
                            <table>
                                <form class="form">
                                    <select class="form-control col-sm-3" style=" width: 35%; margin-left: 4%;">
                                        <option value="matricule" disabled selected>Rechercher par --</option>
                                        <option value="matricule">Matricule</option>
                                        <option value="matricule">Type de boîtier</option>
                                    </select>
                                    <input type="text" name="search" class="form-control col-sm-3" style=" width: 35%;     margin-left: 4%;" >
                                    <button class="btn btn-info col-sm-3" style="width: 11%;     margin-left: 6%;">Rechercher</button>
                                </form>
                            </table>
                        </div>


                    </div>
                </div>
                <div>
                    <div class="edit">
                        <span class="glyphicon glyphicon-trash"></span>
                        <span class="glyphicon glyphicon-plus" id="glyphicon-plus"></span>
                    </div>
                    <div class="table-div">
                    <table class="table table-bordered" id="vehicles_table">
                        <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Marque</th>
                            <th>Couleur</th>
                            <th>Type de vehicule</th>
                            <th>Reference de boîtier</th>
                            <th>Type de boîtier</th>
                            <th>Type d'abonnement</th>
                            <th>Prix</th>
                            <th>Date d'ajout</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                </div>
            </form>

        </div>
        </div>
    </div>

<dialog id="favDialog" class="car_dialog add_dialog">
    <div class="container-fluid " method="dialog">
        <div class="form" >
            <div class="form-group">
                <input type="text" class="form-control" id="matricule" placeholder="Matricule"  name="nom">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="matricule" placeholder="Marque"  name="nom">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="couleur" placeholder="Couleur" name="prn">
            </div>
            <div class="form-group">
                <select class="form-control" id="type_vehicule">
                    <option value="" disabled selected>Type de vehicule</option>
                    <option value="transport" >Transport</option>
                </select>
            </div>

            <hr>
            <div class="form-group">
                <input type="text" class="form-control" id="reference_boitier" placeholder="Réference de boitier" name="reference_boitier">
            </div>
            <div class="form-group">
                <select class="form-control" id="type_boitier">
                    <option value="" disabled selected>Type de boîtier</option>
                    <option value="avance" >Avancé</option>
                </select>
            </div><hr>
            <div class="form-group">
                <select class="form-control" id="type_abonnement">
                    <option value="" disabled selected>Type d'abonnement</option>
                    <option value="lite">Lite</option>
                </select>
            </div>
            <center><button class="btn btn-info" >Ajouter</button><button class="btn btn-info" id="cancel" >Cancel</button></center>
        </div>
    </div>
</dialog>
<script>
    (function() {
        var updateButton = document.getElementById('glyphicon-plus');
        var cancelButton = document.getElementById('cancel');
        // Update button opens a modal dialog
        updateButton.addEventListener('click', function() {
            document.getElementById('favDialog').showModal();
        });
        // Bouton pour fermer la boîte de dialogue
        cancelButton.addEventListener('click', function() {
            document.getElementById('favDialog').close();
        });
    })();
</script>
    @endsection
function clear()
{
    $('#matricule').val('');
    $('#client').val(0);
    $('#debut_contrat').val('');
    $('#fin_contrat').val('');
    $('#typeClient').val(0);
}

function disableContract(id)
{





    $.get("/contrat/delete/"+id,{},function(data, status){


        $("#Contrat"+id).remove();
    });

}

var checkVehicle=true;

$(document).ready(function(){

    $('#addContratBtn').click(function(){

        var ncontrat = $("#ncontrat").val();
        var dated=$("#dated").val();
        var client=$("#client").val();
        var  inputs = [ 'ncontrat','dated','client'];

        for(var j = 0;j<inputs.length;j++)
        {


            if ($('#Err' + inputs[j]).length) {


                $('#Err' + inputs[j]).remove();

            }





        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contrat/addcontrat',
            type: 'POST',
            data: {
                ncontrat: ncontrat,
                dated: dated,
                client: client,
                _token: $('#ContratToken').attr('value')
            },
            success: function (data, status) {
                var contrat = document.getElementById('contrat');
                var vehicle = document.getElementById('vehicles');
                contrat.style.opacity = 0.2;
                vehicle.style.opacity = 1;
                window.location.href = '#vehicles';

                var inputs = ['ncontrat', 'dated', 'client'];


                for (var j = 0; j < inputs.length; j++) {


                    if ($('#Err' + inputs[j]).length) {


                        $('#Err' + inputs[j]).remove();

                    }

                }

                var vehicles = null;
                if (data['vehicles'] != null) {
                    vehicles = data['vehicles'];
                }

                for (var i = 0; i < vehicles.length; i++) {
                    console.log(vehicles[i].imei);
                    $('#matricule').append($('<option id="added" value="' + vehicles[i].id + '">'  + vehicles[i].imei + '</option>'));
                 //   console.log(data[i].imei);
                }



            }


            ,
            error: function (jqXhr) {
                console.log(jqXhr);

                if (jqXhr.status === 422) {
                    var errors = jqXhr.responseJSON;
                    $.each(errors.message, function (key, value) {
                        console.log(errors);

                        var l = 0;
                        $.each(errors.message, function (key, value) {
                            // errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.

                            if ($('#Err' + key).length) {
                                //$('#Err' + key).html(value);

                                $('#Err' + key).text(value);
                            }
                            else {
                                $("#" + key).parent().append("<small id='Err" + key + "' class='text-danger'> " + value + "</small>");
                                l++;

                            }
                        });


                        // $( '#form-errors' ).html( errorsHtml );

                    });

                }

            }


        });







    });
    $('#recheche').click(function(){

        var critiere = {};

         var matricule = $('#mat').val();
         var client = $('#customer').val();
         var debut_contrat = $('#debut_contrat').val();
         var fin_contrat = $('#fin_contrat').val();
         var typeClient = $('#typeClient').val();

        critiere = {};

        if(matricule != "" && matricule != null)
            critiere['id_contract'] = matricule;

        if(client != "" && client != '0')
            critiere['id_customer'] = client;

        if(debut_contrat != "" && debut_contrat != null)
            critiere['debut_contrat'] = debut_contrat;

        if(fin_contrat != "" && fin_contrat != null)
            critiere['fin_contrat'] = fin_contrat;

        if(typeClient != "" && typeClient != '0')
                    critiere['typeClient'] = typeClient;


        $.get("/contrat/search/",
            critiere
            ,

            function (data, status) {

                $('tbody *').remove();
                $('tbody').prepend(data);


            });


        clear();
    });

    $('#refresh,#AddDetail,#btnCancel').click(function(){
          $.get("/contrat/refresh/",{},function(data,status){
              $('tbody *').remove();
              $('tbody').prepend(data);
          });
    });





    $('#AddDetail').click(function(){

        var matricule = $('#matricule').val();
        var typeAbonnement = $('#typeAbonnement').val();
        var price = $('#price').val();
        var newVehicle = 0;
        var client = $('#client').val();

        var marque = $('#marque').val();
        var model = $('#model').val();
        var imei = $('#imei').val();



        if(!checkVehicle) {
            newVehicle = 1;


        }
        else
            newVehicle = 0;



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/contrat/addDetail',
            type: 'POST',
            data: {
                client: client,
                matricule:matricule,
                typeAbonnement: typeAbonnement,
                price: price,
                newvehicle : newVehicle,
                model : model,
                imei:imei,
                marque:marque,
                _token: $('#DetailToken').attr('value')
            },

            success: function (data, status) {
                            console.log(data);
            },
            error: function (jqXhr) {


                if (jqXhr.status === 422) {
                    var errors = jqXhr.responseJSON;
                    $.each( errors.message , function( key, value ) {
                        $.each(errors.message, function (key, value) {
                            // errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.

                            if ($('#Err' + key).length) {
                                //$('#Err' + key).html(value);

                                $('#Err' + key).text(value);

                            }
                            else {
                                $("#" + key).parent().append("<small id='Err" + key + "' class='text-danger'> " + value + "</small>");

                            }
                        });



                    });

                    // $( '#form-errors' ).html( errorsHtml );

                }
            }

        });


        inputs = ['typeAbonnement','price','marque','imei','model','matricule'];
        for(var j = 0;j<inputs.length;j++)
        {


            if ($('#Err' + inputs[j]).length) {


                $('#Err' + inputs[j]).remove();

            }





        }


        $('#matricule').val(0);
        $('#typeAbonnement').val(0);
        $('#price').val('');

         $('#marque').val('');
         $('#model').val('');
          $('#imei').val('');

    });

    $("#typeAbonnement").change(function() {

        var client = $("#client").val();

        $("#typeAbonnement option:selected").each(function () {

            var choice = $(this).attr('value');
            $.get("/contrat/price/"+client+"/"+choice,


                {

                },

                function (data, status) {
                    console.log(data);
                   $('#price').val(data);

                });



        });

    });


});
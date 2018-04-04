<?php

namespace App\Http\Controllers;

use App\Models\TypesSubscribe;
use App\Models\Vehicle;
use App\Models\Box;
use App\Models\Detail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Response;
use Validator;
use Illuminate\Support\Facades\DB;
class ContratController extends Controller
{

   public function AddingInfo($nameCustomer)
   {
       $typesSubscribes = DB::table('types_subscribes')->get();


       $customerId = DB::table('customers')->where('name','=',$nameCustomer)->
       select('customers.id')->pluck('id')->first();

       $contratId = DB::table('contracts')->where('id_customer','=',$customerId)->pluck('id')->first();

       $details = DB::table('details')->where('id_contract','=',$contratId)->
           join('vehicles','vehicles.id','=','details.id_vehicle')->
           join('boxes','boxes.id','=','details.id_boxe')->
           join('types_customers_subscribes','types_customers_subscribes.id','details.id_type_customer_subscribe')->
           join('types_subscribes','types_subscribes.id','types_customers_subscribes.id_subscribe')->
             select('vehicles.*','boxes.*','types_subscribes.*')->get();


       return view('add_client',['types_subscribe'=>$typesSubscribes , 'id_contract'=>$contratId , 'details'=>$details]);

   }
    public function showInfo($idContrat)
    {
        //$typesSubscribes = DB::table('types_subscribes')->get();




        $details = DB::table('details')->where([['id_contract','=',$idContrat],['details.isactive','=','1']])->
        join('vehicles','vehicles.id','details.id_vehicle')->
        join('type_customers_subscribes','type_customers_subscribes.id','details.id_type_customer_subscribe')->
        join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')->
        select('vehicles.*','vehicles.id as idVehicle','types_subscribes.id as idtypeSub','types_subscribes.type as typeSub','details.*')->get();
        $type=DB::table('types_subscribes')->
            select('types_subscribes.*')->get();
        $vehicle=DB::table('vehicles')->where([['vehicles.isActive','=','1'],['contracts.id','=',$idContrat]])->
        join('customers','customers.id','vehicles.customer_id')->
        join('contracts','customers.id','contracts.id_customer')->
        select('vehicles.*')->get();
        $client=DB::table('contracts')->where([['contracts.id','=',$idContrat],['contracts.isactive','=','1']])->
            join('customers','customers.id','contracts.id_customer')->
            select('customers.name','contracts.*')->get();

        return view('contractInfo',['details'=>$details,'cli'=>$client,'types'=>$type,'vehicles'=>$vehicle]);
       // return response()->json($client);
    }
    public  function refreshDetail($idContrat)
    {
        $details = DB::table('details')->where([['id_contract','=',$idContrat],['details.isactive','=','1']])->
        join('vehicles','vehicles.id','=','details.id_vehicle')->
        join('type_customers_subscribes','type_customers_subscribes.id','details.id_type_customer_subscribe')->
        join('types_subscribes','types_subscribes.id','type_customers_subscribes.id_type_subscribe')->
        select('vehicles.*','vehicles.id as idVehicle','types_subscribes.*','details.*')->get();


        return view('DetailsLines',['details'=>$details]);
    }
    public function getPrice(Request $request)
    {
        if ($request->input('AddingDate'))
            $AddingDate = $request->input('AddingDate');
        else
            $AddingDate = date("Y-m-d");


        $date = explode('-', $AddingDate);

        if ($date[2] > 1 and $date[2] < 15) {
            $date[2] = '15';
        }
        if ($date[2] > 15) {
            $time = strtotime($AddingDate);
            $date = date("Y-m-d", strtotime("+1 month", $time));
            $date = explode('-', $date);
            $date[2] = '1';


        }

        $date = implode('-', $date);

        $AddingDate=$date;
        $idTypeCustomer = DB::table('vehicles')->where('vehicles.id', '=', $request->input('vehicules'))->
        join('customers', 'customers.id', 'vehicles.customer_id')->
        join('types_customers', 'types_customers.id', 'customers.id_type_customer')->
        select('types_customers.id')->pluck('id')->first();

        $PriceTypeCustomerSubscribe = DB::table('type_customers_subscribes')->where('id_type_subscribe', '=', $request->input('types'))
            ->where('id_type_customer', '=', $idTypeCustomer)->select('type_customers_subscribes.price')->pluck("price")->first();
        $idContract = DB::table('vehicles')->where('vehicles.id', '=',$request->input('vehicules') )->
        join('customers', 'customers.id', 'vehicles.customer_id')->
        join('contracts','contracts.id_customer','customers.id')->
        select('contracts.id')->pluck('id')->first();

        $price=DB::table('contracts')->where('id','=',$idContract)
            ->select(DB::raw($PriceTypeCustomerSubscribe."*datediff(end_contract,'".$AddingDate."')/datediff(end_contract,start_Contract) as thirdPrice"))
            ->pluck('thirdPrice')->first();
        return response($price);
    }
   public function addVehicule(Request $request)
   {

       $messages = [
           'required' => strtoupper(':attribute') .' est obligatoire',
           'unique' => strtoupper(':attribute').' est déja existe'
       ];






       $validator = Validator::make($request->all(), [
           'vehicules' => 'required|unique:details,id_vehicle',
           'types' => 'required',
           'priceVehicles'=>'required',




       ],$messages);

       if ($validator->fails())
       {
           $errors = $validator->errors();



           return response()->json([
               'success' => false,
               'message' => $errors
           ], 422);
       }

       else {





           if ($request->input('AddingDate'))
               $AddingDate = $request->input('AddingDate');
           else
               $AddingDate = date("Y-m-d");


           $date = explode('-', $AddingDate);

           if ($date[2] > 1 and $date[2] < 15) {
               $date[2] = '15';
           }
           if ($date[2] > 15) {
               $time = strtotime($AddingDate);
               $date = date("Y-m-d", strtotime("+1 month", $time));
               $date = explode('-', $date);
               $date[2] = '1';


           }

           $date = implode('-', $date);

            $AddingDate=$date;
          /* $VehicleId = DB::table('vehicles')->where('imei', '=', $request->input('vehicule'))->
           select('vehicles.id')->pluck('id')->first();*/


           $idTypeCustomer = DB::table('vehicles')->where('vehicles.id', '=', $request->input('vehicules'))->
           join('customers', 'customers.id', 'vehicles.customer_id')->
           join('types_customers', 'types_customers.id', 'customers.id_type_customer')->
           select('types_customers.id')->pluck('id')->first();

           $TypeCustomerSubscribe = DB::table('type_customers_subscribes')->where('id_type_subscribe', '=', $request->input('types'))
               ->where('id_type_customer', '=', $idTypeCustomer)->select('type_customers_subscribes.*');

           $idTypeCustomerSubscribe = $TypeCustomerSubscribe->pluck('id')->first();
           $price = $TypeCustomerSubscribe->pluck('price')->first();

           $idContract = DB::table('vehicles')->where('vehicles.id', '=',$request->input('vehicules') )->
           join('customers', 'customers.id', 'vehicles.customer_id')->
           join('contracts','contracts.id_customer','customers.id')->
           select('contracts.id')->pluck('id')->first();

    $detail = new Detail();
    $detail->id_contract = $idContract;
    $detail->id_vehicle = $request->input('vehicules');
    $detail->id_type_customer_subscribe = $idTypeCustomerSubscribe ;
    $detail->price = $request->input('priceVehicles');
    $detail->offer = 0;
    $detail->AddingDate=$AddingDate;

    $detail->save();
$dated=$request->input('AddingDate');
           return response(    $idTypeCustomer . $idTypeCustomerSubscribe . $price.$dated );


       }


   }



}
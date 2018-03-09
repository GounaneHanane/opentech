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

   public function addVehicule(Request $request)
   {

       $messages = [
           'required' => strtoupper(':attribute') .' est obligatoire',
           'unique' => strtoupper(':attribute').' est déja existe'
       ];






       $validator = Validator::make($request->all(), [
           'matricule' => 'required|unique:vehicles,car_number',
           'mark' => 'required',
           'modele' => 'required',
           'reference_boitier' => 'required',
           'type_boitier' => 'required',
           'type_abonnement' => 'required',



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


           $idContract = $request->input('idContract');
           $vehicle = new Vehicle();
           $vehicle->car_number = $request->input('matricule');
           $vehicle->mark = $request->input('mark');
           $vehicle->model = $request->input('modele');
           $vehicle->add_date = date("Y-m-d H:i:s");

           $vehicle->save();

           $box = new Box();
           $box->reference = $request->input('reference_boitier');
           $box->type_box = $request->input('type_boitier');
           $box->numero_operetor = "0645209199";

           $box->save();


           $VehicleId = DB::table('vehicles')->where('car_number', '=', $request->input('matricule'))->
           select('vehicles.id')->pluck('id')->first();


           $BoxId = DB::table('boxes')->where('reference', '=', $request->input('reference_boitier'))->
           select('boxes.id')->pluck('id')->first();


           $idTypeSubscribe = DB::table('types_subscribes')->where('type', '=', $request->input('type_abonnement'))->select('types_subscribes.id')->pluck('id')->first();

           $idTypeCustomer = DB::table('contracts')->where('contracts.id', '=', $idContract)->
           join('customers', 'customers.id', 'contracts.id_customer')->
           join('types_customers', 'types_customers.id', 'customers.id_type_customer')->
           select('types_customers.id')->pluck('id')->first();

           $TypeCustomerSubscribe = DB::table('types_customers_subscribes')->where('id_subscribe', '=', $idTypeSubscribe)
               ->where('id_type_customer', '=', $idTypeCustomer)->select('types_customers_subscribes.*');

           $idTypeCustomerSubscribe = $TypeCustomerSubscribe->pluck('id')->first();
           $price = $TypeCustomerSubscribe->pluck('price')->first();

           $CustomerName = DB::table('contracts')->where('contracts.id', '=', $idContract)->
           join('customers', 'customers.id', 'contracts.id_customer')->
           select('customers.name')->pluck('name')->first();


           $detail = new Detail();
           $detail->id_contract = $idContract;
           $detail->id_vehicle = $VehicleId;
           $detail->id_type_customer_subscribe = $idTypeCustomerSubscribe;
           $detail->id_boxe = $BoxId;
           $detail->price = $price;
           $detail->offer = 0;

           $detail->save();

           return response($VehicleId . $BoxId . $idTypeSubscribe . $idTypeCustomer . $idTypeCustomerSubscribe . $price . $CustomerName);


       }


   }
    public function contrat()
    {
        $c=DB::table('contracts')
            ->join('customers','customers.id','=','contracts.id_customer')
            ->join('cv','cv.id_contract','contracts.id')
            ->select('contracts.*' , 'customers.*','contracts.id as id_contract','cv.vehicles')
            ->get();
        $ClientType=DB::table('types_customers')
            ->select('types_customers.type as ClientType','types_customers.id as ClientTypeId')->get();
        $AbonnementType=DB::table('types_subscribes')
            ->select('types_subscribes.type as AbonnementType','types_subscribes.id as AbonnementTypeId')->get();
        $v=DB::table('vehicles')
            ->select('vehicles.*')->get();
        //return response()->json([$c]);
        return view('Contrat',['contracts'=>$c,'clientTypes'=>$ClientType,'abonnementTypes'=>$AbonnementType,'vehicle'=>$v]);
    }


}
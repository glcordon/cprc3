<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Client;
use App\ClientService;
use App\Service;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class AccountsPayableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $thisDate = Carbon::now()->month;
        if($request->searchMonth)
        {
           $thisDate = $request->searchMonth; 
        }
        $clients = Client::whereHas('services', function ($query) use($thisDate) {
                $query->whereMonth('date_authorized','=', $thisDate)->whereYear('date_authorized', '=', Carbon::now()->year);
            })->with('services')->get();
        $clientData = $clients->map(function($x) use($thisDate){
            $thisService =  collect($x->services->toArray())->filter(function($y) use($thisDate){
                return Carbon::parse($y['pivot']['date_authorized'])->month == $thisDate;
            });
            return ['first_name' => $x->first_name, 'last_name' => $x->last_name, 'services'=>$thisService];
        });
        // $clientData = $clients->map(function($x){ 
        //     $serviceData = collect($x->services)->map(function($y){
        //         $pd = collect($y->pivot)->toArray();
        //         $pivotData = collect($pd)->map(function($z){
        //                 return $z;
        //         });
        //        return['service_name' => $y->service_name, 'pivot' => $pivotData]; 
        //     });
        //    return [
        //        'id'=>$x->id,
        //        'first'=>$x->first_name, 
        //        'last'=>$x->last_name, 
        //        'service'=>$serviceData];
        // });
        return view('ap.index', compact('clientData','thisDate'));
    }
    public function participantReport(Request $request)
    {
        $thisDate = Carbon::parse($request->searchMonth);
        // $clients = Client::whereHas('services', function ($query) use($thisDate) {
        //     $query->whereMonth('client_service.created_at','=', $thisDate->month);
        // })->get();
        $clients = Client::whereMonth('enrollment_date','=', $thisDate->month)->whereYear('enrollment_date', '=', $thisDate->year)->get();
        return $clients;
         
    }
    public function updateService(Request $request)
    {
        $client_service =  ClientService::find($request->pivot_id);
        $client_service->date_authorized = $request->date_authorized;
        $client_service->authorized_price = $request->authorized_price;
        $client_service->save();
        // --- couldnt get the  sync to work right so I just used the id to update the model directly -- //
        // $client = Client::find($request->client_id);
        // $services = $client->services->filter(function($data) use($request){
        //     return $data->pivot->service_id == $request->service_id;
        // });
        // return $services['pivot'];
        // $client->services()->attach([$request->service_id =>['date_authorized'=>$request->date_authorized, 'authorized_price'=>$request->authorized_price]]);
        return $client_service;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $clients = Client::whereHas('services', function ($query) use($id) {
            $query->whereMonth('client_service.date_authorized','=', $id);
        })->with('services')->get();
        $clientData = $clients->map(function($x) use($id){
            $service =  collect($x->services->toArray())->filter(function($y) use($id){
                return Carbon::parse($y['pivot']['date_authorized'])->month == $id;
            });
            $serviceData = $service->map(function($y){
                $pd = collect($y['pivot'])->toArray();
                $pivotData = collect($pd)->map(function($z){
                        return $z;
                });
               return['service_name' => $y['service_name'], 'service_type'=>$y['service_type'], 'short_code'=>$y['short_code'], 'pivot' => $pivotData]; 
            });
            $total = $serviceData->map(function($sum){
                return $sum['pivot']['authorized_price'];
            })->sum();
           
           return [
               'id'=>$x->id,
               'first'=>$x->first_name, 
               'last'=>$x->last_name, 
                'total' => $total,
                'service'=>$serviceData->groupBy('service_type')];
        });
        // dd($clientData->map(function($x){
        //     return $x['service'];
        // })->map(function($x){
        //     return $x->flatten(1);
        // })
        // ->map(function($x)
        // {
        //     return $x->groupBy('service_type');
        // })
        // );
        $grandTotal = $clientData->map(function($total){
            return $total['total'];
        })->sum();
        
        return view('ap.output', compact('clientData','id', 'grandTotal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        ClientService::find($id)->delete();
        return 'success';
    }
}

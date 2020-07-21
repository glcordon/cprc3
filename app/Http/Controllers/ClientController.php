<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\User;
use App\Job;
use App\ClientProfile;
use App\Services;
use Illuminate\Support\Facades\Auth;
use App\ClientService;
use App\Imports\ClientImport;
use App\Service;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $clients = Client::get();
         // return view('vendor.voyager.clients.browse');
        return view('clients.index', compact('clients'));
    }
    public function viewInactive()
    {
       
        $clients = Client::where('status','<>', 'active')->get();
         // return view('vendor.voyager.clients.browse');
        return view('partials.clients.client-index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()       
    {

        $users = User::get();
        foreach($users as $user)
        {
            $user->caseLoad = $this->calculateCaseload($user->id);
        }
        $users = $users->sortBy('caseLoad');
        $suggestedCaseworker = $users->where('caseLoad', $users->min('caseLoad'))->random()->name;
        $services = Services::get();
        return view('clients.add', compact('services','users', 'suggestedCaseworker'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client;
            if($request->form_of_id == null)
            {
                $request->form_of_id = [""];
            }
            $client->enrollment_date = $request->enrollment_date;
            $client->first_name = $request->first_name; 
            $client->middle_name = $request->middle_name;
            $client->last_name = $request->last_name;
            $client->suffix = $request->suffix;
            $client->address_1 = $request->street_address; 
            $client->risk_level = $request->risk_level;
            $client->city = $request->city;
            $client->state = $request->state;
            $client->zip = $request->zip;
            $client->primary_phone =$request->primary_phone;
            $client->secondary_phone = $request->secondary_phone;
            $client->email_address = $request->email;
            $client->citizenship = $request->citizenship;
            $client->form_of_id = json_encode($request->form_of_id);
            $client->sex = $request->sex;
            $client->release_date = $request->release_date;
            $client->status = $request->status;
            $client->full_name = $request->last_name. ', '. $request->first_name;
            $client->assigned_to = $request->caseworker;
            $client->ncdps_id = $request->ncdps_id;
            $client->maritial_status = $request->maritial_status;           
            $client->race = $request->race;
            $client->ethnicity = $request->ethnicity;
            $client->education = $request->education;
            $client->dob = $request->dob;
            $client->supervisors_name = $request->supervisors_name;
            $client->charge = $request->charge;
            $client->supervisors_phone = $request->supervisors_phone;
            $client->supervisors_email = $request->supervisors_email;
            $client->supervisors_end_date = $request->supervisors_end_date;
            $client->supervision_level = $request->supervision_level;
            $client->sex_offender = $request->sex_offender;
            $client->county_registered = $request->county_registered;
            $client->released_from = $request->released_from;
            $client->under_supervision = $request->under_supervision;
            $client->number_of_priors = $request->number_of_priors;
            $client->first_offence_age = $request->first_offence_age;
            $client->save();

            $client->services()->attach($request->services);
            

        return redirect('/client/contact/'.$client->id);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
        $clients = $client;
        // $services = $clients->services;
        $services = Services::get();
        $additional_service = Services::get();
        $allServices = collect($additional_service->toArray());
        $otherServices = $additional_service->diff($services)->sortBy('service_name')->toArray();
        $notes = $clients->notes;
        $last_contact = $clients->notes->first()->created_at ?? '';
        // dd(Services::select('id', 'service_name')->pluck('id'));
        return view('clients.show', compact('clients', 'services','notes', 'otherServices', 'last_contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);
        // dd($client->form_of_id);
        $users = User::whereIn('role_id', [3,4])->get();
        $services = Services::orderBy('service_name', 'ASC')->get();
        return view('partials.clients.client-add', compact('client', 'users', 'services'));
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
            $client = Client::find($id);
            if($request->form_of_id == null)
            {
                $request->form_of_id = [""];
            }
            $client->enrollment_date = $request->enrollment_date;
            $client->first_name = $request->first_name; 
            $client->middle_name = $request->middle_name;
            $client->last_name = $request->last_name;
            $client->suffix = $request->suffix;
            $client->address_1 = $request->street_address; 
            $client->city = $request->city;
            $client->state = $request->state;
            $client->risk_level = $request->risk_level;
            $client->zip = $request->zip;
            $client->primary_phone =$request->primary_phone;
            $client->secondary_phone = $request->secondary_phone;
            $client->email_address = $request->email;
            $client->citizenship = $request->citizenship;
            $client->form_of_id = json_encode($request->form_of_id);
            $client->sex = $request->sex;
            $client->release_date = $request->release_date;
            $client->status = $request->status;
            $client->full_name = $request->last_name. ', '. $request->first_name;
            $client->assigned_to = $request->caseworker;
            $client->ncdps_id = $request->ncdps_id;
            $client->maritial_status = $request->maritial_status;           
            $client->race = $request->race;
            $client->ethnicity = $request->ethnicity;
            $client->education = $request->education;
            $client->dob = $request->dob;
            $client->supervisors_name = $request->supervisors_name;
            $client->charge = $request->charge;
            $client->supervisors_phone = $request->supervisors_phone;
            $client->supervisors_email = $request->supervisors_email;
            $client->supervisors_end_date = $request->supervisors_end_date;
            $client->supervision_level = $request->supervision_level;
            $client->sex_offender = $request->sex_offender;
            $client->county_registered = $request->county_registered;
            $client->released_from = $request->released_from;
            $client->under_supervision = $request->under_supervision;
            $client->number_of_priors = $request->number_of_priors;
            $client->first_offence_age = $request->first_offence_age;
            $client->save();

            $client->services()->sync($request->services);
            

            return redirect('/client/contact/'.$client->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->services()->detach();
        $client->delete();
        return redirect()->back()->withInput();
    }
    public function getFile(Int $id, $file_url)
    {
        if(Storage::disk('local')->exists($id.'/'.$file_url))
        {
           return response()->download(storage_path('app/'.$id.'/'.$file_url)); 
        }else{
            return abort(404);
        }
    }
    public function getService(ClientService $service){
        return $service;
    }
    public function addService(Request $request)
    {
        if($request)
        {
            // return($request->all());
            $client = Client::find($request->client_id);
            // dd($request->uploaded_file);
            $filename = '';
            if($request->uploaded_file == "unidentified")
                {
                    $filename = Carbon::now()->format('m-d-y-H-i-s').'_'.$request->uploaded_file->getClientOriginalName();
                    $request->uploaded_file->storeAs($client->id, $filename);
                }
                if($request->has('id'))
                {
                    $thisId = $request->id;
                    $clientService = ClientService::find($thisId);
                            $clientService->id = $request->id;
                            $clientService->service_id = $request->service_id; 
                            $clientService->client_id = $client->id;
                            $clientService->authorized_price = $request->auth_price;
                            $clientService->date_authorized = $request->date_authorized;
                            $clientService->notes = $request->notes;
                            $clientService->file_url = $filename;
                            $clientService->save();
                }else{
                    $client_service = ClientService::updateOrCreate(
                        [
                            'service_id' => $request->service_id, 
                            'client_id' => $client->id,
                            'authorized_price' => $request->auth_price,
                            'date_authorized' => $request->date_authorized,
                            'notes' => $request->notes,
                            'file_url' => $filename
                        ]
                        );
                }
                
                
            return $client_service;
        }
    }

    public function updateServices(Request $request, $id)
    {
        if($request)
        {
            $client_service = ClientService::updateOrCreate(
                [
                    'id' => $request->id,
                    'service_id' => $request->service_id, 
                    'client_id' => $client->id
                ], 
                [
                    'authorized_price' => $request->auth_price,
                    'date_authorized' => $request->date_authorized,
                    'notes' => $request->notes,
                    'file_url' => $filename
                ]
                );
        }
    }

    public function myCaseload(int $id)
    {

        $clients = Client::where('assigned_to', $id)->paginate('15');
        // return view('vendor.voyager.clients.browse');
        return view('partials.clients.client-index', compact('clients'));
    }

    public function assignCaseWorker(Request $request)
    {
        
    }
    public function updateJob(Request $request)
    {
        $client = Client::find($request->id);
 
        $job = new Job;
        $job->job_name = $request->job_name;
        $job->job_phone = $request->job_phone;
        $job->job_address = $request->job_address;
        $job->job_city = $request->job_city;
        $job->job_zip = $request->job_zip;
        $job->start_date = $request->start_date;
        $job->salary = $request->salary;
        
        $client = $client->jobs()->save($job);
        return $job;
        
    }
    public function deleteJob(Request $request)
    {
        Job::find($request->id)->delete();
        return "done";
    }
    public function findUser(Request $request)
    {
        $user = Client::where('ncdps_id', $request->ncdpsId)->first();
        return $user;
    }

    public function calculateCaseload($id)
    {
        $caseload = Client::select('risk_level')->where('assigned_to', $id)->where('status', 'active')->get();
        $count = 0;
        foreach($caseload as $case)
        {
            if($case['risk_level'] == 'Low')
            {
                $count++;
            }
            if($case['risk_level'] == 'Medium')
            {
                $count += 2;
            }
            if($case['risk_level'] == 'High')
            {
                $count += 3;
            }
        }
        return($count);
    }
    public function showUploadForm()
    {
        return view('partials.clients.client-upload');
    }

    public function clientUpload(Request $request)
    {

        $path = $request->file('excel_file')->store('csvs');
        
        $clients = (new ClientImport)->toCollection($path, 'local', \Maatwebsite\Excel\Excel::XLSX)->flatten(1)->toArray();

        foreach($clients as $row)
        {
            $client = new Client;
            if($request->form_of_id == null)
            {
                $request->form_of_id = [""];
            }
            $client->enrollment_date = $this->convertExcelDate($row['enrollmentdate']) ?? '';
            $client->first_name = explode(' ', $row['name'])[0] ?? ''; 
            $client->last_name = explode(' ', $row['name'])[1] ?? '';
            $client->suffix =  explode(' ', $row['name'])[2] ?? '';
            $client->address_1 = explode(',', $row['address'])[0] ?? ''; 
            $client->risk_level = '';
            $client->city = explode(',', $row['address'])[1] ?? null;
            $client->state = explode(',', $row['address'])[2] ?? null;
            $client->zip = null;
            $client->primary_phone = $row['telephone'] ?? '';
            $client->secondary_phone = $row['telephone_2'] ?? '';
            $client->email_address = $row['email'] ?? '';
            $client->citizenship = $row['citizenship'] ?? '';
            $client->form_of_id = json_encode($request->form_of_id);
            $client->sex = $row['gender'][0] ?? '';
            $client->release_date =  null;
            $client->status = 'active' ?? '';
            $client->full_name = $row['name'] ?? '';
            $client->assigned_to = $row['assigned_to'] ?? '14';
            $client->ncdps_id = $row['opus'] ?? '';
            $client->maritial_status = $row['marital_status'] ?? '';           
            $client->race = $row['race'] ?? '';
            $client->ethnicity = $row['ethnicity'] ?? '';
            $client->education = $row['level_of_education'] ?? '';
            $client->dob = $this->convertExcelDate($row['dob']) ?? '';
            $client->number_of_priors = $row['of_priors'] ?? null;
            $client->first_offence_age = $row['age_at_1stoffense'] ?? null;
            $client->charge = 'testing';
            $client->save();
            
        }

        return(collect($clients)->map(function($item){
            return $item;
                return $this->convertExcelDate($item['dob']);
           
            })
        );

        return Client::where("assigned_to", "14")->get();
    }

    public function convertExcelDate($date)
    {
            $EXCEL_DATE = $date;
            $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
            return gmdate("Y-m-d", $UNIX_DATE);
    }
}


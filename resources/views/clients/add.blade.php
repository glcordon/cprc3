@extends('layouts.admin')

@section('content')
    <div>

      <h1>{{ !isset($client) ? "Add A New Client" : 'Edit/View ' .$client->last_name. ', ' .$client->first_name}}</h1>
    <form method="post" enctype="multipart/form-data" id="gform_4" action="{{ isset($client) ? '/client/'.$client->id .'/update': '/client/store' }}">
        {{ @csrf_field() }}
            <h3 class="gform_title">Intake Form</h3>
            <span class="gform_description">Intake form for CP Re-entry Program!</span><br><br>
            <div class="row">
                        <div class="col-3">
                            <label for="enrollment_date">Enrollment Date</label>
                            <input type="date" value="{{ isset($client) ? $client->enrollment_date : ''}}" name="enrollment_date" id="enrollment_date" class="form-control">
                        </div>
                         <div class="col-3"><label for="dob">DOB</label>
                            <input type="date" name="dob" id="dob" value="{{ isset($client) ? $client->dob : ''}}" class="form-control">
                        </div>
                        <div class="col-3"><label for="first_offence_age"> <small>Age When Committed First Offense</small> </label>
                            <input type="number" min="16" max="98" id="first_offence_age" name="first_offence_age" value="{{ isset($client) ? $client->first_offence_age : ''}}" class="form-control">
                        </div>
                        <div class="col-3"><label for="number_of_priors">Number of Priors</label>
                            <input type="number" min="0" max="98" id="number_of_priors" name="number_of_priors" value="{{ isset($client) ? $client->number_of_priors : ''}}" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="risk_level">Risk Level</label>
                            <select name="risk_level" id="risk_level" class="form-control">
                                <option value="Low" {{ isset($client) ? ($client->risk_level == 'Low' ? 'selected="selected"' : '') : ''}}>Low</option>
                                <option value="Medium" {{ isset($client) ? ($client->risk_level == 'Medium' ? 'selected="selected"' : '') : ''}}>Medium</option>
                                <option value="High" {{ isset($client) ? ($client->risk_level == 'High' ? 'selected="selected"' : '') : ''}}>High</option>
                            </select>
                        </div>
                    </div>
                    <label>Assign Caseworker:</label>
                    @if(!isset($client))
                        <small><em>
                            Suggested Caseworker: {{ $suggestedCaseworker }}
                        </em></small>
                    @endif
            <select name="caseworker" id="caseworker" class="form-control">
                <option value="">Select Caseworker</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ isset($client) ? ($user->id == $client->assigned_to ? 'selected="selected"' : '') : ''}}>{{ $user->name }}</option>
                @endforeach
            </select>
            <div class="form-group">
               <div class="row"> <div class="col-12">
                   <label for="ncdps_id">NCDPS ID</label>
                    <input type="text" name="ncdps_id" id="ncdps_id" value="{{ isset($client) ? $client->ncdps_id : ''}}"  class="form-control">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="user_does_exist" style="display:none">
                        This user exists
                        
                    </div>
                </div></div>
    
            </div>
    
    <div class="form-group">
        <div class="row">
                <div class="col-3">
                    <label class="gfield_label" for="input_4_1">First Name<span class="gfield_required">*</span></label>
                    <input name="first_name" id="input_4_1" type="text"  class="form-control" value="{{ isset($client) ? $client->first_name : ''}}"  maxlength="20" "1" placeholder="Your First Name" aria-required="true" aria-invalid="false">
                </div>
                <div class="col-3">
                    <label class="gfield_label" for="input_4_1">Middle Name<span class="gfield_required"></span></label>
                    <input name="middle_name" id="input_4_1" type="text"  class="form-control" value="{{ isset($client) ? $client->middle_name : ''}}"  maxlength="20" "1" placeholder="Middle Name" aria-invalid="false">
                </div>
                <div class="col-3">
                    <label class="gfield_label" for="input_4_2">Last Name<span class="gfield_required">*</span></label>
                    <input name="last_name" required id="input_4_2" type="text"  class="form-control" value="{{ isset($client) ? $client->last_name : ''}}"  "2" placeholder="Your Last Name" aria-required="true" aria-invalid="false">
                </div>
                <div class="col-3">
                    <label class="gfield_label" for="input_4_2">Suffix<span class="gfield_required"></span></label>
                    <select name="suffix" id="suffix" class="form-control">
                        <option value="">Select One</option>
                        <option value="Jr" {{ isset($client) ? ($client->suffix == 'Jr' ? 'selected="selected"' : '') : ''}}>Jr</option>
                        <option value="Sr" {{ isset($client) ? ($client->suffix == 'Sr' ? 'selected="selected"' : '') : ''}}>Sr</option>
                        <option value="III" {{ isset($client) ? ($client->suffix == 'III' ? 'selected="selected"' : '') : ''}}>III</option>
                        <option value="IV" {{ isset($client) ? ($client->suffix == 'IV' ? 'selected="selected"' : '') : ''}}>IV</option>
                    </select>
    
                </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-4"><label for="maritial_status">Maritial Status</label>
                <select name="maritial_status" id="maritial_status" class="form-control">
                    <option value="">Select One</option>
                    <option value="single" {{ isset($client) ? ($client->maritial_status == 'single' ? 'selected="selected"' : '') : ''}}>single</option>
                    <option value="married" {{ isset($client) ? ($client->maritial_status == 'married' ? 'selected="selected"' : '') : ''}}>married</option>
                    <option value="widowed" {{ isset($client) ? ($client->maritial_status == 'widowed' ? 'selected="selected"' : '') : ''}}>widowed</option>
                    <option value="separated" {{ isset($client) ? ($client->maritial_status == 'separated' ? 'selected="selected"' : '') : ''}}>separated</option>
                    <option value="divorced" {{ isset($client) ? ($client->maritial_status == 'divorced' ? 'selected="selected"' : '') : ''}}>divorced</option>
                    <option value="domestic" {{ isset($client) ? ($client->maritial_status == 'domestic' ? 'selected="selected"' : '') : ''}}>domestic partner</option>
                    <option value="common_law" {{ isset($client) ? ($client->maritial_status == 'common_law' ? 'selected="selected"' : '') : ''}}>common law</option>
                </select>
            </div>
            <div class="col-4"><label for="race">Race</label>
                <select name="race" id="race" class="form-control">
                    <option value="">Select One</option>
                    <option value="black" {{ isset($client) ? ($client->race == 'black' ? 'selected="selected"' : '') : ''}}>Black</option>
                    <option value="asian" {{ isset($client) ? ($client->race == 'asian' ? 'selected="selected"' : '') : ''}}>Asian</option>
                    <option value="bi_racial" {{ isset($client) ? ($client->race == 'bi_racial' ? 'selected="selected"' : '') : ''}}>Bi-Racial</option>
                    <option value="latino" {{ isset($client) ? ($client->race == 'latino' ? 'selected="selected"' : '') : ''}}>Latino</option>
                    <option value="caucasian" {{ isset($client) ? ($client->race == 'caucasian' ? 'selected="selected"' : '') : ''}}>Caucasian</option>
                    <option value="multi" {{ isset($client) ? ($client->race == 'multi' ? 'selected="selected"' : '') : ''}}>Multi-Racial</option>
                    <option value="native_american" {{ isset($client) ? ($client->race == 'native_american' ? 'selected="selected"' : '') : ''}}>Native American</option>
                    <option value="hawiian" {{ isset($client) ? ($client->race == 'hawiian' ? 'selected="selected"' : '') : ''}}>Hawiian/Pacific Outlander</option>
                    <option value="other" {{ isset($client) ? ($client->race == 'other' ? 'selected="selected"' : '') : ''}}>Other</option>
                </select>
            </div>
            <div class="col-4"><label for="ethnicity">Ethnicity</label>
                <select name="ethnicity" id="ethnicity" class="form-control">
                    <option value="">Select One</option>
                    <option value="hispanic" {{ isset($client) ? ($client->ethnicity == 'hispanic' ? 'selected="selected"' : '') : ''}}>Hispanic</option>
                    <option value="non-hispanic" {{ isset($client) ? ($client->ethnicity == 'non-hispanic' ? 'selected="selected"' : '') : ''}}>Non-Hispanic</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-6"><label for="education">Highest Level of Education</label>
                <select name="education" id="education" class="form-control">
                    <option value="">Select One</option>
                    <option value="grade-school" {{ isset($client) ? ($client->education == 'grade-school' ? 'selected="selected"' : '') : ''}}>Grade School</option>
                    <option value="some-high" {{ isset($client) ? ($client->education == 'some-high' ? 'selected="selected"' : '') : ''}}>Some High School</option>
                    <option value="diploma" {{ isset($client) ? ($client->education == 'diploma' ? 'selected="selected"' : '') : ''}}>High School Diploma</option>
                    <option value="high-school-equiv" {{ isset($client) ? ($client->education == 'high-school-equiv' ? 'selected="selected"' : '') : ''}}>High School Equivalent</option>
                    <option value="associates" {{ isset($client) ? ($client->education == 'associates' ? 'selected="selected"' : '') : ''}}>Associates</option>
                    <option value="bachelors" {{ isset($client) ? ($client->education == 'bachelors' ? 'selected="selected"' : '') : ''}}>Bachelors Degree</option>
                    <option value="grad" {{ isset($client) ? ($client->education == 'grad' ? 'selected="selected"' : '') : ''}}>Grad School</option>
                    <option value="trade" {{ isset($client) ? ($client->education == 'trade' ? 'selected="selected"' : '') : ''}}>Trade School</option>
                </select>
            </div>
           
    
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-12">
                    <label for="input_4_14_1" id="input_4_14_1_label">Street Address</label>
                    <input type="text"  class="form-control" name="street_address" id="input_4_14_1" value="{{ isset($client) ? $client->address_1 : ''}}" "22">
            </div>
            <div class="col-4">
                    <label for="input_4_14_3" id="input_4_14_3_label">City</label>
                    <input type="text"  class="form-control" name="city" id="input_4_14_3" value="{{ isset($client) ? $client->city : ''}}" "24">
    
            </div>
            <div class="col-4">
                    <label for="input_4_14_4" id="input_4_14_4_label">State / Province / Region</label>
                    <input type="text" class="form-control" name="state" id="input_4_14_4" value="{{ isset($client) ? $client->state : 'NC'}}" "26">
            </div>
            <div class="col-4">
                    <label for="input_4_14_5" id="input_4_14_5_label">ZIP / Postal Code</label>
                    <input type="text"  class="form-control" name="zip" id="input_4_14_5" value="{{ isset($client) ? $client->zip : ''}}" "27">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-4">
                <label class="gfield_label" for="input_4_3">Primary Phone</label>
                <input name="primary_phone" id="input_4_3" type="tel"  class="form-control" value="{{ isset($client) ? $client->primary_phone : ''}}"  "3" placeholder="Primary Phone Number" aria-invalid="false">
            </div>
            <div class="col-4">
                <label class="gfield_label" for="input_4_4">Secondary Phone</label>
                <input name="secondary_phone" id="input_4_4" type="tel"  class="form-control" value="{{ isset($client) ? $client->secondary_phone : ''}}"  "4" placeholder="Secondary Phone Number" aria-invalid="false">
    
            </div>
            <div class="col-4">
                <label class="gfield_label" for="input_4_4">Email Address</label>
                <input name="email" id="input_4_4" type="email" validate="email"  class="form-control" value="{{ isset($client) ? $client->email_address : ''}}"  "4" placeholder="Email Address" aria-invalid="false">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-4">
                <label class="gfield_label" for="input_4_5">Citizenship Status<span class="gfield_required">*</span></label>
                <select class="form-control" name="citizenship" id="input_4_5" class="medium gfield_select" aria-required="true" aria-invalid="false">
                    <option value="" class="gf_placeholder">Your citizenship Status</option>
                    <option value="US Citizen" {{ isset($client) ? ($client->citizenship == 'US Citizen' ? 'selected="selected"' : '') : ''}}>US Citizen</option>
                    <option value="Registered Alien" {{ isset($client) ? ($client->citizenship == 'Registered Alien' ? 'selected="selected"' : '') : ''}}>Registered Alien</option>
                    <option value="Veteran" {{ isset($client) ? ($client->citizenship == 'Veteran' ? 'selected="selected"' : '') : ''}}>Veteran</option>
                </select>
            </div>
            <div class="col-4">
                <label class="gfield_label" for="input_4_6">What Forms of ID do you posess?<span class="gfield_required">*</span><br /> <small><em>Hold Control Key and Click to Select Multiple</em></small></label>
                <select multiple class="form-control" name="form_of_id[]" id="input_4_6" class="medium gfield_select" aria-required="true" aria-invalid="false">
                    <option value="US Drivers License" {{ isset($client) ? (in_array('US Drivers License', json_decode($client->form_of_id)) ? 'selected="selected"' : '') : ''}}>US Drivers License</option>
                    <option value="Birth Certificate" {{ isset($client) ? (in_array('Birth Certificate',json_decode($client->form_of_id)) ? 'selected="selected"' : '') : ''}}>Birth Certificate</option>
                    <option value="Social Security Card" {{ isset($client) ? (in_array('Social Security Card',json_decode($client->form_of_id)) ? 'selected="selected"' : '') : ''}}>Social Security Card</option>
                    <option value="Government ID" {{ isset($client) ? (in_array('Government ID',json_decode($client->form_of_id)) == 'Government ID' ? 'selected="selected"' : '') : ''}}>Government ID</option>
                    <option value="No ID" {{ isset($client) ? (in_array('No ID',json_decode($client->form_of_id)) ? 'selected="selected"' : '') : ''}}>No ID</option>
                </select>
            </div>
            <div class="col-4">
                <label class="gfield_label" for="input_4_6">Preferred Sex<span class="gfield_required">*</span></label>
    
                <select name="sex" id="sex" required="required" class="form-control">
                    <option value="">Select</option>
                    <option value="M" {{ isset($client) ? ($client->sex == 'F' ? 'selected="selected"' : '') : ''}}>Male</option>
                    <option value="F" {{ isset($client) ? ($client->sex == 'M' ? 'selected="selected"' : '') : ''}}>Female</option>
                    <option value="F" {{ isset($client) ? ($client->sex == 'TMF' ? 'selected="selected"' : '') : ''}}>Trans Male-Female</option>
                    <option value="F" {{ isset($client) ? ($client->sex == 'TFM' ? 'selected="selected"' : '') : ''}}>Trans Female-Male</option>
                    <option value="O" {{ isset($client) ? ($client->sex == 'O' ? 'selected="selected"' : '') : ''}}>Prefer Not To Disclose</option>
                </select>
            </div>
        </div>
    </div>
    
                <label for="input_4_14_5" id="input_4_14_5_label">Release Date *</label>
                <input type="date" class="form-control" name="release_date" id="input_4_14_5" value="{{ isset($client) ? $client->release_date : ''}}" "27">
                <label for="released_from">Released From</label>
                <select name="released_from" id="released_from" class="form-control">
                    <option value="no-jail-time" {{ isset($client) ? ($client->released_from == 'no-jail-time' ? 'selected="selected"' : '') : ''}}>No Jail Time</option>
                    <option value="ncdps-prison" {{ isset($client) ? ($client->released_from == 'ncdps-prison' ? 'selected="selected"' : '') : ''}}>NCDPS Prison</option>
                    <option value="ncdps-parole" {{ isset($client) ? ($client->released_from == 'ncdps-parole' ? 'selected="selected"' : '') : ''}}>NCDPS Parole</option>
                    <option value="county-jail" {{ isset($client) ? ($client->released_from == 'county-jail' ? 'selected="selected"' : '') : ''}}>County Jail</option>
                    <option value="another-state" {{ isset($client) ? ($client->released_from == 'another-state' ? 'selected="selected"' : '') : ''}}>Another State</option>
                    <option value="community-agency" {{ isset($client) ? ($client->released_from == 'community-agency' ? 'selected="selected"' : '') : ''}}>Community Agency</option>
                    <option value="self" {{ isset($client) ? ($client->released_from == 'self' ? 'selected="selected"' : '') : ''}}>Self Referral</option>
                    <option value="relative" {{ isset($client) ? ($client->released_from == 'relative' ? 'selected="selected"' : '') : ''}}>Relative</option>
                </select>
                <hr>
                <div class="col-12">
                        <label for="charge">Offense</label>
                        <input name="charge" id="charge" value="{{ isset($client) ? $client->charge : ''}}" class="form-control" required>
                    </div>
                    
                <label for="under_supervision">Under Supervision</label> &nbsp; <input type="checkbox" name="under_supervision" id="under_supervision" {{ isset($client) ? ($client->under_supervision == 'on' ? 'checked="checked"' : '') : ''}}>
                <div id="under_supervision_section">
                    <div class="row">
                    <div class="col-3">
                        <label for="supervisor-name">Supervisors Name</label>
                        <input type="text" name="supervisors_name" value="{{ isset($client) ? $client->supervisors_name : ''}}" id="supervisors-name" class="form-control">
                    </div>
                    <div class="col-3">
                        <label for="supervisors-phone">Phone</label>
                        <input type="text" name="supervisors_phone" value="{{ isset($client) ? $client->supervisors_phone : ''}}" id="supervisors-phone" class="form-control">
                    </div>
                    <div class="col-3">
                        <label for="supervisors-email">Email</label>
                        <input type="email" name="supervisors_email" value="{{ isset($client) ? $client->supervisors_email : ''}}" id="supervisors-email" class="form-control">
                    </div>
                    <div class="col-3">
                        <label for="supervisors-end-date">Supervision End Date</label>
                        <input type="date" name="supervisors_end_date" value="{{ isset($client) ? $client->supervisors_end_date : ''}}" id="supervisors-end-date" class="form-control">
                    </div>
    
                </div>
                <div class="row">
                    <div class="col-6">
                            <label for="supervision-level">Supervision Level</label>
                            <select name="supervision_level" id="supervision-level" class="form-control">
                                <option value="">Select</option>
                                <option value="l1" {{ isset($client) ? ($client->supervision_level == 'l1' ? 'selected="selected"' : '') : ''}}>L1</option>
                                <option value="l2" {{ isset($client) ? ($client->supervision_level == 'l2' ? 'selected="selected"' : '') : ''}}>L2</option>
                                <option value="l3" {{ isset($client) ? ($client->supervision_level == 'l3' ? 'selected="selected"' : '') : ''}}>L3</option>
                                <option value="unknown" {{ isset($client) ? ($client->supervision_level == 'unknown' ? 'selected="selected"' : '') : ''}}>Unknown</option>
                            </select>
                        </div>
    
                    <div class="col-6">
                        <label for="sex-offender">Sex Offender</label>
                        <select name="sex_offender" id="sex_offender" class="form-control">
                            <option value="no" {{ isset($client) ? ($client->sex_offender == 'no' ? 'selected="selected"' : '') : ''}}>No</option>
                            <option value="yes" {{ isset($client) ? ($client->sex_offender == 'yes' ? 'selected="selected"' : '') : ''}}>Yes</option>
                        </select>
                        <input type="text" style="display:none" name="county_registered" id="county_registerd" value="{{ isset($client) ? $client->county_registered : ''}}" placeholder="If So What County" class="form-control">
                    </div>
                </div>
    
                </div>
                <hr>
                <label class="gfield_label" for="input_4_6">Status <span class="gfield_required">*</span></label>
                <select name="status" id="sex" class="form-control" required="required">
                    <option value="">Select</option>
                    <option value="active" {{ isset($client) ? ($client->status == 'active' ? 'selected="selected"' : '') : ''}}>Active</option>
                    <option value="Successfully Completed" {{ isset($client) ? ($client->status == 'Successfully Completed' ? 'selected="selected"' : '') : ''}}>Successfully Completed</option>
                    <option value="Non-compliant" {{ isset($client) ? ($client->status == 'Non-compliant' ? 'selected="selected"' : '') : ''}}>Non-compliant</option>
                    <option value="Moved Away" {{ isset($client) ? ($client->status == 'Moved Away' ? 'selected="selected"' : '') : ''}}>Moved Away</option>
                    <option value="Quit" {{ isset($client) ? ($client->status == 'Quit' ? 'selected="selected"' : '') : ''}}>Dropped Out (Quit)</option>
                    <option value="Re-Arrest" {{ isset($client) ? ($client->status == 'Re-Arrest' ? 'selected="selected"' : '') : ''}}>Re-Arrest</option>
                    <option value="Deceased" {{ isset($client) ? ($client->status == 'Deceased' ? 'selected="selected"' : '') : ''}}>Deceased</option>
                    <option value="No Contact" {{ isset($client) ? ($client->status == 'No Contact' ? 'selected="selected"' : '') : ''}}>No Contact</option>
                    <option value="Transferred" {{ isset($client) ? ($client->status == 'Transferred' ? 'selected="selected"' : '') : ''}}>Transferred</option>
                    <option value="complete" {{ isset($client) ? ($client->status == 'complete' ? 'selected="selected"' : '') : ''}}>Complete</option>
                </select>
                 <hr>
                   <h5>Services</h5>
    
                    @foreach($services as $service)
                        <div class="form-check form-check-inline flex" style="margin:3px 10px; display: -webkit-inline-box">
                            <input type="checkbox" class="form-check-input" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}" {{ isset($client) ? (in_array($service->id, $client->services->pluck('id')->toArray()) ? 'checked="checked"' : '') : ''}}> 
                            <label  class="form-check-label" for="service_{{ $service->id }}">
                                {{ $service->service_name }}<br /> <small><em>Duration: {{ $service->service_duration ?? '' }} Days</em></small>
                            </label>
                        </div>
                    @endforeach
                <br><br> 
           <button class="btn btn-lg btn-primary" type="submit" value="add" name="add">{{ !isset($client) ? "Add A New Client" : 'Update ' .$client->last_name. ', ' .$client->first_name}}</button>
           {{--  <button class="btn btn-lg btn-primary" type="submit" value="add-new" name="add">{{ !isset($client) ? "Add A New Client" : 'Update ' .$client->last_name. ', ' .$client->first_name}} And Create New </button>  --}}
            </form>
    
       </div>
    


@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
        $(document).ready(function(){
            $('#ncdps_id').on('blur', function(){
                var token = "{{ @csrf_token() }}";
                var ncdpsId = $(this).val();
                if(ncdpsId == '')
                {
                    return false;
                }
                $.ajax({
                    method: "POST",
                    url: "/find-user",
                    data: { _token:token, ncdpsId: ncdpsId}
                  })
                  .done(function(data){
                    console.log(data);
                    if(data.first_name){
                        $('#user_does_exist').show()
                    }else{
                        $('#user_does_exist').hide()
                    }
                    });
            });
            $('input').on('blur', function(){
                var age = getBirthday();
                var firstOffense = $("#first_offence_age").val()
                var numberPriors = $("#number_of_priors").val()
                var agefactor = 0;
                var offensefactor = 0;
                var priorsfactor = 0;
                if(age <= 27)
                {
                    agefactor = 2;
                }else if(age > 27 && age <= 35)
                {
                    agefactor = 1
                }else{
                    agefactor = 0
                }

                if(firstOffense <= 17)
                {
                    offensefactor = 2;
                }else if(firstOffense > 17 && firstOffense <= 23)
                {
                    offensefactor = 1
                }else{
                    offensefactor = 0
                }

                
                if(numberPriors <= 1)
                {
                    priorsfactor = 0;
                }else if(numberPriors > 1 && numberPriors <= 5)
                {
                    priorsfactor = 1
                }else{
                    priorsfactor = 2
                }
                var riskfactor = agefactor + offensefactor + priorsfactor;
                if(riskfactor >= 5)
                {
                    $('#risk_level').val('High');
                }
                else if(riskfactor == 4 || riskfactor == 3)
                {
                    $('#risk_level').val('Medium');
                }
                
                else
                {
                    $('#risk_level').val('Low');
                }

                
            });
        })
    function getBirthday()
    {
        let dob = $("#dob").val()
        dob = new Date(dob);
        var today = new Date();
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        return age;
    }
</script>
<script>
$(document).ready(function(){
    $('input').attr('autocomplete','off');
    $('select[name=sex_offender]').on('change', function(){
        $('#county_registerd').hide();
        $('#county_registerd').val('');
       if($(this).val() == 'yes')
       {
        $('#county_registerd').show();
       }
    })
//    $('input#under_supervision').on('click', function(){
//        if($(this).prop("checked"))
//    {
//        $('#under_supervision_section').show();
//    }else{
//        $('#under_supervision_section').hide();
//    }
//    })

});
</script>
@endsection
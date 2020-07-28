@extends('layouts.admin')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@can('clients_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
        </div>
    </div>
@endcan

@section('content')
<style>
    .round { border-radius: 50%; margin:20px auto}
    ul.timeline {
        list-style-type: none;
        position: relative;
    }
    h2{font-size:1.1em; text-decoration: underline; text-transform:uppercase; display: inline-block; margin-right: 5px}
    ul.timeline:before {
        content: ' ';
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 29px;
        width: 2px;
        height: 100%;
    }
    ul.timeline > li {
        margin: 20px 0;
        padding-left: 45px;
    }
    ul.timeline > li:before {
        content: ' ';
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #22c0e8;
        left: 20px;
        width: 20px;
        height: 20px;
    }
    a#title_type
    {
        font-size:18px;
        text-transform:uppercase;
        text-decoration: underline;
        font-weight: 700;
    }
    .service{
      padding:10px;
      border:1px solid #ccc;
      margin:10px;
    }
    
    .card-title, .card-header{
      margin-bottom:0; padding:0
    }
</style>
<div class="row">

<div class="card-column col-3">
    <div class="card">
      <input type="hidden" name="this_id" value="{{ $clients->id }}">
     <img class="round" width="150" height="150" avatar="{{ $clients->first_name ?? ''}} {{ $clients->last_name ?? ''}}">
    @can('client_update')
        <a href="/client/{{ $clients->id }}/edit" class="btn btn-default">Edit/View</a>
    @endcan
     <div class="card-title success" style="text-align:center"><h1>{{ $clients->last_name ?? ''}}, {{ $clients->first_name ?? ''}}</h1></div>
    <div class="card-body">
        <div class="card-text"> 
                {{ $clients->address_1 }} <br>
                {{ $clients->city }}, {{ $clients->state }}, {{ $clients->zip }} <br>
                <a href="tel:{{ $clients->primary_phone }}">{{ $clients->primary_phone }}</a><br />
                <a href="mailTo:{{ $clients->email }}">{{ $clients->email }}</a>
                <small><em>Created: {{ $clients->updated_at->toDateTimeString() }}</em></small>
                
                  @if($clients->jobs)
                  <hr>
                    Current Job(s) <br>
                    <div class="jobs_div">
                    @foreach ($clients->jobs as $job)
                    <span>
                      {{ $job->job_name ?? ''}} | <div id="delete_this" this_id="{{ $job->id ?? ''}}" class="btn btn-sm danger" style="font-weight:900; color:red">X</div> <br>
                      Phone: {{ $job->job_phone ?? ''}} <br>
                      {{ $job->job_address ?? ''}} <br>
                      <small><em> Salary Code: {{ $job->salary ?? ''}} </em></small> <br>
                    <small><em> Start Date:{{ $job->start_date ?? ''}}</em></small> <br>

                    </span>
                    @endforeach
                    @else
                    <small><em>No Job Listed</em></small> 
                  @endif
                </div>
                
        </div>
        <div class="card-footer">
            
        </div>
        <hr>
        <div class="card-title">
          <h4>Services</h4>
          <div class="service_div">

            @foreach($services as $srv)
                  {{--  <a href="#" id="this_service" data-id="{{ $srv->pivot->id }}">  --}}
                   <span class="card-title"> {{ $srv['service_name'] ?? '' }}</span> 
                  {{--  </a>  --}}
                 @if($srv->pivot && $srv->pivot->file_url) 
                    <a href="{{ '/get-file/'.$clients->id.'/'.$srv->pivot->file_url }}"><i class="fas fa-file-export"></i></a> 
                 @endif
                 @if($srv->pivot)
                    <p>{{ $srv->pivot->date_authorized }}</p>
                 @endif
                 <hr />
                  {{--  <p>
                      Expiration:
                      @if(\Carbon\Carbon::now()->diffInDays($clients->enrollment_date) > $srv->service_duration)
                        Expired
                      @else 
                        {{ Carbon\Carbon::parse($clients->enrollment_date)->addDays($srv->service_duration)->toDateString()  }}
                      @endif 
                  
                  @if(\Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($clients->enrollment_date)->addDays($srv->service_duration)->toDateString(), false) > 0 )
                    Expires in ({{ \Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($clients->enrollment_date)->addDays($srv->service_duration)->toDateString(), false) }}) Days
                  @else
                  @endif</p>  --}}
                 
            @endforeach
          </div>
        </div>
    </div>
    </div>
    </div>
    <div class="card-column col-9">
        <div class="col-12 card padding-bottom-3">
        <div class="row">
            <div class="col-6 py-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        +Touch Point
                    </button>   
                    <button type="button" class="btn btn-primary" id='openServicesModal' data-toggle="modal" data-target="#servicesModal">
                        +Accts Payable
                    </button>   
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addJobModal">
                            +Job Data
                        </button>            
            </div>
            <div class="col-6">Last Contact: @if($last_contact !=''){{ $last_contact->toDateTimeString() ?? '' }}@endif</div>
            <div class="touchpoint col-12"></div>
            <div class="col-12">
                    <div class="container mt-5 mb-5">
                          
                                    <h4>Timeline</h4>
                                    <ul class="timeline">
                                        @foreach($notes as $note)
                                        <li>
                                            <a id="title_type" target="_blank" href="#">{{ $note->contact_type ?? '' }}</a>
                                            <a href="#" class="float-right">{{ \Carbon\Carbon::parse($note->note_date)->toDateTimeString() }}</a>
                                            <p>{!! $note->note !!}</p>
                                        </li>
                                       @endforeach
                                       <li>
                                            <a id="title_type" target="_blank" href="#">User Created </a>
                                            <a href="#" class="float-right">{{ $clients->updated_at->toDateTimeString()}}</a>
                                            
                                        </li>
                                    </ul> 
                        </div>
            </div>
            </div>
        </div>
             
        <br>
        
    </div>
</div>

    </div>

     </div>
</div>
@push('modals')
<!-- Modal Add Service-->
<div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModal" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add New Service</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <input type="hidden" name="client_id" id="client_id" value="{{ $clients->id }}">
    <select name="service_name" id="service_name" class="form-control">
        <option value="">Add A Service To Add</option>
       
        @foreach($services as $service)
          <option value="{{ $service['id'] }}">{{ $service['service_name'] }}</option>
        @endforeach
    </select><br>
    {{--  <input type="number" id="service_duration" name="service_duration" class="form-control" placeholder="Service duration in days"><br>  --}}
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="saveService" data-dismiss="modal"  data-target="#exampleModal">Save changes</button>
  </div>
</div>
</div>
</div>
<!-- Modal referral Service-->
<div class="modal fade" id="addReferral" tabindex="-1" role="dialog" aria-labelledby="serviceModal" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Referral</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <input type="hidden" name="client_id" id="client_id" value="{{ $clients->id }}">
    <select name="service_name" id="service_name" class="form-control">
        <option value="">Select A Service</option>
       
        @foreach($services as $service)
        
        <option value="{{ $service['id'] }}">{{ $service['service_name'] }}</option>
        @endforeach
    </select><br>
    {{--  <input type="number" id="service_duration" name="service_duration" class="form-control" placeholder="Service duration in days"><br>  --}}
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="saveService" data-dismiss="modal"  data-target="#exampleModal">Save changes</button>
  </div>
</div>
</div>
</div>
<!-- Modal referral Service-->
<div class="modal fade" id="addJobModal" tabindex="-1" role="dialog" aria-labelledby="addJobModal" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Job Data</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <input type="text" class="form-control" name="job_name" id="job_name" placeholder="Job Name" value=""><br>
    <input type="text" class="form-control" name="job_phone" id="job_phone" placeholder="Job Phone Number" value=""><br>
    <input type="text" class="form-control" name="job_zip" id="job_address" placeholder="Job Address" value=""><br>
    <input type="text" class="form-control" name="job_city" id="job_city" placeholder="Job City" value=""><br>
    <input type="text" class="form-control" name="job_zip" id="job_zip" placeholder="Job Zip" value=""><br>
    <input type="hidden" class="form-control" name="client_id" id="client_id" value="{{ $clients->id }}">
    <select name="job_salary" id="job_salary" class="form-control">
        <option value="">Select A Salary Range</option>
        <option value="min">Minimum Wage</option>
        <option value="minTo8">Up to $8.99</option>
        <option value="upTo10">Up to $10.00</option>
        <option value="over10">Over $10.00</option>
    </select><br>
    Start Date: <br>
    <input type="date" name="job_start_date" id="job_start_date" class="form-control" placeholder="Enter Start Date">
    {{--  <input type="number" id="service_duration" name="service_duration" class="form-control" placeholder="Service duration in days"><br>  --}}
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="saveJobData" data-dismiss="modal"  data-target="#exampleModal">Save changes</button>
  </div>
</div>
</div>
</div>
{{--  Add Services Modal  --}}
<div class="modal fade" id="servicesModal" tabindex="-1" role="dialog" aria-labelledby="servicesModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body" id="addServicesModal">
      <input type="hidden" name="client_id" id="client_id" value="{{ $clients->id }}">
        <select name="service_id" id="service_id" class="form-control" style="margin-bottom:10px;" required="required">
          <option value="">Select A Service</option>
          @foreach($services as $srv)
              <option value="{{ $srv['id'] }}">{{ $srv['service_name'] ?? '' }}</option>
          @endforeach
        </select>
        <div class="form-group">
          <label>Date Authorized:</label>
          <input type="date" name="service_date" id="service_date" class="form-control">
        </div>
        <div class="form-group">
          <label>Amount Authorized $</label>
          <input type="number" value="0.00" name="amount_authorized" id="amount_authorized" class="form-control">
        </div>
        <div class="form-group">
          <label for="service_notes">Additional Info</label>
          <textarea class="form-control" name="service_notes" id="service_notes" rows="3"></textarea>
          <p class="form-text text-muted">
            Add additional information about service, i.e. voucher, bus pass, gas card, etc.
          </p>
          <div class="form-group">
            <label for="upload_file">Upload Invoice</label><br><input type="file" name="upload_name" id="upload_file">
          </div>
        </div>
        {{ csrf_field() }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveServices">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Add Touchpoint-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Touch Point</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
      <input type="hidden" name="client_id" id="client_id" value="{{ $clients->id }}">
    <input type="text" id="input_title" name="contact_type" class="form-control" placeholder="Touchpoint Title"><br>
    <select name="type" id="input_type" class="form-control">
        <option value="">Select Contact Type</option>
        <option value="Phone Call">Phone</option>
        <option value="Email">Email</option>
        <option value="In Person">In Person</option>
        <option value="By Mail">By Mail</option>
        <option value="Other Contact">Other - Leave Details In Note</option>
    </select>
    <label for="note_date">Date of Service</label>
    <input type="date" name="note_date" id="note_date" class="form-control" required value="{{ \Carbon\Carbon::now() ?? '' }}"> <br>
    Start Time:

  <input class="timepicker form-control" name="start_time" id="start_time" type="text"> <br>
    {{--  <input type="number" min="0" max="12" placeholder="Hr" id="hr" name="hr">:<input type="number" min="0" max="59" id="min" value="00"  placeholder="Min" name="min"><select name="am_pm" id="am_pm"><option value="">AM</option><option value="pm">PM</option></select>  --}}
    {{--  <a href="#" class="btn btn-sm btn-default" data-dismiss="modal" data-toggle="modal" data-target="#serviceModal">Add New Service</a>  --}}
    
    <label for="duration">Duration:</label>
    <select name="duration" id="duration" class="form-control">
      <option value="30">30 Minutes</option>
      <option value="60">60 Minutes</option>
      <option value="90">90 Minutes</option>
      <option value="120">120 minutes</option>
      <option value="150">2.5 hours</option>
      <option value="180">3 Hours</option>
      <option value="210">3.5 Hours</option>
      <option value="240">4 Hours</option>
      <option value="270">4.5 Hours</option>
      <option value="300">5 Hours</option>
      <option value="330">5.5 Hours</option>
      <option value="360">6 Hours</option>
      <option value="390">6.5 Hours</option>
      <option value="420">7 Hours</option>
      <option value="450">7.5 Hours</option>
      <option value="480">8 Hours</option>
    </select>
    <br>
    <textarea name="note" id="note" cols="30" rows="10" class="form-control" placeholder="Enter Notes"></textarea>

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="save">Save changes</button>
  </div>
</div>
</div>
</div>
@endpush

@endsection


@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('client_delete')
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
<script>
    $(document).ready(function(){
        $('.table').DataTable();
        $('.btn-danger').on('click', function(e){
            if(confirm('Are You Sure') == false)
            {
                return false;
            }else{
                $(this).parent().parent().fadeOut();
                
                return true;
            }
        });
    });
</script>
<script type="text/javascript">

  $('.timepicker').datetimepicker({

      format: 'LT'

  }); 

</script> 
<script>
    $(document).ready(function(){
      $('#servicesModal').on("hidden.bs.modal", function(){
        clearForm()
      });
      $('#openServicesModal').on('click', function(){
        $('#servicesModal').find('input#saveServices').attr('data-btn-type', '');
        $('#servicesModal').find('input#saveServices').attr('data-id', '');
      })
      const this_id = $('input#this_id').val();
        $('.btn-danger').on('click', function(){
            e.preventDefault();
            if(confirm('Are You Sure') !== true)
            {
                return false;
            }else{
                $(this).parent().parent().fadeOut();
                
                return true;
            }
        });
        $(document).on('click','#save', function(e){
            let card = '<div class="card col-12">'+$('#input_type').val()+'</div>'
            var note = $('#note').val();
            var title = $('#input_title').val();
            var type = $('#input_type').val();
            var token = "{{ @csrf_token() }}";
            var client_id = $('#client_id').val();
            var service_id = $('#service_id').val();
            var note_date = $('#note_date').val();
            var start_time = $('#start_time').val();
            var duration = $('#duration').val();
            if(note == '' || title == '' || start_time == '' || duration == '')
            {
              alert('All fields are required');
              return false;
            }
            $.ajax({
                method: "POST",
                url: "/add-note",
                data: { duration:duration, start_time:start_time, note_date: note_date, note: note, type: type, _token: token, service_id: service_id, title: title, client_id: client_id },
              })
              .done(function(data){
                console.log(data);
                $('.timeline').prepend('<li><a id="title_type" target="_blank" href="#">'+type+' </a><a href="#" class="float-right">' +note_date +'</a><p>'+note+'</p></li>');
              });
                //.done(function() {
                 // alert( "Data Saved: ");
               // });
        });

        $('#saveServices').on('click', function(e){
            e.preventDefault();
            var parentModal = $(this).parent().parent()
            
            var save_type = $(this).attr('data-btn-type')
            var id = $(this).attr('data-id')
            var service_id = parentModal.find('select option:selected').val()
            var auth_price = parentModal.find('#amount_authorized').val()
            var auth_date = parentModal.find('#service_date').val()
            var notes = parentModal.find('#service_notes').val()
            var uploaded_file = $('#upload_file')[0].files[0]
            var token = "{{ @csrf_token() }}";
            var client_id = $('#client_id').val();
            var data1 = new FormData()
            data1.append('uploaded_file', uploaded_file);
            data1.append('service_id', service_id);
            data1.append('auth_price', auth_price);
            data1.append('date_authorized', auth_date);
            data1.append('notes', notes);
            data1.append('token', token);
            data1.append('client_id', client_id);
            data1.append('save_type', save_type);
            axios.post('/add-service', data1)
                .then(data=>{
                   $('.service_div').prepend(`
                <a href="#"><h5 class="card-title"> ${data.data['service_name']}</h5></a>
                <p>${data.data['date_authorized']}</p>
                `)
                $('#servicesModal').find('#saveServices').attr('data-btn-type', '');
                $('#servicesModal').find('#saveServices').attr('data-id', '');

                console.log(data.data);
                clearForm()
                //$('select#service_name  option:selected').hide();
                //$('select#service_id').append('<option value="'+service_id+'">'+service_name+'</option>');
                //$('.timeline').prepend('<li><a id="title_type" target="_blank" href="#">'+type+'</a><a href="#" class="float-right">Now</a><p>'+note+'</p></li>');
              
                })
            
        });
        function clearForm()
        {
          $('select#service_id').val('');
          $('input#service_date').val('')
          $('input#amount_authorized').val('').attr('place-holder', '0.00')
          $('textarea#service_notes').val('')
          $('input#upload_file').val('')
          $('#servicesModal').find('#saveServices').removeAttr('data-btn-type');
          $('#servicesModal').find('#saveServices').removeAttr('data-id');

        }
        $('#saveJobData').on('click', function(e){
            e.preventDefault();
            var job_name = $('#job_name').val();
            var job_address = $('#job_address').val();
            var job_phone = $('#job_phone').val();
            var salary = $('#job_salary').val();
            var start_date = $('#job_start_date').val();
            var job_zip = $('#job_zip').val();
            var job_city = $('#job_city').val();
            var id = $('#client_id').val();
            var token = "{{ @csrf_token() }}";
            $.ajax({
                method: "POST",
                url: "/client/add-job",
                data: { 
                  _token:token, 
                  id:id,
                  job_phone:job_phone,
                  job_city: job_city, 
                  job_zip: job_zip, 
                  start_date: start_date, 
                  salary: salary, 
                  job_name: job_name, 
                  job_address: job_address}
              })
              .done(function(data){
                console.log(data.job_name);
                let update = $('<span> ' + data["job_name"] + ' | <div id="delete_this" this_id="'+data["id"]+'" class="btn btn-sm danger" style="font-weight:900; color:red">X</div> <br>Phone: ' 
                + data["job_phone"] +' <br><small><em> Salary Code: ' 
                + data["job_address"] +' <br><small><em> Salary Code: ' 
                + data["salary"] +' </em></small> <br><small><em> Start Date:' 
                + data["start_date"] +'</em></small> <br></span>')
                $(update).prependTo('.jobs_div')
              });
            
        });
        $(document).on('click', '#delete_this', function(e){
          e.preventDefault();
          var this_div = $(this);
          var id = $(this).attr('this_id');
          var token = "{{ @csrf_token() }}";
          $.ajax({
            method: "POST",
            url: "/client/delete-job",
            data: { 
              _token:token, 
              id:id,
            }
            })
            .done(function(data){
              console.log(data)
              this_div.parent().fadeOut().remove()
            })
        })
        $(document).on('click', '#this_service', function(e){
          e.preventDefault()
          $('#servicesModal').modal('show')
          axios.get('/get-service/'+ $(this).attr('data-id'))
          .then(response =>{
            console.log(response.data)
            $('#servicesModal').find('input#service_date').val(moment(response.data['date_authorized']).format('YYYY-MM-DD'))
            $('#servicesModal').find('#amount_authorized').val(response.data['authorized_price'])
            $('#servicesModal').find('input#service_notes').val(response.data['notes'])
            $('#servicesModal').find('#saveServices').attr('data-btn-type', 'edit');
            $('#servicesModal').find('#saveServices').attr('data-id', response.data['id']);
            $('#servicesModal').find('select#service_id option').val(response.data["service_name"]).attr("selected",true)
          })
          
        })
        
    });

      //  });
    
</script>
@endsection
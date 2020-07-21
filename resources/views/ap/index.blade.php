@extends('layouts.admin')
@auth
    
@section('content')
<br>
<br>
<br>

<div style="text-align:center">
    <form action="/ap/get-month" method="post">
        @csrf
        <select name="searchMonth" class="w-25 border-dark" id="Search Month">
            <option value="">Select Month</option>
            <option {{ $thisDate == 1 ? 'selected' : '' }} value="1">Jan</option>
            <option {{ $thisDate == 2 ? 'selected' : '' }} value="2">Feb</option>
            <option {{ $thisDate == 3 ? 'selected' : '' }} value="3">Mar</option>
            <option {{ $thisDate == 4 ? 'selected' : '' }} value="4">Apr</option>
            <option {{ $thisDate == 5 ? 'selected' : '' }} value="5">May</option>
            <option {{ $thisDate == 6 ? 'selected' : '' }} value="6">Jun</option>
            <option {{ $thisDate == 7 ? 'selected' : '' }} value="7">Jul</option>
            <option {{ $thisDate == 8 ? 'selected' : '' }} value="8">Aug</option>
            <option {{ $thisDate == 9 ? 'selected' : '' }} value="9">Sep</option>
            <option {{ $thisDate == 10 ? 'selected' : '' }} value="10">Oct</option>
            <option {{ $thisDate == 11 ? 'selected' : '' }} value="11">Nov</option>
            <option {{ $thisDate == 12 ? 'selected' : '' }} value="12">Dec</option>
        </select>
        <button class="btn btn-xs btn-dark" type="submit">Switch Month</button>
    </form>
    <strong>Transition/Reentry Support Form</strong><br>						
    Eastern Carolina Council of Government	<br>							
    Invoice # 402.{{ Carbon\Carbon::now()->year }}.{{ Carbon\Carbon::now()->month }}	<br>						
    {{ Carbon\Carbon::create()->month($thisDate)->startOfMonth()->format('m/d') }} - {{ Carbon\Carbon::create()->month($thisDate)->endOfMonth()->format('m/d')  }}<br>
    <br>
</div>
<div class="col-12 text-right">
    <a href="/ap/{{ $thisDate }}/export" class="btn btn-sm btn-dark mr-0">Export</a>
</div>
@if(!$clientData->count())
No Records for Selected Month.... 
@endif
@foreach($clientData as $client)
<h4>{{ $client['first_name'] }}, {{ $client['last_name'] }}</h4>
<table class="table table-sm table-striped">
@foreach($client['services'] as $cs)
    
        <tr>
            <td style="width:30%">{{ $cs['service_name'] }}
                @if($cs['pivot']['file_url'])
                    <a href="{{ '/get-file/'.$cs['pivot']['client_id'].'/'.$cs['pivot']['file_url'] }}"><i class="fas fa-file-export"></i></a> 
                @endif
            </td>
            <td style="width:25%"><label for="">$</label>
                <input type="text" name="authorized_price" id="authorized_price" value="{{ $cs['pivot']['authorized_price'] ?? '0.00'}}" aria-describedby="helpId" placeholder="">
            </td>
            <td style="width:30%"><label for="">Date Auth.</label>
                <input type="date" name="date_authorized" id="date_authorized" value="{{ $cs['pivot']['date_authorized'] ?? 'Not Authorized' }}" aria-describedby="helpId" placeholder="">
            </td>
            <td style="width:15%">
                <button id="updateClient" service-id="{{ $cs['pivot']['service_id'] }}" data-id="{{ $cs['pivot']['id']}}" class="mr-1 btn btn-primary btn-sm">Update</button>
                <button data-id="{{ $cs['pivot']['id']}}" id="deleteThis" class="btn btn-sm btn-danger">X</button>
            </td>
        </tr>
    
      
@endforeach
<tr></tr>
</table>
<hr>
@endforeach
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $(document).on('click','#updateClient', function(){
            let pivot_id = $(this).attr('data-id')
            let service_id = $(this).attr('service-id')
            var authorized_price = $(this).parent().parent().find('#authorized_price').val()
            var date_authorized = $(this).parent().parent().find('#date_authorized').val()
            var token = "{{ @csrf_token() }}"
            axios.post('/ap/update-service', {
                _token:token,
                pivot_id: pivot_id,
                service_id: service_id,
                authorized_price:authorized_price,
                date_authorized:date_authorized,
            })
            .then(response =>{
                console.log(response.data)
                $(this).removeClass('btn-primary').addClass('btn-success').text('Done')
            })
        })
        $(document).on('click', '#deleteThis', function(){
            let id = $(this).attr('data-id')
            axios.get('/ap/'+id+'/delete/')
            .then(response =>{
                $(this).parent().parent().fadeOut()
            })
        })
    });
</script>
@endsection
@endauth
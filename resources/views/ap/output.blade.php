@auth
  
<div style="text-align:center">
    <img src="http://portal.cpreentrync.org/storage/settings/October2019/t92bOKMKU6vBT9RqCIgg.png" width="300px"> <br><br>
    <strong>Transition/Reentry Support Form</strong><br>						
    Eastern Carolina Council of Government	<br>							
    Invoice # 402.{{ Carbon\Carbon::now()->year }}.{{ $id}}	<br>						
    {{ Carbon\Carbon::parse($id.'/01/19')->startOfMonth()->format('m/d/Y')  }} - {{ Carbon\Carbon::parse($id.'/01/19')->endOfMonth()->format('m/d/Y')  }}<br>
    <br>
</div>

<table style="margin:0 auto; width:75%" cellspacing=0>
    <thead>
        <th style="border:1px solid black; padding:10px;">Client Name</th>
        <th style="border:1px solid black; padding:10px 0;" valign="top" colspan="2">Contract Services<hr />
            <div style="text-align:left; font-weight:normal; padding:5px 10px">
            H=Housing<br />	
            T=Transportation (Private)	<br />
            C=Child Care	<br />
            </div>
        </th>
        <th style="border:1px solid black; padding:10px 0;" valign="top" colspan="2">Supplies<hr />
            <div style="text-align:left; font-weight:normal; padding:5px 10px">
                    T= Transportation (Public)	<br />
                    U=Uniforms (Work/School)	<br />
                    W/S=Work/School Related Items	<br />
                    P=Personal Protective Equipment	<br />
                    B=Basic Needs	<br />
            </div>
        </th>
        <th style="border:1px solid black; padding:10px 0;" valign="top" colspan="2">Training<hr />
             <div style="text-align:left; font-weight:normal; padding:5px 10px">
                    T=Tuition	<br />
                    B=Books	<br />
                    F=Fees	<br />
             </div>
        </th>
        <th style="border:1px solid black; padding:10px;">Other</th>
        <th style="border:1px solid black; padding:10px;">TOTAL</th>
    </thead>
    <tbody>
        <tr>
            <td style="padding:5px; border:1px solid #999 "></td>
            <td style="padding:5px; border:1px solid #999">$Amount</td>
            <td style="padding:5px; border:1px solid #999">Code</td>
            <td style="padding:5px; border:1px solid #999">$Amount</td>
            <td style="padding:5px; border:1px solid #999">Code</td>
            <td style="padding:5px; border:1px solid #999">$Amount</td>
            <td style="padding:5px; border:1px solid #999">Code</td>
            <td style="padding:5px; border:1px solid #999">$Amount</td>
            <td style="padding:5px; border:1px solid #999">Total</td>
        </tr>
         <tr><td style="padding:5px; background-color:yellow; border:1px solid #999;font-weight:bold">Total</td><td colspan="8" valign="top" style="padding:5px; border:1px solid #999;background-color:yellow;text-align:right; font-weight:bold">${{ $grandTotal ?? '0.00' }}</td></tr>
        @foreach($clientData as $client)
        <tr>
            <td style="padding:5px; border:1px solid #999;">{{ $client['last'] }}, {{ $client['first'] }}</td>
            <td style="border:1px solid #999; padding:0;" colspan="2" valign="top">
                @if(array_key_exists('contract', $client['service']->toArray()))
                    <table style="width:100%;" cellspacing="0" cellpadding='0'>
                        @foreach($client['service']['contract'] as $contract)
                        <tr>
                            <td width="60%" style="padding:4px; border:1px solid #999">${{ $contract['pivot']['authorized_price'] }}</td>
                            <td style="padding:4px; border:1px solid #999">{{ $contract['short_code'] ?? ''}}</td>
                        </tr> 
                        @endforeach
                    </table>
                @endif
            </td>
            <td style="border:1px solid #999; padding:0;" colspan="2" valign="top"> 
                @if(array_key_exists('supplies', $client['service']->toArray()))
                <table style="width:100%;" cellspacing='0' cellpadding='0'>
                    @foreach($client['service']['supplies'] as $supplies)
                    <tr>
                        <td width="60%" style="padding:4px; border:1px solid #999">${{ $supplies['pivot']['authorized_price'] }}</td>
                        <td style="padding:4px; border:1px solid #999">{{ $supplies['short_code'] ?? ''}}</td>
                    </tr> 
                    @endforeach
                </table> 
                @endif
            </td>
            <td style="border:1px solid #999;" colspan="2" valign="top">
                @if(array_key_exists('training',$client['service']->toArray()))
                <table style="width:100%;" cellspacing="0"> 
                    @foreach($client['service']['training'] as $training)
                    <tr>
                        <td width="70%"style="padding:4px; border:1px solid #999">${{ $training['pivot']['authorized_price'] }}</td>
                        <td style="padding:4px; border:1px solid #999">{{ $training['short_code'] ?? ''}}</td>
                    </tr> 
                    @endforeach
                </table>
                @endif
            </td>
            <td style="padding:5px; border:1px solid #999;" valign="top">
                @if(array_key_exists('other', $client['service']->toArray()))
                    @foreach($client['service']['other'] as $other)
                    ${{ $other['pivot']['authorized_price'] }}
                    @endforeach
                @endif
            </td>
            <td style="padding:5px; border:1px solid #999;" valign="top">${{ $client['total'] }}</td>
        </tr>
            
        @endforeach
    </tbody>
    
    <tfoot>
      <tr><td style="padding:5px; border:1px solid #999; font-weight:bold">Total</td><td colspan="8" valign="top" style="padding:5px; border:1px solid #999;text-align:right; font-weight:bold">${{ $grandTotal ?? '0.00' }}</td></tr>
    </tfoot>
</table>
@endauth

    {{--  {{ $cs['service_name'] }} 
    <div class="form-group">
      <label for="">$</label>
      <input type="text"
        class="form-control" name="authorized_price" id="authorized_price" value="{{ $cs['pivot']['authorized_price'] ?? '0.00'}}" aria-describedby="helpId" placeholder="">
    </div>
    <div class="form-group">
      <label for="">Date Authorized</label>
      <input type="date"
        class="form-control" name="date_authorized" id="date_authorized" value="{{ $cs['pivot']['date_authorized'] ?? 'Not Authorized' }}" aria-describedby="helpId" placeholder="">
    </div>

<hr> --}}

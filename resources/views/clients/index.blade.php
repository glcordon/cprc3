@extends('layouts.admin')
@section('content')
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
       <div class="row" style="margin-top:0.5em">
         <h1>List all Clients <small><em>({{ $clients->count() }})</em></small></h1>
            @if($clients->count() == 0)
                <div class="col-md-12">No Clients To List </div> 
            @endif
       </div>
            <div class="row">
                <div class="col-12" style="text-align:right">
                    {{--  <a href="/client">View All Active<a> | <a href="/client/inactive">View all Inactive Clients</a>  --}}
                </div>
            <div class="col-12">
                <table class="table table-bordered table-striped table-hover datatable datatable-User dataTable no-footer" role="grid" style="margin-left: 0px; width: 1082px;">                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Client Name</th>
                                    <th>Services</th>
                                    <th>Assigned To</th>
                                    <th>Risk</th>
                                    <th>Date Enrolled</th>
                                    <th>Last Contact</th>
                                    <th>Status</th>
                                    <th style="width:15%">
                                            <a href="/client/add" class="btn btn-primary">Add New</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td></td>
                                        <td>{{ $client->last_name ?? ''}}, {{ $client->first_name ?? ''}}
                                            <br><small><em>{{ $client->ncdps_id ?? ''}}</em></small>
                                        </td>
                                        <td>
                                            {{-- {{ dump($client->services) }} --}}
                                            @if(isset($client->services))
                                                @foreach ($client->services->unique() as $service)
                                                    <small><em>{{ $service->service_name }}</em></small><br />
                                                @endforeach
                                            @endif
             
                                        </td>
                                        <td>{{ $client->assignedTo->name ?? 'Not Assigned'}}<br />
                                            {{--  @if(!$client->assignedTo)
                                                <a href="#" id="assign_caseworker" class="btn btn-default">Assign Case Worker</a>
                                            @endif  --}}
                                        </td>
                                        <td>{{ $client->risk_level }}</td>
                                        <td>                                            
                                            {{ $client->enrollment_date ?? ' - ' }}
                                        </td>
                                        <td>{{ $client->notes->first()->created_at ?? '' }}</td>
                                        <td>{{ $client->status }}</td>
                                        <td>
                                                @can('client_create')
                                                    <a href="/client/{{ $client->id }}/show/" class="btn-success btn btn-sm">Touch</a>
                                                @endcan
                                                
                                               @can('client_update')
                                                    <a href="/client/{{ $client->id }}/edit" class="btn btn-primary btn-sm">Edit</a>
                                                @endcan
                                                {{--  <button class="btn btn-primary"> View Notes</button>  --}}
                                                @can('client_delete')
                                                    <a href="/delete-client/{{ $client->id }}" id="delete" class="btn btn-danger btn-sm"> <span class="glyphicon glyphicon-remove"><strong> X </strong></span></a>
                                                @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>
            </div>
           
  
</div>

     </div>

   </div>


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
    order: [[ 5, 'desc' ]],
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
@endsection
@can('vendor_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.vendors.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.vendor.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.vendor.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-servicesVendors">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_email') }}
                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_address_1') }}
                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_address_2') }}
                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_city') }}
                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_state') }}
                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_zip') }}
                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.is_active') }}
                        </th>
                        <th>
                            {{ trans('cruds.vendor.fields.services') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $key => $vendor)
                        <tr data-entry-id="{{ $vendor->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $vendor->id ?? '' }}
                            </td>
                            <td>
                                {{ $vendor->vendor_name ?? '' }}
                            </td>
                            <td>
                                {{ $vendor->vendor_phone ?? '' }}
                            </td>
                            <td>
                                {{ $vendor->vendor_email ?? '' }}
                            </td>
                            <td>
                                {{ $vendor->vendor_address_1 ?? '' }}
                            </td>
                            <td>
                                {{ $vendor->vendor_address_2 ?? '' }}
                            </td>
                            <td>
                                {{ $vendor->vendor_city ?? '' }}
                            </td>
                            <td>
                                {{ $vendor->vendor_state ?? '' }}
                            </td>
                            <td>
                                {{ $vendor->vendor_zip ?? '' }}
                            </td>
                            <td>
                                {{ App\Vendor::IS_ACTIVE_SELECT[$vendor->is_active] ?? '' }}
                            </td>
                            <td>
                                @foreach($vendor->services as $key => $item)
                                    <span class="badge badge-info">{{ $item->service_name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('vendor_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.vendors.show', $vendor->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('vendor_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.vendors.edit', $vendor->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('vendor_delete')
                                    <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('vendor_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.vendors.massDestroy') }}",
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
  let table = $('.datatable-servicesVendors:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
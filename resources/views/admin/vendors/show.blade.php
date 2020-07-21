@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vendor.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vendors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.id') }}
                        </th>
                        <td>
                            {{ $vendor->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_name') }}
                        </th>
                        <td>
                            {{ $vendor->vendor_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_phone') }}
                        </th>
                        <td>
                            {{ $vendor->vendor_phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_email') }}
                        </th>
                        <td>
                            {{ $vendor->vendor_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_address_1') }}
                        </th>
                        <td>
                            {{ $vendor->vendor_address_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_address_2') }}
                        </th>
                        <td>
                            {{ $vendor->vendor_address_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_city') }}
                        </th>
                        <td>
                            {{ $vendor->vendor_city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_state') }}
                        </th>
                        <td>
                            {{ $vendor->vendor_state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.vendor_zip') }}
                        </th>
                        <td>
                            {{ $vendor->vendor_zip }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Vendor::IS_ACTIVE_SELECT[$vendor->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vendor.fields.services') }}
                        </th>
                        <td>
                            @foreach($vendor->services as $key => $services)
                                <span class="label label-info">{{ $services->service_name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vendors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
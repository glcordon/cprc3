@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.vendor.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.vendors.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="vendor_name">{{ trans('cruds.vendor.fields.vendor_name') }}</label>
                <input class="form-control {{ $errors->has('vendor_name') ? 'is-invalid' : '' }}" type="text" name="vendor_name" id="vendor_name" value="{{ old('vendor_name', '') }}" required>
                @if($errors->has('vendor_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vendor_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.vendor_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="vendor_phone">{{ trans('cruds.vendor.fields.vendor_phone') }}</label>
                <input class="form-control {{ $errors->has('vendor_phone') ? 'is-invalid' : '' }}" type="text" name="vendor_phone" id="vendor_phone" value="{{ old('vendor_phone', '') }}" required>
                @if($errors->has('vendor_phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vendor_phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.vendor_phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="vendor_email">{{ trans('cruds.vendor.fields.vendor_email') }}</label>
                <input class="form-control {{ $errors->has('vendor_email') ? 'is-invalid' : '' }}" type="email" name="vendor_email" id="vendor_email" value="{{ old('vendor_email') }}">
                @if($errors->has('vendor_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vendor_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.vendor_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="vendor_address_1">{{ trans('cruds.vendor.fields.vendor_address_1') }}</label>
                <input class="form-control {{ $errors->has('vendor_address_1') ? 'is-invalid' : '' }}" type="text" name="vendor_address_1" id="vendor_address_1" value="{{ old('vendor_address_1', '') }}">
                @if($errors->has('vendor_address_1'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vendor_address_1') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.vendor_address_1_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="vendor_address_2">{{ trans('cruds.vendor.fields.vendor_address_2') }}</label>
                <input class="form-control {{ $errors->has('vendor_address_2') ? 'is-invalid' : '' }}" type="text" name="vendor_address_2" id="vendor_address_2" value="{{ old('vendor_address_2', '') }}">
                @if($errors->has('vendor_address_2'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vendor_address_2') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.vendor_address_2_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="vendor_city">{{ trans('cruds.vendor.fields.vendor_city') }}</label>
                <input class="form-control {{ $errors->has('vendor_city') ? 'is-invalid' : '' }}" type="text" name="vendor_city" id="vendor_city" value="{{ old('vendor_city', '') }}">
                @if($errors->has('vendor_city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vendor_city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.vendor_city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="vendor_state">{{ trans('cruds.vendor.fields.vendor_state') }}</label>
                <input class="form-control {{ $errors->has('vendor_state') ? 'is-invalid' : '' }}" type="text" name="vendor_state" id="vendor_state" value="{{ old('vendor_state', '') }}">
                @if($errors->has('vendor_state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vendor_state') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.vendor_state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="vendor_zip">{{ trans('cruds.vendor.fields.vendor_zip') }}</label>
                <input class="form-control {{ $errors->has('vendor_zip') ? 'is-invalid' : '' }}" type="text" name="vendor_zip" id="vendor_zip" value="{{ old('vendor_zip', '') }}">
                @if($errors->has('vendor_zip'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vendor_zip') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.vendor_zip_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.vendor.fields.is_active') }}</label>
                <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                    <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Vendor::IS_ACTIVE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('is_active', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('is_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="services">{{ trans('cruds.vendor.fields.services') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('services') ? 'is-invalid' : '' }}" name="services[]" id="services" multiple required>
                    @foreach($services as $id => $services)
                        <option value="{{ $id }}" {{ in_array($id, old('services', [])) ? 'selected' : '' }}>{{ $services }}</option>
                    @endforeach
                </select>
                @if($errors->has('services'))
                    <div class="invalid-feedback">
                        {{ $errors->first('services') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vendor.fields.services_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
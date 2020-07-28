@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.service.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.services.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="service_name">{{ trans('cruds.service.fields.service_name') }}</label>
                <input class="form-control {{ $errors->has('service_name') ? 'is-invalid' : '' }}" type="text" name="service_name" id="service_name" value="{{ old('service_name', '') }}" required>
                @if($errors->has('service_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('service_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.service_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="service_code">{{ trans('cruds.service.fields.service_code') }}</label>
                <input class="form-control {{ $errors->has('service_code') ? 'is-invalid' : '' }}" type="text" name="service_code" id="service_code" value="{{ old('service_code', '') }}">
                @if($errors->has('service_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('service_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.service_code_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_billable') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="is_billable" id="is_billable" value="1" required {{ old('is_billable', 0) == 1 || old('is_billable') === null ? 'checked' : '' }}>
                    <label class="required form-check-label" for="is_billable">{{ trans('cruds.service.fields.is_billable') }}</label>
                </div>
                @if($errors->has('is_billable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_billable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.is_billable_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="service_type">{{ trans('cruds.service.fields.service_type') }}</label>
                {{-- <input class="form-control {{ $errors->has('service_type') ? 'is-invalid' : '' }}" type="text" name="service_type" id="service_type" value="{{ old('service_type', '') }}" required> --}}
                <select class="form-control {{ $errors->has('service_type') ? 'is-invalid' : '' }}" name="service_type" id="">
                    <option value="">--Select One--</option>
                    <option value="contract" {{ old('service_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                    <option value="supplies" {{ old('service_type') == 'supplies' ? 'selected' : '' }}>Supplies</option>
                    <option value="other" {{ old('service_type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @if($errors->has('service_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('service_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.service_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="short_code">{{ trans('cruds.service.fields.short_code') }}</label>
                <input class="form-control {{ $errors->has('short_code') ? 'is-invalid' : '' }}" type="text" name="short_code" id="short_code" value="{{ old('short_code', '') }}" required>
                @if($errors->has('short_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('short_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.short_code_helper') }}</span>
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
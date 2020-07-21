<?php

namespace App\Http\Requests;

use App\Service;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreServiceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'service_name' => [
                'required',
            ],
            'is_billable'  => [
                'required',
            ],
            'service_type' => [
                'required',
            ],
            'short_code'   => [
                'required',
            ],
        ];
    }
}

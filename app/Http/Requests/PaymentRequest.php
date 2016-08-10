<?php

namespace App\Http\Requests;


use App\Facades\PaymentLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use App\Models\Service;

class PaymentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return $this->checkService();
    }

    // On faillure response
    public function forbiddenResponse()
    {
        return Response::make('Permission denied foo!', 403);
    }

    /**
     *
     * @param $request
     * @return bool
     */
    protected function checkService()
    {
        try
        {
            $service = Service::findOrFail($this->input('service_id'));
            $this->Transaction = PaymentLoader::load($service, $this->input('payload'));

        } catch (\Exception $e)
        {
            return App::abort(401, 'Le service n\'a pas été identifié ');
        }

        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}

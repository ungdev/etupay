<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Validator;

class TransactionController extends ApiController
{
    public function selfUpdate(Request $request, Transaction $transaction)
    {
        if(!$transaction)
        {
            abord('404');
        }

        $rules = [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'client_mail' => 'required|email'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            return responder()->error(403, 'Modification des infos utilisateurs impossible');
        }
        $data = $validator->validate();
        $transaction->firstname = $data['firstname'];
        $transaction->lastname = $data['lastname'];
        $transaction->client_mail = $data['client_mail'];
        $transaction->save();

        return responder()->success(['message' => 'Informations de facturation enregistré !']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Facades\Currencies;
use App\Http\Requests\CalculateRequest;
use App\ICurrencies;

class CurrencyController extends Controller
{
    /**
     * @param ICurrencies $Currencies
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(ICurrencies $Currencies)
    {
        $Currencies->getList(); // eager load
        return view('currency', ['Currencies' => $Currencies]);
    }

    /**
     * @param CalculateRequest $request
     * @param ICurrencies $Currencies
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate(CalculateRequest $request, ICurrencies $Currencies)
    {
        if ($request->ajax() === true && $request->isMethod('post') === true) {
            $mastercode     = $request->input('currency_select_a');
            $mastervalue    = $request->input('currency_value_a');
            $secondarycode  = $request->input('currency_select_b');
            $secondaryvalue = $request->input('currency_value_b');

            $Currencies->getList(); // eager load

            $Master = $Currencies->getCurrency($mastercode)->addValue($mastervalue);
            $Currency = $Currencies->getCurrency($secondarycode)->addValue($secondaryvalue);

            $Master->attachCurrency($Currency);
            $Master->calculate();

            $secondaries = $Master->getObservers();
            $secondary = reset($secondaries);

            return response()->json([
                'master_value' => $Master->value,
                'secondary_value' => round($secondary->value, 2),
            ]);
        } else {
            abort(404, 'Page not found');
        }
    }
}

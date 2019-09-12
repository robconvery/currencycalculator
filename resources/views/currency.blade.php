@extends('layout.app')

@section('title', 'Currency Converter')

@section('content')


        <h1>Currency Converter</h1>

        <p class="mb-0" id="message-a">1 {{ $Currencies->getFirst()->targetName }} equals</p>

        <p id="message-b" class="">1 {{ $Currencies->getFirst()->targetName }}</p>

        <form name="frm" id="frm" method="post" action="{{ route('converter') }}">

            <div class="row mb-3">

                <div class="input-group col-sm-3">

                    <div class="input-group-prepend">
                        <span class="input-group-text">#</span>
                    </div>

                    <input type="number" class="form-control currency-value" aria-label="Currency amount" value="{{ 1 }}" data-toggle="tooltip" title="Please enter the currency amount to convert" id="currency_value_a" name="currency_value_a">

                </div>

                <div class="input-group col-sm-5">

                    <select class="form-control currency-select" title="Select a currency" id="currency_select_a" name="currency_select_a">
                        @foreach($Currencies->getList() as $currency)
                            <option value="{{$currency->targetCurrency }}">{{$currency->targetName}}</option>
                        @endforeach
                    </select>

                </div>

            </div>

            <div class="row">

                <div class="input-group col-sm-3">

                    <div class="input-group-prepend">
                        <span class="input-group-text">#</span>
                    </div>

                    <input type="number" class="form-control currency-value" aria-label="Currency amount" value="{{ 1 }}"  title="Please enter the currency amount to convert" id="currency_value_b" name="currency_value_b">

                </div>

                <div class="input-group col-sm-5">

                    <select class="form-control currency-select" id="currency_select_b" name="currency_select_b">
                        @foreach($Currencies->getList() as $currency)
                            <option value="{{$currency->targetCurrency }}">{{$currency->targetName}}</option>
                        @endforeach
                    </select>

                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <small class="mt-5">Data provided by <a href="http://www.floatrates.com/daily/gbp.xml" target="_blank">floatrates.com</a></small>
                </div>
            </div>


        </form>

@endsection

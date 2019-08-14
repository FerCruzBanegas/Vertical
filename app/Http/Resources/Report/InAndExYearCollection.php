<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InAndExYearCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'dataSource' => ['data' => $this->collection],
            'slice' => [
                'rows' => array([
                    'uniqueName' => "year",
                    'caption' => "Año",
                    'sort' => "unsorted"
                ]),
                'columns' => array([
                    'uniqueName' => "[Measures]"
                ]),
                'measures' => array(
                    [
                       'uniqueName' => "income",
                       'aggregation' => "sum",
                       'grandTotalCaption' => "Ingresos"
                    ],
                    [
                       'uniqueName' => "expense",
                       'aggregation' => "sum",
                       'grandTotalCaption' => "Egresos"
                    ],
                    [
                       'uniqueName' => "diff",
                       'formula' => "sum('income') - sum('expense')",
                       'caption' => "Ahorro Anual"
                    ]
                )
            ],
            'options' => ['grid' => ['title' => "Ingresos / Egresos por Año"]],
            'formats' => array([
                'name' => "",
                'thousandsSeparator' => ",",
                'decimalSeparator' => ".",
                'decimalPlaces' => 2,
                'maxSymbols' => 20,
                'currencySymbol' => "",
                'currencySymbolAlign' => "left",
                'nullValue' => "",
                'infinityValue' => "Infinity",
                'divideByZeroValue' => "Infinity"
            ])
        ];
    }
}

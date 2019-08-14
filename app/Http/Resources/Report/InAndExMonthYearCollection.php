<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InAndExMonthYearCollection extends ResourceCollection
{
    private $params;

    public function __construct($collection, $params)
    {
        parent::__construct($collection);
        $this->collection = $collection;
        $this->params = $params;
    }

    public function toArray($request)
    {
        return [
            'dataSource' => ['data' => $this->collection],
            'slice' => [
                'rows' => array([
                    'uniqueName' => "month",
                    'caption' => "mes",
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
            'options' => ['grid' => ['title' => "Ingresos / Egresos Mensual por Año {$this->params}"]],
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

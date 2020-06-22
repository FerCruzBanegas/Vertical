<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InAndExTypeProjectCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'dataSource' => ['data' => $this->collection->transform(function($data){
                    return [
                        'tipo' => $data->name,
                        'ingresos' => $data->inc_amount,
                        'egresos' => $data->exp_amount
                    ];
                })
            ],
            'slice' => [
                'rows' => array([
                    'uniqueName' => "tipo",
                    'caption' => "Año",
                    'sort' => "unsorted"
                ]),
                'columns' => array([
                    'uniqueName' => "[Measures]"
                ]),
                'measures' => array(
                    [
                       'uniqueName' => "ingresos",
                       'aggregation' => "sum",
                       'grandTotalCaption' => "Ingresos"
                    ],
                    [
                       'uniqueName' => "egresos",
                       'aggregation' => "sum",
                       'grandTotalCaption' => "Egresos"
                    ],
                    [
                       'uniqueName' => "diff",
                       'formula' => "sum('ingresos') - sum('egresos')",
                       'caption' => "Ahorro Anual"
                    ]
                )
            ],
            'options' => ['grid' => ['title' => "Ingresos / Egresos por Tipo de Proyecto"]],
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

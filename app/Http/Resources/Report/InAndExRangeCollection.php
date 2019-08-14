<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class InAndExRangeCollection extends ResourceCollection
{
    private $params;

    public function __construct($collection, $params)
    {
        parent::__construct($collection);
        $this->collection = $collection;
        $this->params = Carbon::parse($params[0])->format('d/m/Y').' al '.Carbon::parse($params[1])->format('d/m/Y');
    }

    public function toArray($request)
    {
        return [
            'dataSource' => ['data' => $this->collection->transform(function($data){
                    return [
                        'title' => $data->title,
                        'payment' => $data->payment,
                        'date' => Carbon::parse($data->date)->format('d/m/Y'),
                        'project' => $data->name,
                        'income' => $data->inc_amount,
                        'expense' => $data->exp_amount
                    ];
                })
            ],
            'slice' => [
                'rows' => array(
                    [
                        'uniqueName' => "title",
                        'caption' => "Título",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "payment",
                        'caption' => "Tipo de Pago",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "date",
                        'caption' => "Fecha",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "project",
                        'caption' => "Proyecto",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "income",
                        'caption' => "Ingreso",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "expense",
                        'caption' => "Egreso",
                        'sort' => "unsorted"
                    ]
                ),
                'measures' => array(
                    [
                       'uniqueName' => "income",
                       'aggregation' => "sum",
                    ],
                    [
                       'uniqueName' => "expense",
                       'aggregation' => "sum",
                    ],
                    [
                       'uniqueName' => "diff",
                       'formula' => "sum('income') - sum('expense')",
                       'caption' => "Diferencia"
                    ]
                ),
                'flatOrder' => ['title', 'payment', 'date', 'project', 'income', 'expense']
            ],
            'conditions' => array(
                [
                    'formula' => "#value > 0",
                    'measure' => "income",
                    'format' => [
                        "backgroundColor" => "#AED581",
                        "color" => "#000000",
                        "fontFamily" => "Arial",
                        "fontSize" => "12px"
                    ]
                ],
                [
                    'formula' => "#value > 0",
                    'measure' => "expense",
                    'format' => [
                        "backgroundColor" => "#E57373",
                        "color" => "#000000",
                        "fontFamily" => "Arial",
                        "fontSize" => "12px"
                    ]
                ]
            ),
            'options' => [
                'grid' => [
                    'title' => "Ingresos / Egresos desde {$this->params}",
                    'type' => "flat",
                    'showTotals' => "on",
                    'showGrandTotals' => "on"
                ]
            ],
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

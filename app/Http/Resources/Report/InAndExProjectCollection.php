<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class InAndExProjectCollection extends ResourceCollection
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
            'dataSource' => ['data' => $this->collection->transform(function($data){
                    return [
                        'titulo' => $data->title,
                        'pago' => $data->payment,
                        'fecha' => Carbon::parse($data->date)->format('d/m/Y'),
                        'ingresos' => $data->inc_amount,
                        'egresos' => $data->exp_amount
                    ];
                })
            ],
            'slice' => [
                'rows' => array(
                    [
                        'uniqueName' => "titulo",
                        'caption' => "Título",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "pago",
                        'caption' => "Tipo de Pago",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "fecha",
                        'caption' => "Fecha",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "ingresos",
                        'caption' => "Ingreso",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "egresos",
                        'caption' => "Egreso",
                        'sort' => "unsorted"
                    ]
                ),
                'columns' => array([
                    'uniqueName' => "[Measures]"
                ]),
                'measures' => array(
                    [
                       'uniqueName' => "ingresos",
                       'aggregation' => "sum",
                       'format' => "ingresos"
                    ],
                    [
                       'uniqueName' => "egresos",
                       'aggregation' => "sum",
                       'format' => "egresos"
                    ],
                    [
                       'uniqueName' => "diff",
                       'formula' => "sum('ingresos') - sum('egresos')",
                       'caption' => "Diferencia"
                    ]
                ),
                // 'sorting' => array(
                //     'column' => [
                //         'type' => "desc",
                //         'tuple' => ['date'],
                //     ]
                // ),
                'flatOrder' => ['titulo', 'pago', 'fecha', 'ingresos', 'egresos']
            ],
            'conditions' => array(
                [
                    'formula' => "#value > 0",
                    'measure' => "ingresos",
                    'format' => [
                        "backgroundColor" => "#AED581",
                        "color" => "#000000",
                        "fontFamily" => "Arial",
                        "fontSize" => "12px"
                    ]
                ],
                [
                    'formula' => "#value > 0",
                    'measure' => "egresos",
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
                    'title' => "Ingresos / Egresos De {$this->params}",
                    'type' => "flat",
                    'showGrandTotals' => "on"
                ]
            ],
            'formats' => array(
                [
                    'name' => "ingresos",
                    'thousandsSeparator' => ",",
                    'decimalSeparator' => ".",
                    'decimalPlaces' => 2,
                    'maxSymbols' => 20,
                    'currencySymbol' => "",
                    'currencySymbolAlign' => "left",
                    'nullValue' => "",
                    'infinityValue' => "Infinity",
                    'divideByZeroValue' => "Infinity"
                ],
                [
                    'name' => "egresos",
                    'thousandsSeparator' => ",",
                    'decimalSeparator' => ".",
                    'decimalPlaces' => 2,
                    'maxSymbols' => 20,
                    'currencySymbol' => "",
                    'currencySymbolAlign' => "left",
                    'nullValue' => "",
                    'infinityValue' => "Infinity",
                    'divideByZeroValue' => "Infinity"
                ]
            )
        ];
    }
}

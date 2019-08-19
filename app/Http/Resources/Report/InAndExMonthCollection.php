<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class InAndExMonthCollection extends ResourceCollection
{
    private $params;
    private $months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    public function __construct($collection, $params)
    {
        parent::__construct($collection);
        $this->collection = $collection;
        $this->params = $this->months[substr($params, 5)-1].' '.substr($params, 0, 4);
    }

    public function toArray($request)
    {
        return [
            'dataSource' => ['data' => $this->collection->transform(function($data){
                    return [
                        'titulo' => $data->title,
                        'pago' => $data->payment,
                        'fecha' => Carbon::parse($data->date)->format('d/m/Y'),
                        'proyecto' => $data->name,
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
                        'uniqueName' => "proyecto",
                        'caption' => "Proyecto",
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
                'measures' => array(
                    [
                       'uniqueName' => "ingresos",
                       'aggregation' => "sum",
                    ],
                    [
                       'uniqueName' => "egresos",
                       'aggregation' => "sum",
                    ],
                    [
                       'uniqueName' => "diff",
                       'formula' => "sum('ingresos') - sum('egresos')",
                       'caption' => "Diferencia"
                    ]
                ),
                'flatOrder' => ['titulo', 'pago', 'fecha', 'proyecto', 'ingresos', 'egresos']
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
                    'title' => "Ingresos / Egresos - {$this->params}",
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

<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class ExPersonProjectCollection extends ResourceCollection
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
                        'fecha' => Carbon::parse($data->date)->format('d/m/Y'),
                        'persona' => $data->name,
                        'total' => $data->amount,
                    ];
                })
            ],
            'slice' => [
                'rows' => array(
                    [
                        'uniqueName' => "titulo",
                        'caption' => "Título Egreso",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "fecha",
                        'caption' => "Fecha Egreso",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "persona",
                        'caption' => "Nombre Persona",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "total",
                        'caption' => "Monto Total",
                        'sort' => "unsorted"
                    ]
                ),
                'measures' => array(
                    [
                       'uniqueName' => "total",
                       'aggregation' => "sum",
                       'format' => "total"
                    ]
                ),
                'flatOrder' => ['titulo', 'fecha', 'persona', 'total']
            ],
            'options' => [
                'grid' => [
                    'title' => "Gasto de Personas: {$this->params}",
                    'type' => "flat",
                    'showTotals' => "on",
                    'showGrandTotals' => "on"
                ]
            ],
            'formats' => array(
                [
                    'name' => "total",
                    'thousandsSeparator' => ",",
                    'decimalSeparator' => ".",
                    'decimalPlaces' => 2,
                    'maxSymbols' => 20,
                    'currencySymbol' => "",
                    'currencySymbolAlign' => "left",
                    'nullValue' => "-",
                    'infinityValue' => "Infinity",
                    'divideByZeroValue' => "Infinity"
                ]
            )
        ];
    }
}

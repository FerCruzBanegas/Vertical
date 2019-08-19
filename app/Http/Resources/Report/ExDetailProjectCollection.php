<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class ExDetailProjectCollection extends ResourceCollection
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
                        'tipo' => $data->type,
                        'pago' => $data->payment,
                        'fecha' => Carbon::parse($data->date)->format('d/m/Y'),
                        'material' => is_null($data->material) ? '-' : $data->material,
                        'medida' => is_null($data->unity) ? '-' : $data->unity,
                        'cantidad' => $data->quantity,
                        'monto' => $data->amount,
                        'total' => $data->total
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
                        'uniqueName' => "tipo",
                        'caption' => "Tipo Egreso",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "pago",
                        'caption' => "Pago",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "fecha",
                        'caption' => "Fecha",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "material",
                        'caption' => "Material",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "medida",
                        'caption' => "Medida",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "cantidad",
                        'caption' => "Cantidad",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "monto",
                        'caption' => "Monto",
                        'sort' => "unsorted"
                    ],
                    [
                        'uniqueName' => "total",
                        'caption' => "Total",
                        'sort' => "unsorted"
                    ]
                ),
                'measures' => array(
                    [
                       'uniqueName' => "cantidad",
                       'aggregation' => "sum",
                       'format' => "cantidad"
                    ],
                    [
                       'uniqueName' => "monto",
                       'aggregation' => "sum",
                       'format' => "monto"
                    ],
                    [
                       'uniqueName' => "total",
                       'aggregation' => "sum",
                       'format' => "total"
                    ]
                ),
                'flatOrder' => ['titulo', 'tipo', 'pago', 'fecha', 'material', 'medida', 'cantidad', 'monto', 'total']
            ],
            'options' => [
                'grid' => [
                    'title' => "Detalle de Egresos: {$this->params}",
                    'type' => "flat",
                    'showTotals' => "on",
                    'showGrandTotals' => "on"
                ]
            ],
            'formats' => array(
                [
                    'name' => "cantidad",
                    'nullValue' => "-",
                    'infinityValue' => "Infinity",
                    'divideByZeroValue' => "Infinity"
                ],
                [
                    'name' => "monto",
                    'thousandsSeparator' => ",",
                    'decimalSeparator' => ".",
                    'decimalPlaces' => 2,
                    'maxSymbols' => 20,
                    'currencySymbol' => "",
                    'currencySymbolAlign' => "left",
                    'nullValue' => "-",
                    'infinityValue' => "Infinity",
                    'divideByZeroValue' => "Infinity"
                ],
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

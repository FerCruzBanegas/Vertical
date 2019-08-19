<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExMaterialProjectCollection extends ResourceCollection
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
                        'tipo' => $data->type,
                        'material' => $data->name,
                        'medida' => $data->unity,
                        'cantidad' => $data->quantity,
                        'total' => $data->total
                    ];
                })
            ],
            'slice' => [
                'rows' => array(
                    [
                        'uniqueName' => "tipo",
                        'caption' => "Tipo de Material",
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
                       'uniqueName' => "total",
                       'aggregation' => "sum",
                       'format' => "total"
                    ]
                ),
                'flatOrder' => ['tipo', 'material', 'medida', 'cantidad', 'total']
            ],
            'options' => [
                'grid' => [
                    'title' => "Gasto de Materiales: {$this->params}",
                    'type' => "flat",
                    'showTotals' => "on",
                    'showGrandTotals' => "on"
                ]
            ],
            'formats' => array(
                [
                    'name' => "cantidad",
                    'nullValue' => "",
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

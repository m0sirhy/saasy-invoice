<?php

namespace App\WireTables;

class ProductsWireTable extends WireTable
{
    public $model = "App\Product";

    public $title = "Products";

    public $create = "products.create";

    public $joins = [
    ];

    public $table = [
        'products.id' => [],
        'products.name' => [
            'search' => true,
            'header' => [
                'title' => 'Product Name',
                'sort' => true
            ],
            'cell' => [
                'display' => 'name',
                'link' => [
                    'route' => 'products.show',
                    'params' => [
                        'name' => 'product',
                        'value' => 'id'
                    ],
                    'class' => 'link'
                ]
            ]
        ]
    ];
}

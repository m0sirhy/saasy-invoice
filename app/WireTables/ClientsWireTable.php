<?php

namespace App\WireTables;

class ClientsWireTable extends WireTable
{
    public $model = "App\Client";

    public $title = "Clients";

    public $create = "clients.create";

    public $joins = [

    ];

    public $table = [
        'clients.id' => [
            'search' => true,
            'header' => [
                'title' => 'ID',
                'sort' => true
            ],
            'cell' => [
                'display' => 'id',
                'link' => [
                    'route' => 'clients.show',
                    'params' => [
                        'name' => 'client',
                        'value' => 'id'
                    ],
                    'class' => 'link'
                ]
            ]
        ],
        'clients.name' => [
            'search' => true,
            'header' => [
                'title' => 'Client',
                'sort' => true
            ],
            'cell' => [
                'display' => 'name',
            ]
        ],
        'clients.email' => [
            'search' => true,
            'header' => [
                'title' => 'Email',
                'sort' => true
            ],
            'cell' => [
                'display' => 'email',
            ]
        ],
        'clients.balance' => [
            'search' => true,
            'header' => [
                'title' => 'Balance',
                'sort' => true
            ],
            'cell' => [
                'display' => 'balance',
            ],
            'dollar' => true
        ],
    ];
}

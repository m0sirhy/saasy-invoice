<?php

namespace App\WireTables;

class CreditsWireTable
{
    public $model = "App\Credit";

    public $title = "Credits";

    public $create = "credits.create";

    public $table = [
        'credits.id' => [
            'search' => true,
            'header' => [
                'title' => 'ID',
                'sort' => true
            ],
            'cell' => [
                'display' => 'id',
                'link' => [
                    'route' => 'credits.edit',
                    'params' => [
                        'name' => 'credit',
                        'value' => 'id'
                    ],
                    'class' => 'link'
                ]
            ]
        ],
        'credits.client_id' => [],
        'clients.name' => [
            'search' => true,
            'header' => [
                'title' => 'Client',
                'sort' => true
            ],
            'cell' => [
                'display' => 'name',
                'link' => [
                    'route' => 'clients.show',
                    'params' => [
                        'name' => 'client',
                        'value' => 'client_id'
                    ],
                    'class' => 'link'
                ]
            ]
        ],
        'credits.balance' => [
            'search' => true,
            'header' => [
                'title' => 'Remaining Balance',
                'sort' => true
            ],
            'cell' => [
                'display' => 'balance',
            ],
            'dollar' => true
        ],
        'credits.amount' => [
            'search' => true,
            'header' => [
                'title' => 'Amount',
                'sort' => true
            ],
            'cell' => [
                'display' => 'amount',
            ],
            'dollar' => true
        ],
        'credits.credit_date' => [
            'search' => true,
            'header' => [
                'title' => 'Date',
                'sort' => true
            ],
            'cell' => [
                'display' => 'credit_date',
            ],
            'carbon' => true
        ],
        'credits.public_notes' => [
            'search' => true,
            'header' => [
                'title' => 'Public Notes',
                'sort' => true
            ],
            'cell' => [
                'display' => 'public_notes',
            ],
            'limit' => true
        ]
    ];
}

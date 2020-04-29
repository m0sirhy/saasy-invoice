<?php

namespace App\WireTables;

class PaymentsWireTable extends WireTable
{
    public $model = "App\Payment";

    public $title = "Payments";

    public $create = "payments.create";

    public $joins = [
        ['clients', 'payments.client_id', 'clients.id']
    ];

    public $table = [
        'payments.id' => [
            'search' => true,
            'header' => [
                'title' => 'ID',
                'sort' => true
            ],
            'cell' => [
                'display' => 'id',
                'link' => [
                    'route' => 'payments.edit',
                    'params' => [
                        'name' => 'payment',
                        'value' => 'id'
                    ],
                    'class' => 'link'
                ]
            ]
        ],
        'payments.client_id' => [],
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
        'payments.invoice_id' => [
            'search' => true,
            'header' => [
                'title' => 'Invoice #',
                'sort' => true
            ],
            'cell' => [
                'display' => 'invoice_id',
                'link' => [
                    'route' => 'invoices.edit',
                    'params' => [
                        'name' => 'invoice',
                        'value' => 'invoice_id'
                    ],
                    'class' => 'link'
                ]
            ]
        ],
        'payments.amount' => [
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
    ];
}

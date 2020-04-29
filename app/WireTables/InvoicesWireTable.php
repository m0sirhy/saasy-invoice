<?php

namespace App\WireTables;

class InvoicesWireTable extends WireTable
{
    public $model = "App\Invoice";

    public $title = "Invoices";

    public $create = "invoices.create";

    public $joins = [
        ['clients', 'invoices.client_id', 'clients.id'],
        ['invoice_statuses', 'invoices.invoice_status_id', 'invoice_statuses.id'],
    ];

    public $table = [
        'invoices.id' => [
            'search' => true,
            'header' => [
                'title' => '#',
                'sort' => true
            ],
            'cell' => [
                'display' => 'id',
                'link' => [
                    'route' => 'invoices.edit',
                    'params' => [
                        'name' => 'invoice',
                        'value' => 'id'
                    ],
                    'class' => 'link'
                ]
            ]
        ],
        'invoices.client_id' => [],
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
        'invoice_statuses.status' => [
            'search' => true,
            'header' => [
                'title' => 'Status',
                'sort' => true
            ],
            'cell' => [
                'display' => 'status',
            ],
        ],
        'invoices.balance' => [
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
        'invoices.invoice_date' => [
            'search' => true,
            'header' => [
                'title' => 'Invoice Date',
                'sort' => true
            ],
            'cell' => [
                'display' => 'invoice_date',
            ],
            'carbon' => true
        ],
    ];
}

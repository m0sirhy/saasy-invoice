@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@include('includes.dashboard-chart-json')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Dashboard</h3>
</div>
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <a href={{route('payments')}}>
                        <div class="bg-green-100 border-b-4 border-green-600 rounded-lg shadow-lg p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-green-600"><i class="fa fa-wallet fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h5 class="font-bold uppercase text-gray-600">Total Revenue</h5>
                                    <h3 class="font-bold text-3xl">${{ number_format($revenue) }}</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--/Metric Card-->
                </div>
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <a href={{route('clients')}}>
                        <div class="bg-orange-100 border-b-4 border-orange-500 rounded-lg shadow-lg p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-orange-600"><i class="fas fa-users fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h5 class="font-bold uppercase text-gray-600">Total Clients</h5>
                                    <h3 class="font-bold text-3xl">{{ number_format($clients) }}</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--/Metric Card-->
                </div>
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <a href={{route('clients')}}>
                        <div class="bg-yellow-100 border-b-4 border-yellow-600 rounded-lg shadow-lg p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-yellow-600"><i class="fas fa-user-plus fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h5 class="font-bold uppercase text-gray-600">New Clients</h5>
                                    <h3 class="font-bold text-3xl">{{ number_format($newClients) }}</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--/Metric Card-->
                </div>
            </div>


            <div class="flex flex-row flex-wrap flex-grow mt-2">
                <div class="w-1/12">
                </div>
                <div class="w-full content-center  md:w-5/6 p-3">
                    <!--Graph Card-->
                    <div class="bg-white border-transparent rounded-lg shadow-lg">
                        <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                            <h5 class="font-bold uppercase text-gray-600">Payments</h5>
                        </div>
                        <div class="p-5">
                            <canvas id="chartjs-0" class="chartjs" width="undefined" height="192px"></canvas>
                            <script>
                                new Chart(document.getElementById("chartjs-0"), {
                                    "type": "line",
                                    "data": {
                                        "labels": Object.values($paymentMonths),
                                        "datasets": [
                                        {
                                            "label": "Payments",
                                            "data": Object.values($paymentByMonth),
                                            "fill": false,
                                            "borderColor": "rgb(75, 192, 192)",
                                            "lineTension": 0.3
                                        }]
                                    },
                                    "options": {
                                        "legend" : {
                                            "display" : false,
                                        },
                                        "scales": {
                                            "yAxes": [{
                                                "ticks": {
                                                    "beginAtZero": true
                                                }
                                            }]
                                        },
                                        "maintainAspectRatio" : false,
                                    },
                                });
                            </script>
                        </div>
                    </div>
                    <!--/Graph Card-->
                </div>

                
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <div class="bg-white border-transparent rounded-lg shadow-lg">
                        <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                            <h5 class="font-bold uppercase text-gray-600">User Activity</h5>
                        </div>
                     <div class="p-2">
                            <div class="px-1">
                                <table class="w-full table-fixed">
                                    <thead class="flex w-full">
                                        <tr class="flex w-full">
                                            <th class="w-1/3 p-2">Date</th>
                                            <th class="w-1/3 py-2">
                                                Action
                                            </th>
                                            <th class="w-1/3 py-2">Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border flex flex-col w-full items-center justify-between overflow-y-scroll" style="height:25vh;">
                                        @foreach($userActivities as $userActivity)
                                            <tr class= "flex w-full border text-left border py-2">
                                                <td class="w-5/12 px-2">
                                                    <b>{{ $userActivity->created_at->format('m/d/y') }}</b>
                                                </td>
                                                <td class="w-1/2 text-left">
                                                     <a class="text-blue-500" href={{route('clients.show', ['client' => $userActivity->client->id])}} ><b>{{$userActivity->client->name}}</b></a>  {{ $userActivity->message }}
                                                </td>
                                                <td class="w-1/6">
                                                    <div class="text-right pr-2">
                                                    <a class="text-blue-500" href={{ route("invoices.edit", ["invoice" => $userActivity->invoice_id] )}} ><b>#{{ $userActivity->invoice_id }}</b></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                        <div class="bg-white border-transparent rounded-lg shadow-lg">
                            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                                <h5 class="font-bold uppercase text-gray-600">Recent Payments</h5>
                            </div>
                            <div class="p-2">
                                <div class="px-1">
                                    <table class="w-full table-fixed">
                                        <thead class="flex w-full">
                                            <tr class="flex w-full">
                                                <th class="w-1/3 p-2">Date</th>
                                                <th class="w-1/2 p-2">
                                                    Client
                                                </th>
                                                <th class="w-1/3 py-2">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border flex flex-col w-full items-center justify-between overflow-y-scroll" style="height:25vh;">
                                            @foreach($recents as $recent)
                                                <tr class= "flex w-full border py-2">
                                                    <td class="w-1/3 pl-2 px-2">
                                                    <b>{{ $recent->payment_at->format('m/d/y') }}</b>
                                                    </td>
                                                    <td class="w-1/2 px-2">
                                                        <a class="text-blue-500" href=@if(isset($recent->client->id)){{route('clients.show', ['client' => $recent->client->id])}}@endif ><b>{{$recent->client->name ?? 'Credit Card'}}</b></a> payed:
                                                    </td>
                                                    <td class="w-1/3 pr-3 text-right">
                                                        <a class="text-blue-500" href={{ route('payments.edit', ['payment' => $recent->id]) }}><b>${{ number_format($recent->amount, 2) }}</b></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <div class="w-full bg-white border-transparent rounded-lg shadow-lg">
                        <div class="flex bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                            <div class="w-1/2 font-bold uppercase text-gray-600">Overdue Invoices</div>
                            <div class="w-1/2 font-bold uppercase text-gray-600 text-right">Total: ${{ number_format($overdueTotal, 2) }}</div>
                        </div>
                        <div class="p-2">
                            <div class="px-1">
                                <table class="w-full table-fixed">
                                    <thead class="flex flex-col w-full">
                                        <tr class="flex w-full">
                                            <th class="w-1/3 p-2">Date</th>
                                            <th class="w-1/3 p-2">
                                                Client
                                            </th>
                                            <th class="w-1/3 p-2">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border flex flex-col items-center justify-between w-full overflow-y-scroll" style="height:25vh;">
                                        @foreach($overdues as $overdue)
                                            <tr class= "flex w-full border py-2">
                                                <td class="w-1/3 pl-2">
                                                <b>{{ $overdue->due_date->format('m/d/y') }}</b>
                                                </td>
                                                <td class="w-1/3">
                                                    <a class="text-blue-500" href={{route('clients.show', ['client' => $overdue->client->id])}} ><b>{{$overdue->client->name}}</b></a> 
                                                </td>
                                                <td class="w-1/3 text-right pr-2">
                                                    <a class="text-blue-500" href={{ route('invoices.edit', ['invoice' => $overdue->id]) }}><b>${{ number_format($overdue->balance, 2) }}</b></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
@endsection

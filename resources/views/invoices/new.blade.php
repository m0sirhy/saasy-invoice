@extends('layouts.app')

@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('invoices') }}">Invoices</a> / New Invoice</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Invoice Details</h5>
            </div>
            <invoice-form></invoice-form>
            <div class="p-5">
                <div class="w-full max-w-xl items-center">
                    {!! Form::model(null, ['route' => ['invoices.store']]) !!}
                        <div class="mb-4">
                            {!! Form::label('client_id', 'Client', ['class' => 'form-label'])  !!}
                            {!! Form::select('client_id', $clients, null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                            <p class="text-right"><a class="text-blue-700" href="{{ route('clients.create') }}">Create Client</a></p>
                        </div>
                        <div class="mb-4">
                            {!! Form::label('invoice_date', 'Invoice Date', ['class' => 'form-label'])  !!}
                            {!! Form::date('invoice_date', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('due_date', 'Due Date', ['class' => 'form-label'])  !!}
                            {!! Form::date('due_date', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::submit('Save', ['class' => 'bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
                <div>
                    <table class="table-auto w-full">
                      <thead class="bg-orange-500 text-white">
                        <tr>
                          <th class="px-4 py-2">Product</th>
                          <th class="px-4 py-2">Description</th>
                          <th class="px-4 py-2">Unit Price</th>
                          <th class="px-4 py-2">Quantity</th>
                          <th class="px-4 py-2 border-l-2 border-white bg-white"></th>
                          <th class="px-4 py-2 border-l-2 border-white">Line Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="item">
                            <input type="string" name="lineItemId" class="lineItemId form-input leading-tight focus:outline-none focus:shadow-outline">
                            <td class="products">
                                {!! Form::select(
                                    'lineitem[product][]',
                                    $products,
                                    null,
                                    [
                                        'class' => 'nameSelect select2 form-input leading-tight focus:outline-none focus:shadow-outline',
                                        'style' => 'width:100%',
                                        'attr' => 0
                                    ]
                                )!!}
                            </td>
                            <td class="description">
                                {!! Form::text(
                                    'lineitem[description][]',
                                    null,
                                    ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline description']
                                ) !!}
                            </td>
                            <td class="unitPrice">
                                {!! Form::text(
                                    'lineitem[unit_price][]',
                                    0,
                                    ['class' => 'change form-input leading-tight focus:outline-none focus:shadow-outline price', 'size' => 3]
                                ) !!}
                            </td>
                            <td class="quantity">
                                {!! Form::text(
                                    'lineitem[quantity][]',
                                    0,
                                    ['class' => 'change form-input leading-tight focus:outline-none focus:shadow-outline qty', 'size' => 3]
                                ) !!}
                            </td>
                            <td class="text-center"><a class="remove"><i class="fa fa-times text-red-700"></i></a></td>
                            <td class="text-right price">$<span class="totalPrice">0.00</span></td>
                        </tr>
                      </tbody>
                    </table>
                    <a class="addRow"><i class="fa fa-plus pr-1 text-green-500"></i>Add Row</a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('footerScripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.addRow').click(function(){
        var $row = $('.item:last');
        var $newRow = $row.clone();
        // $newRow.find('.item > td:last > td.products > input.lineItemID').val();
        // $newRow.find('.item > td:last > td.products > input.description').val("poppers");
        $newRow.find('td.unitPrice > input.price').val(5);
        $newRow.find('td.quantity > input.qty').val(5);
        $newRow.find('td.description > input.description').val(5);
        $newRow.find('td.unitPrice > input.price').val(5);
        
        // $newRow.find('.item > td:last > td.products > input.price').val(0);
        $newRow.insertAfter($row);
        console.log($newRow.find('td.unitPrice > input').val());
    });
    $('.remove').click(function(){
        console.log('working?');
        $(this).parent().parent().empty();
        var amountDue = 0;
        $('.totalPrice').each(function(i, obj) {
            console.log($(this))
            amountDue += parseFloat($(this).text());
            console.log(amountDue)
        });
        $('#dueAmount').text(amountDue.toFixed(2))
        $('#balanceDue').text(amountDue.toFixed(2))
    });
    $('.change').change(function(){
        var qty = $($(this).parent().parent().children('.quantity').children('input')).val()
        var unitPrice = $($(this).parent().parent().children('.unitPrice').children('input')).val()
        var total = $($(this).parent().parent().children('.price').children('span'))
        var totalPrice = unitPrice * qty;
        total.text(totalPrice.toFixed(2))
        var amountDue = 0;
        $('.totalPrice').each(function(i, obj) {
            amountDue += parseFloat($(this).text());
        });
        console.log(amountDue);
        $('#dueAmount').text(amountDue.toFixed(2))
        $('#blanceDueText').val(amountDue.toFixed(2))
    });
    
    $('.nameSelect').change(function(){
        var url = '/admin/accounting/products/' + $(this).val();
        var unitPrice = $($(this).parent().parent().children('.unitPrice').children('input'))
        var qty = $($(this).parent().parent().children('.quantity').children('input'))
        $.get(url, 
        function(data) {
            unitPrice.val(data.unit_price.toFixed(2))
            if (qty.val() == '0') {
                qty.val(1)
            }
            qty.trigger('change')
        });
    });
});
</script>
@endpush
@endsection

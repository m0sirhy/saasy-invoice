@if ( !is_null($paymentByMonth) && !is_null($paymentMonths))
	<script>
		var $paymentByMonth = {!! json_encode($paymentByMonth) !!};
		var $paymentMonths = {!! json_encode($paymentMonths) !!};
	</script>
@endif
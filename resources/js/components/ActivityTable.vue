<template language="php">
	<div>
		<div class="px-5">
			<ul class="list-disc overflow-auto h-40">
				<div v-for="message in messages">
					<li><b>{{message.date}}</b>: {{message.user_name}} {{message.message}} <a v-bind:href="message.invoiceUrl" class="text-blue-500"><b>#{{message.invoice}}</b></a></li>
				</div>
			</ul>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				messages:[
					
				]
			}
		},
		computed: {
			
		},
		methods: {

		},
		mounted: function() {
			var self = this;
			axios.get('/activity/show/')
			.then(function(response) {
				$.each(response.data, function(key, data) {
					console.log(data.created_at);
					self.messages.push(
						{
							date: data.created_at,
							user_name: data.name,
							message: data.message,
							invoiceUrl: '/invoices/edit/' + data.invoice_id.toString(),
							invoice: data.invoice_id
						}
					)
				});
			});
		}
	}
</script>
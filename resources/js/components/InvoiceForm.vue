<template>
    <div>
        <div class="p-5">
            <div class="w-full max-w-xl items-center">
            <form>
                <div class="mb-4">
                    <label class="form-label">Client</label>
                    <v-select :options="[{label: 'Canada', code: 'ca'}]"></v-select>
                    <p class="text-right"><a class="text-blue-700" href="">Create Client</a></p>
                </div>
                <div class="mb-4">
                    //invoice date field
                </div>
                <div class="mb-4">
                    // due date field
                </div>
            </form>
        </div>
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
                 <tr class="item" v-for="(item, index) in items">
                  <td><v-select v-model="selected" :options="products"></v-select></td>
                  <td><input class="form-input leading-tight focus:outline-none focus:shadow-outline" v-model="item.description" />{{ selected }}</td>
                  <td><input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="number" v-model="item.price" /></td>
                  <td><input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="number" v-model="item.quantity" /></td>
                  <td class="text-center"><a @click="removeRow(index)"><i class="fa fa-times text-red-700"></i></a></td>
                  <td>${{ item.price * item.quantity | currency }}</td>
                </tr>

                <tr>
                  <td colspan="4">
                    <button class="btn-add-row" @click="addRow">Add row</button>
                  </td>
                </tr>

                <tr class="total">
                  <td colspan="3"></td>
                  <td>Total: ${{ total | currency }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
import 'vue-select/dist/vue-select.css';
    export default {
        data() {
            return {
                items: [
                  { description: "", quantity: 0, price: 0 }
                ],
                products: [{label: '', id: null}],
                clients: [{label: '', id: null}],
                selected: null,
                productData: null
            }
          },
          computed: {
            total() {
              return this.items.reduce(
                (acc, item) => acc + item.price * item.quantity,
                0
              );
            }
          },
          methods: {
            addRow() {
              this.items.push({ description: "Hi Baby", quantity: 1, price: 0 });
            },
            removeRow(index) {
              this.items.splice(index, 1);
            }
          },
          filters: {
            currency(value) {
              return value.toFixed(2);
            }
          },
          mounted: function () {
            var self = this;
            var productData = [];
            axios
              .get('/api/products')
              .then(function(response) {
                productData.push(response.data);
                $.each(response.data, function(key, data)  {
                  self.products.push({label: data.name, id: data.id})
                })
              });
            axios
              .get('/api/clients')
              .then(function(response) {
                $.each(response.data, function(key, data)  {
                  self.clients.push({label: data.name, id: data.id})
                })
              });
          },
          // computed: {
          //   populate: {
          //     get: function() {

          //       return //
          //     }
          //   }
          // }
    }
</script>
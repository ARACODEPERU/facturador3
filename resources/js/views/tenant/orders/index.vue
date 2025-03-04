<template>
  <div>
    <div class="page-header pr-0">
      <h2>
        <a href="/dashboard">
          <i class="fas fa-tachometer-alt"></i>
        </a>
      </h2>
      <ol class="breadcrumbs">
        <li class="active">
          <span>Pedidos</span>
        </li>
      </ol>
      <div class="right-wrapper pull-right"></div>
    </div>
    <div class="card mb-0">
      <div class="card-header bg-info">
        <h3 class="my-0">Listado de Pedidos Tienda Virtual</h3>
      </div>
      <div class="card-body">
        <data-table :resource="resource">
          <tr slot="heading" width="100%">
            <th>#</th>
            <th>Codigo de Pedido</th>
            <th>Cliente</th>
            <th class="text-center">Detalle Productos</th>
            <th>Total</th>
            <th>Fecha Emision</th>
            <th>Medio Pago</th>
            <th>Estatus del Pedido</th>
            <th>Comprobante Electronico</th>
          </tr>
          <tr></tr>
          <tr slot-scope="{ index, row }">
            <td>{{ index }}</td>
            <td>{{ row.order_id }}</td>
            <td>{{ row.customer }}</td>
            <td class="text-center">
              <template>
                <el-popover placement="right" width="540" trigger="click">
                  <el-table  style="width: 100%" :data="row.items">
                    <el-table-column width="150" property="name" label="Nombre"></el-table-column>
                    <el-table-column width="90" property="cantidad" label="Cant."></el-table-column>
                    <el-table-column width="90" label="Precio">
                      <template slot-scope="scope">
                        <span>{{ (scope.row.currency_type_id === 'USD') ? '$' : 'S/' }} {{ Number( scope.row.sale_unit_price).toFixed(2)}}</span>
                      </template>
                    </el-table-column>
                    <el-table-column width="90" property="exchange_rate_sale" label="T/C"></el-table-column>
                    <el-table-column width="90" label="Subtotal">
                      <template slot-scope="scope">
                        <span>S/ {{ subtotal(scope.row) }}</span>
                      </template>
                    </el-table-column>
                  </el-table>
                  <table class="el-table--small el-table--fit el-table">
                    <thead class="has-gutter">
                      <th colspan="2" class="text-center">Contacto</th>
                    </thead>
                    <tbody>
                      <tr class="el-table tr"><td class="el-table--small td">TELÉFONO: {{ row.customer_telefono }}</td></tr>
                      <tr class="el-table tr"><td class="el-table--small td">DIRECCIÓN: {{ row.customer_direccion }}</td></tr>
                    </tbody>
                  </table>
                  <el-button slot="reference" icon="el-icon-zoom-in"></el-button>
                </el-popover>
              </template>
            </td>
            <td>S/ {{row.total}}</td>
            <td>{{row.created_at}}</td>
            <td>{{row.reference_payment}}</td>
            <td>
              <el-select v-model="row.status_order_id" placeholder="Estatus Pedido" :value="row.status_order_id" @change="updateStatus(row)">
                <el-option
                  v-for="item in options"
                  :key="item.id"
                  :label="item.description"
                  :value="item.id">
                </el-option>
              </el-select>
            </td>
            <td>{{row.number_document}}</td>
          </tr>
        </data-table>
      </div>
    </div>

    <el-dialog title="Stock en almacén" width="40%" :visible="showDialog" :close-on-click-modal="false" :close-on-press-escape="false" append-to-body :show-close="false">
      <div class="form-body">
        <div class="row">
          <div class="col-lg-12 col-md-12 table-responsive">
            <table width="100%" class="table">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th class="text-center">Almacén</th>
                </tr>
              </thead>
              <tbody v-for="(rowProduct, indexProduct) in totalProduct" :key="indexProduct" width="100%">

                <tr>
                  <td>{{ record.items[indexProduct].name }}</td>
                  <td>
                    <el-select v-model="form[rowProduct]" placeholder="Almacenes" @change="stock">
                      <el-option v-if="rowProduct === item.item_id"
                        v-for="item in warehouses"
                        :key="item.id"
                        :label="item.warehouse + ' - ' + 'Stock -> ' + Math.trunc(item.stock)"
                        :value="item.id"
                        :disabled="optionDisable(item.item_id, item.stock)">
                      </el-option>
                    </el-select>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="form-actions text-right pt-2">
        <el-button @click="close">Cerrar</el-button>
        <el-button type="primary" @click="save">Guardar</el-button>
      </div>
    </el-dialog>

  </div>
</template>
<script>
import DataTable from "../../../components/DataTable.vue";

export default {
  props: [],

  components: { DataTable },
  data() {
    return {
      showDialog: false,
      showImportDialog: false,
      showImageDetail: false,
      resource: "orders",
      recordId: null,
      options: [],
      warehouses: [],
      estableciment_id: '',
      totalProduct: [], // items_id
      showDialog: false,
      form: [],
      record: '', // record orders
      stocks: ''
    };
  },
  async created() {
    await this.$http.get(`/statusOrder/records`).then(response => {
      this.options = response.data
    })
  },
  computed: {},
  methods: {
    subtotal(item) {
      var subtotal
      if(item.currency_type_id === 'USD') {
        subtotal = Number(item.cantidad * item.exchange_rate_sale * parseFloat(item.sale_unit_price)).toFixed(2)
        if(isNaN(subtotal)){
          return '-'
        } else {
          return subtotal
        }
      } else {
        return parseFloat(item.cantidad * item.sale_unit_price)
      }
    },
    optionDisable(product, stock) {
      for (var i = 0; i < this.record.items.length; i++) {
        if (product === this.record.items[i].id) {
          return (stock >= this.record.items[i].cantidad) ? false : true
        }
      }
    },
    stock(selected) {
      for (let i = 0; i < this.warehouses.length; i++) {
        if(this.warehouses[i].id === selected) {
          //this.stock = this.warehouses[i].stock
        }
      }
    },
    async updateStatus(record) {
      console.log(record)
      this.record = record
      if (record.status_order_id === 3) {
        this.totalProduct = await this.products(record)
        await this.$http.post(`/orders/warehouse`, {item_id: this.totalProduct}).then(response => {
          this.warehouses = response.data.data
          this.showDialog = true
        })
        return
      }

      await this.$http.post(`/statusOrder/update`, {record: record}).then(response => {
        this.$message.success(response.data.message)
      })
    },
    async save () {
      var save = []

      for (var i = 0; i < this.record.items.length; i++) {
        if (this.totalProduct[i] === this.record.items[i].id) {
          save.push({
            'id': this.form[this.totalProduct[i]],
            'cantidad': this.record.items[i].cantidad
          })
        }
      }

      await this.$http.post(`/statusOrder/update`, {record: this.record, discount: save}).then(response => {
        this.$message.success(response.data.message)
        this.close()
      })
    },
    close () {
      this.form = []
      this.showDialog = false
      this.recoard = ''
    },
    products (products) {
      let listProduct = []

      for (var i = 0; i <= products.items.length-1; i++) {
        listProduct.push(products.items[i].id)
      }
      return listProduct
    }
  }
};
</script>

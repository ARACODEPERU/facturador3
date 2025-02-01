<template>
  <div>
    <div class="row">
      <div class="col-md-12 col-lg-12 col-xl-12">
          <div class="row">
              <div class="col-lg-8 col-md-8 mb-2">
                  <div class="form-group">
                      <label class="control-label font-custom"><strong>Filtros de busqueda</strong></label>
                  </div>
              </div>
          </div>
        <div class="row">
            <!--
          <div class="col-lg-4 col-md-4 col-sm-12 pb-2">
            <div class="d-flex">
              <div style="width:100px">Filtrar por:</div>
              <el-select v-model="search.column" placeholder="Select" @change="changeClearInput">
                <el-option v-for="(label, key) in columns" :key="key" :value="key" :label="label"></el-option>
              </el-select>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-12 pb-2">
            <template
              v-if="search.column=='created_at'"
            >
              <el-date-picker
                v-model="search.value"
                type="date"
                style="width: 100%;"
                placeholder="Buscar"
                value-format="yyyy-MM-dd"
                @change="getRecords"
              ></el-date-picker>
            </template>
          </div>
            -->
            <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                <label class="control-label">Fecha de emisión</label>
                <el-date-picker
                    v-model="search.value"
                    type="date"
                    style="width: 100%;"
                    placeholder="Buscar"
                    value-format="yyyy-MM-dd"
                    @change="changeDateOfIssue">
                </el-date-picker>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label class="control-label">Producto</label>
                    <el-select v-model="search.item_id" filterable remote  popper-class="el-select-customers"  clearable
                               placeholder="Nombre o código interno"
                               :remote-method="searchRemoteItems"
                               :loading="loading_search_item">
                        <el-option v-for="option in items" :key="option.id" :value="option.id" :label="option.description"></el-option>
                    </el-select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-md-4 col-sm-12" style="margin-top:29px">
                <el-button class="submit" type="primary" @click.prevent="getRecordsByFilter" :loading="loading_submit" icon="el-icon-search" >Buscar</el-button>
                <el-button class="submit" type="info" @click.prevent="cleanInputs"  icon="el-icon-delete" >Limpiar </el-button>

            </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <slot name="heading"></slot>
            </thead>
            <tbody>
              <slot v-for="(row, index) in records" :row="row" :index="customIndex(index)"></slot>
            </tbody>
          </table>
          <div>
            <el-pagination
              @current-change="getRecords"
              layout="total, prev, pager, next"
              :total="pagination.total"
              :current-page.sync="pagination.current_page"
              :page-size="pagination.per_page"
            ></el-pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import moment from "moment";
import queryString from "query-string";

export default {
  props: {
    resource: String
  },
  data() {
    return {
        loading_submit:false,
      search: {
        column: null,
        value: null
      },
      columns: [],
      records: [],
        loading_search_item:false,
        items: [],
      pagination: {}
    };
  },
  computed: {},
  created() {
    this.$eventHub.$on("reloadData", () => {
      this.getRecords();
    });
  },
  async mounted() {
    let column_resource = _.split(this.resource, "/");
    // console.log(column_resource)
    await this.$http
      .get(`/${_.head(column_resource)}/columns`)
      .then(response => {
        this.columns = response.data;
        this.search.column = _.head(Object.keys(this.columns));
      });
    await this.getRecords();
      setTimeout(function(){
          $('div.el-popover').css('max-height', '80%');
          $('div.el-popover').css('overflow', 'scroll');
          $('div.el-popover').css('overflow-x', 'hidden');
      }, 4000);
      $('span.el-popover__reference-wrapper > button.el-button.el-button--default.el-popover__reference').click(function(){
          $('div.el-popover').css('max-height', '80%');
          $('div.el-popover').css('overflow', 'scroll');
          $('div.el-popover').css('overflow-x', 'hidden');
      });
  },
  methods: {
      searchRemoteItems(input) {

          if (input.length > 0) {

              this.loading_search = true
              let parameters = `input=${input}`

              this.$http.get(`/documents/data-table/items?${parameters}`)
                  .then(response => {
                      // console.log(response.data)
                      this.items = response.data
                      this.loading_search = false

                      if(this.items.length == 0){
                          this.filterItems()
                      }
                  })
          } else {
              this.filterItems()
          }

      },
      filterItems() {
          this.items = this.all_items
      },
      changeDateOfIssue(){
          this.search.d_start = null
          this.search.d_end = null
      },
      initForm(){
          this.search = {
              item_id:null,
              value: null
          }
      },
      cleanInputs(){
          this.initForm()
      },
    customIndex(index) {
      return (
        this.pagination.per_page * (this.pagination.current_page - 1) +
        index +
        1
      );
    },
      getQueryParameters() {
          return queryString.stringify({
              page: this.pagination.current_page,
              limit: this.limit,
              ...this.search
          })
      },
    getRecords() {
      return this.$http
        .get(`/${this.resource}/records?${this.getQueryParameters()}`)
        .then(response => {
          this.records = response.data.data;
          this.pagination = response.data.meta;
          this.pagination.per_page = parseInt(response.data.meta.per_page);
        });
    },
      async getRecordsByFilter(){
          this.loading_submit = await true
          await this.getRecords()
          this.loading_submit = await false

      },
    changeClearInput() {
      this.search.value = "";
      this.getRecords();
    }
  }
};
</script>

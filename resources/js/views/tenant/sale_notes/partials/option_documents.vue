<template>
    <div>
        <el-dialog :title="titleDialog" :visible="showDialog" @open="create" width="30%"
                :close-on-click-modal="false"
                :close-on-press-escape="false"
                :show-close="false">
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group" :class="{'has-danger': errors.document_type_id}">
                        <label class="control-label">Tipo comprobante</label>
                        <el-select v-model="document.document_type_id" @change="changeDocumentType" popper-class="el-select-document_type" dusk="document_type_id" class="border-left rounded-left border-info">
                            <el-option v-for="option in document_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.document_type_id" v-text="errors.document_type_id[0]"></small>
                        <!-- <el-checkbox  v-model="generate_dispatch">Generar Guía Remisión</el-checkbox> -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group" :class="{'has-danger': errors.series_id}">
                        <label class="control-label">Serie</label>
                        <el-select v-model="document.series_id">
                            <el-option v-for="option in series" :key="option.id" :value="option.id" :label="option.number"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.series_id" v-text="errors.series_id[0]"></small>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Observaciones</label>
                        <el-input
                                type="textarea"
                                autosize
                                v-model="document.additional_information">
                        </el-input>
                    </div>
                </div>
                <div class="col-lg-8 mt-3">
                    <div class="form-group" :class="{'has-danger': errors.dipatch_id}">
                        <!-- <label class="control-label">Tipo comprobante</label> -->
                        <el-checkbox  v-model="generate_dispatch">Generar Guía Remisión</el-checkbox>
                        <el-select v-model="dispatch_id" popper-class="el-select-document_type" filterable  class="border-left rounded-left border-info" v-if="generate_dispatch">
                            <el-option v-for="option in dispatches" :key="option.id" :value="option.id" :label="option.number_full"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.dipatch_id" v-text="errors.dipatch_id[0]"></small>
                    </div>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="clickClose">Cerrar</el-button>
                <el-button class="submit" type="primary" @click="submit" :loading="loading_submit" v-if="flag_generate">Generar</el-button>
            </span>

            <document-options :showDialog.sync="showDialogDocumentOptions"
                              :recordId="documentNewId"
                              :generatDispatch="generate_dispatch"
                              :dispatchId="dispatch_id"
                              :isContingency="false"
                              :showClose="true"></document-options>

        </el-dialog>
    </div>
</template>

<script>

    import DocumentOptions from '../../documents/partials/options.vue'

    export default {
        components: {DocumentOptions},

        props: ['showDialog', 'recordId', 'showClose','showGenerate'],
        data() {
            return {
                titleDialog: null,
                loading: false,
                resource: 'sale-notes',
                resource_documents: 'documents',
                errors: {},
                form: {},
                document:{},
                document_types: [],
                all_document_types: [],
                all_series: [],
                series: [],
                generate:false,
                loading_submit:false,
                showDialogDocumentOptions: false,
                documentNewId: null,
                flag_generate:true,
                dispatches: [],
                generate_dispatch:false,
                dispatch_id:null
            }
        },
        created() {
            this.initForm()
            this.initDocument()

           // console.log(moment().format('YYYY-MM-DD'))
        },
        methods: {
            initForm() {
                this.generate = (this.showGenerate) ? true:false
                this.errors = {}
                this.form = {
                    id: null,
                    external_id: null,
                    identifier: null,
                    date_of_issue:null,
                    sale_note:null,
                }
                this.generate_dispatch = false
            },
            initDocument(){
                this.document = {
                    document_type_id:null,
                    series_id:null,
                    establishment_id: null,
                    number: '#',
                    date_of_issue: null,
                    time_of_issue: null,
                    customer_id: null,
                    currency_type_id: null,
                    purchase_order: null,
                    exchange_rate_sale: 0.01,
                    total_prepayment: 0,
                    total_charge: 0,
                    total_discount: 0,
                    total_exportation: 0,
                    total_free: 0,
                    total_taxed: 0,
                    total_unaffected: 0,
                    total_exonerated: 0,
                    total_igv: 0,
                    total_base_isc: 0,
                    total_isc: 0,
                    total_base_other_taxes: 0,
                    total_other_taxes: 0,
                    total_taxes: 0,
                    total_value: 0,
                    total: 0,
                    operation_type_id: null,
                    date_of_due: null,
                    items: [],
                    charges: [],
                    discounts: [],
                    attributes: [],
                    guides: [],
                    additional_information:null,
                    actions: {
                        format_pdf:'a4',
                    },
                    quotation_id:null,
                    sale_note_id:null,
                    payments: [],
                    hotel: {},
                }
            },
            resetDocument(){
                this.generate = (this.showGenerate) ? true:false
                this.initDocument()
                this.document.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null
                this.changeDocumentType()
            },
            async submit() {

                if(this.generate_dispatch){
                    if(!this.dispatch_id){
                        return this.$message.error('Debe seleccionar una guía base')
                    }
                }
                this.loading_submit = true;

                this.document.exchange_rate_sale = 1;

                await this.$http.post(`/${this.resource_documents}`, this.document).then(response => {
                        if (response.data.success) {
                            this.documentNewId = response.data.data.id;
                            this.showDialogDocumentOptions = true;
                            this.$http.get(`/${this.resource}/changed/${this.form.id}`).then(() => {
                                this.$eventHub.$emit('reloadData');
                                this.flag_generate = false
                            });
                            this.resetDocument()

                            // this.clickClose();
                        } else {
                            this.$message.error(response.data.message);
                        }
                    }).catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data;
                        }
                        else {
                            this.$message.error(error.response.data.message);
                        }
                    }).then(() => {
                        this.loading_submit = false;
                    });
            },
            assignDocument(){
                let q = this.form.sale_note;
                // console.log(q);

                this.document.establishment_id = q.establishment_id
                this.document.date_of_issue =  moment().format('YYYY-MM-DD')//q.date_of_issue
                this.document.date_of_due = moment().format('YYYY-MM-DD') //q.date_of_issue
                this.document.time_of_issue = q.time_of_issue
                this.document.customer_id = q.customer_id
                this.document.currency_type_id = q.currency_type_id
                this.document.purchase_order = null
                this.document.exchange_rate_sale = q.exchange_rate_sale
                this.document.total_prepayment = q.total_prepayment
                this.document.total_charge = q.total_charge
                this.document.total_discount = q.total_discount
                this.document.total_exportation = q.total_exportation
                this.document.total_free = q.total_free
                this.document.total_taxed = q.total_taxed
                this.document.total_unaffected = q.total_unaffected
                this.document.total_exonerated = q.total_exonerated
                this.document.total_igv = q.total_igv
                this.document.total_base_isc = q.total_base_isc
                this.document.total_isc = q.total_isc
                this.document.total_base_other_taxes = q.total_base_other_taxes
                this.document.total_other_taxes = q.total_other_taxes
                this.document.total_taxes = q.total_taxes
                this.document.total_value = q.total_value
                this.document.total = q.total
                this.document.operation_type_id = '0101'

                this.document.items = q.items
                this.document.charges = q.charges
                this.document.discounts = q.discounts
                this.document.attributes = []
                this.document.guides = q.guides;
                this.document.additional_information =null;
                this.document.actions = {
                    format_pdf : 'a4'
                };
                this.document.sale_note_id = this.form.id;
                this.document.payments = q.payments;
                //console.log(this.document);
            },
            async create() {

                await this.$http.get(`/${this.resource}/option/tables`).then(response => {
                    this.all_document_types = response.data.document_types_invoice;
                    this.all_series = response.data.series;
                    // this.document.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null;
                    // this.changeDocumentType();
                });

                await this.$http.get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data
                        this.validateIdentityDocumentType()

                        this.assignDocument();
                        this.titleDialog = 'Nota de venta registrada: '+this.form.identifier
                    })


                await this.$http.get(`/${this.resource}/dispatches`)
                    .then(response => {
                        this.dispatches = response.data
                    })
            },
            changeDocumentType() {
                this.filterSeries();
            },
            async validateIdentityDocumentType(){

                let identity_document_types = ['0','1']


                if(identity_document_types.includes(this.form.sale_note.customer.identity_document_type_id)){

                    this.document_types = _.filter(this.all_document_types,{'id':'03'})

                }else{
                    this.document_types = this.all_document_types

                }

                this.document.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null
                await this.changeDocumentType()

            },
            filterSeries() {
                this.document.series_id = null
                this.series = _.filter(this.all_series, {'document_type_id': this.document.document_type_id})
                this.document.series_id = (this.series.length > 0)?this.series[0].id:null
            },
            clickFinalize() {
                location.href = `/${this.resource}`
            },
            clickNewQuotation() {
                this.clickClose()
            },
            clickClose() {
                this.$emit('update:showDialog', false)
                this.initForm()
                this.resetDocument()
                this.flag_generate = true
            },
            clickToPrint(){
                window.open(`/downloads/saleNote/sale_note/${this.form.external_id}`, '_blank');
            }
        }
    }
</script>

<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-info">
            <h3 class="my-0">Nueva Guía de Remisión</h3>
        </div>
        <div class="card-body">
            <form autocomplete="off" @submit.prevent="submit">
                <div class="form-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.establishment}">
                                <label class="control-label">Establecimiento<span class="text-danger"> *</span></label>
                                <el-select v-model="form.establishment_id" @change="changeEstablishment">
                                    <el-option v-for="option in establishments" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.establishment" v-text="errors.establishment[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.series}">
                                <label class="control-label">Serie<span class="text-danger"> *</span></label>
                                <el-select v-model="form.series_id">
                                    <el-option v-for="option in series" :key="option.id" :value="option.id" :label="option.number"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.series_id" v-text="errors.series_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.date_of_issue}">
                                <label class="control-label">Fecha de emisión<span class="text-danger"> *</span></label>
                                <el-date-picker v-model="form.date_of_issue" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_issue" v-text="errors.date_of_issue[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.date_of_shipping}">
                                <label class="control-label">Fecha de traslado<span class="text-danger"> *</span></label>
                                <el-date-picker v-model="form.date_of_shipping" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_shipping" v-text="errors.date_of_shipping[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors.customer_id}">
                                <label class="control-label">
                                    Cliente<span class="text-danger"> *</span>
                                    <a href="#" @click.prevent="showDialogNewPerson = true">[+ Nuevo]</a>
                                </label>
                                <el-select v-model="form.customer_id" filterable>
                                    <el-option v-for="option in customers" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.customer_id" v-text="errors.customer_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.transport_mode_type_id}">
                                <label class="control-label">Modo de translado<span class="text-danger"> *</span></label>
                                <el-select v-model="form.transport_mode_type_id">
                                    <el-option v-for="option in transportModeTypes" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.transport_mode_type_id" v-text="errors.transport_mode_type_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors.transfer_reason_type_id}">
                                <label class="control-label">Motivo de translado<span class="text-danger"> *</span></label>
                                <el-select v-model="form.transfer_reason_type_id">
                                    <el-option v-for="option in transferReasonTypes" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.transfer_reason_type_id" v-text="errors.transfer_reason_type_id[0]"></small>
                            </div>
                        </div>
                        <!-- <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.port_code}">
                                <label class="control-label">Codigo del Puerto</label>
                                <el-input v-model="form.port_code" maxlength="3"></el-input>
                                <small class="form-control-feedback" v-if="errors.port_code" v-text="errors.port_code[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.transshipment_indicator}">
                                <label class="control-label">Transbordo</label>
                                <div class="form-group">
                                    <el-radio v-model="form.transshipment_indicator" label="1">Si</el-radio>
                                    <el-radio v-model="form.transshipment_indicator" label="0">No</el-radio>
                                </div>
                                <small class="form-control-feedback" v-if="errors.transshipment_indicator" v-text="errors.transshipment_indicator[0]"></small>
                            </div>
                        </div> -->

                        <div class="col-lg-6">
                            <div class="form-group" :class="{'has-danger': errors.transfer_reason_description}">
                                <label class="control-label">Descripción de motivo de traslado<span class="text-danger"> *</span></label>
                                <el-input type="textarea" :rows="3" placeholder="Descripción de motivo de traslado..." v-model="form.transfer_reason_description" maxlength="100"></el-input>
                                <small class="form-control-feedback" v-if="errors.transfer_reason_description" v-text="errors.transfer_reason_description[0]"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.unit_type_id}">
                                <label class="control-label">Unidad de medida<span class="text-danger"> *</span></label>
                                <el-select v-model="form.unit_type_id">
                                    <el-option v-for="option in unitTypes" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.unit_type_id" v-text="errors.unit_type_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.total_weight}">
                                <label class="control-label">Peso total<span class="text-danger"> *</span></label>
                                <el-input-number v-model="form.total_weight" :precision="2" :step="1" :min="0" :max="9999999999"></el-input-number>
                                <small class="form-control-feedback" v-if="errors.total_weight" v-text="errors.total_weight[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.packages_number}">
                                <label class="control-label">Número de paquetes<span class="text-danger"> *</span></label>
                                <el-input-number v-model="form.packages_number" :precision="0" :step="1" :min="0" :max="9999999999"></el-input-number>
                                <small class="form-control-feedback" v-if="errors.packages_number" v-text="errors.packages_number[0]"></small>
                            </div>
                        </div>
                        <!-- <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.container_number}">
                                <label class="control-label">Número de contenedor</label>
                                <el-input-number v-model="form.container_number" :precision="0" :step="1" :min="0" :max="9999999999"></el-input-number>
                                <small class="form-control-feedback" v-if="errors.container_number" v-text="errors.container_number[0]"></small>
                            </div>
                        </div> -->
                        <div class="col-lg-6">
                            <div class="form-group" :class="{'has-danger': errors.observations}">
                                <label class="control-label">Observaciones<span class="text-danger"> *</span></label>
                                <el-input type="textarea" :rows="3" placeholder="Observaciones..." v-model="form.observations" maxlength="250"></el-input>
                                <small class="form-control-feedback" v-if="errors.observations" v-text="errors.observations[0]"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    </div>
                    <div class="row">
                    </div>
                    <hr>
                    <h4>Datos envío</h4>
                    <h6>Dirección partida</h6>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.origin}">
                                <label class="control-label">País<span class="text-danger"> *</span></label>
                                <el-select v-model="form.origin.country_id" filterable>
                                    <el-option v-for="option in countries" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.origin" v-text="errors.origin.country_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors.origin}">
                                <label class="control-label">Ubigeo<span class="text-danger"> *</span></label>
                                <el-cascader :options="locations" v-model="form.origin.location_id" filterable></el-cascader>
                                <!--<el-select v-model="form.delivery.department_id" filterable @change="filterProvince(false)">-->
                                <!--<el-option v-for="option in departments" :key="option.id" :value="option.id" :label="option.description"></el-option>-->
                                <!--</el-select>-->
                                <small class="form-control-feedback" v-if="errors.origin" v-text="errors.origin.location_id[0]"></small>
                            </div>
                        </div>
                        <!-- <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.origin}">
                                <label class="control-label">Provincia</label>
                                <el-select v-model="form.origin.province_id" filterable @change="filterDistrict">
                                    <el-option v-for="option in provincesOrigin" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.origin" v-text="errors.origin.province_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.origin}">
                                <label class="control-label">Distrito</label>
                                <el-select v-model="form.origin.location_id" filterable>
                                    <el-option v-for="option in districtsOrigin" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.origin" v-text="errors.origin.location_id[0]"></small>
                            </div>
                        </div> -->
                        <div class="col-lg-6">
                            <div class="form-group" :class="{'has-danger': errors['origin.address']}">
                                <label class="control-label">Dirección<span class="text-danger"> *</span></label>
                                <el-input v-model="form.origin.address" :maxlength="100" placeholder="Dirección..."></el-input>
                                <small class="form-control-feedback" v-if="errors['origin.address']" v-text="errors['origin.address'][0]"></small>
                            </div>
                        </div>
                    </div>
                    <h6>Dirección llegada</h6>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.delivery}">
                                <label class="control-label">País<span class="text-danger"> *</span></label>
                                <el-select v-model="form.delivery.country_id" filterable>
                                    <el-option v-for="option in countries" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.delivery" v-text="errors.delivery.country_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors.delivery}">
                                <label class="control-label">Ubigeo<span class="text-danger"> *</span></label>
                                <el-cascader :options="locations" v-model="form.delivery.location_id" filterable></el-cascader>
                                <!--<el-select v-model="form.delivery.department_id" filterable @change="filterProvince(false)">-->
                                    <!--<el-option v-for="option in departments" :key="option.id" :value="option.id" :label="option.description"></el-option>-->
                                <!--</el-select>-->
                                <small class="form-control-feedback" v-if="errors.delivery" v-text="errors.delivery.location_id[0]"></small>
                            </div>
                        </div>
                        <!-- <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.delivery}">
                                <label class="control-label">Provincia</label>
                                <el-select v-model="form.delivery.province_id" filterable @change="filterDistrict(false)">
                                    <el-option v-for="option in provincesDelivery" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.delivery" v-text="errors.delivery.province_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{'has-danger': errors.delivery}">
                                <label class="control-label">Distrito</label>
                                <el-select v-model="form.delivery.location_id" filterable>
                                    <el-option v-for="option in districtsDelivery" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.delivery" v-text="errors.delivery.location_id[0]"></small>
                            </div>
                        </div> -->
                        <div class="col-lg-6">
                            <div class="form-group" :class="{'has-danger': errors['delivery.address']}">
                                <label class="control-label">Dirección<span class="text-danger"> *</span></label>
                                <el-input v-model="form.delivery.address" :maxlength="100" placeholder="Dirección..."></el-input>
                                <small class="form-control-feedback" v-if="errors['delivery.address']" v-text="errors['delivery.address'][0]"></small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>Datos transportista</h4>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors['dispatcher.identity_document_type_id']}">
                                <label class="control-label">Tipo Doc. Identidad<span class="text-danger"> *</span></label>
                                <el-select v-model="form.dispatcher.identity_document_type_id" filterable>
                                    <el-option v-for="option in identityDocumentTypes" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors['dispatcher.identity_document_type_id']" v-text="errors['dispatcher.identity_document_type_id'][0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors['dispatcher.number']}">
                                <label class="control-label">Número<span class="text-danger"> *</span></label>
                                <el-input v-model="form.dispatcher.number" :maxlength="11" placeholder="Número..."></el-input>
                                <small class="form-control-feedback" v-if="errors['dispatcher.number']" v-text="errors['dispatcher.number'][0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors['dispatcher.name']}">
                                <label class="control-label">Nombre y/o razón social<span class="text-danger"> *</span></label>
                                <el-input v-model="form.dispatcher.name" :maxlength="100" placeholder="Nombre y/o razón social..."></el-input>
                                <small class="form-control-feedback" v-if="errors['dispatcher.name']" v-text="errors['dispatcher.name'][0]"></small>
                            </div>
                        </div>
                    </div>
                    <h4>Datos conductor</h4>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors['driver.identity_document_type_id']}">
                                <label class="control-label">Tipo Doc. Identidad<span class="text-danger"> *</span></label>
                                <el-select v-model="form.driver.identity_document_type_id" filterable>
                                    <el-option v-for="option in identityDocumentTypes" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors['driver.identity_document_type_id']" v-text="errors['driver.identity_document_type_id'][0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors['driver.number']}">
                                <label class="control-label">Número<span class="text-danger"> *</span></label>
                                <el-input v-model="form.driver.number" :maxlength="11" placeholder="Número..."></el-input>
                                <small class="form-control-feedback" v-if="errors['driver.number']" v-text="errors['driver.number'][0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" :class="{'has-danger': errors.license_plate}">
                                <label class="control-label">Numero de placa del vehiculo<span class="text-danger"> *</span></label>
                                <el-input v-model="form.license_plate" :maxlength="8" placeholder="Numero de placa del vehiculo..."></el-input>
                                <small class="form-control-feedback" v-if="errors.license_plate" v-text="errors.license_plate[0]"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="font-weight-bold">Unidad</th>
                                    <th class="font-weight-bold">Descripción</th>
                                    <th class="text-right font-weight-bold">Cantidad</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody v-if="form.items.length > 0">
                                <tr v-for="(row, index) in form.items">
                                    <td>{{index + 1}}</td>
                                    <td>{{ row.unit_type_id }}</td>
                                    <td>{{row.description}}</td>
                                    <td class="text-right">{{row.quantity}}</td>
                                    <td class="text-right">
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" @click.prevent="clickRemoveItem(index)">x</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <button type="button" class="btn waves-effect waves-light btn-primary" @click.prevent="showDialogAddItems = true">+ Agregar Producto</button>
                    </div>
                </div>
                <div class="form-actions text-right mt-4">
                    <el-button @click.prevent="close()">Cancelar</el-button>
                    <el-button type="primary" native-type="submit" :loading="loading_submit" v-if="(form.items.length > 0)">Generar</el-button>
                </div>
            </form>
        </div>

        <person-form :showDialog.sync="showDialogNewPerson" type="customers" :external="true"></person-form>

        <items :dialogVisible.sync="showDialogAddItems" @addItem="addItem"></items>
    </div>
</template>

<script>
    import PersonForm from '../persons/form.vue';
    import Items from './items.vue';

    export default {
        components: {PersonForm, Items},
        data() {
            return {
                showDialogNewPerson: false,
                identityDocumentTypes: [],
                showDialogAddItems: false,
                transferReasonTypes: [],
                transportModeTypes: [],
                resource: 'dispatches',
                establishment_id: null,
                loading_submit: false,
                provincesDelivery: [],
                districtsDelivery: [],
                provincesOrigin: [],
                districtsOrigin: [],
                establishments: [],
                districtsAll: [],
                provincesAll: [],
                departments: [],
                countries: [],
                seriesAll: [],
                unitTypes: [],
                customers: [],
                code: null,
                locations: [],
                series: [],
                errors: {
                    errors: {}
                },
                form: {}
            }
        },
        created() {
            // this.clean();
            this.initForm()

            this.$http.post(`/${this.resource}/tables`).then(response => {
                this.identityDocumentTypes = response.data.identityDocumentTypes;
                this.transferReasonTypes = response.data.transferReasonTypes;
                this.transportModeTypes = response.data.transportModeTypes;
                this.establishments = response.data.establishments;
                this.departments = response.data.departments;
                this.provincesAll = response.data.provinces;
                this.districtsAll = response.data.districts;
                this.unitTypes = response.data.unitTypes;
                this.customers = response.data.customers;
                this.countries = response.data.countries;
                this.locations = response.data.locations;
                this.seriesAll = response.data.series;
            });
        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    establishment_id: null,
                    document_type_id: '09',
                    series_id: null,
                    number: '#',
                    date_of_issue: moment().format('YYYY-MM-DD'),
                    time_of_issue: moment().format('HH:mm:ss'),
                    date_of_shipping: moment().format('YYYY-MM-DD'),
                    customer_id: null,
                    observations: '',
                    transport_mode_type_id: null,
                    transfer_reason_type_id: null,
                    transfer_reason_description: null,
                    transshipment_indicator: false,
                    port_code: null,
                    unit_type_id: null,
                    total_weight: 0,
                    packages_number: null,
                    container_number: null,
                    dispatcher: {
                        identity_document_type_id: null
                    },
                    driver: {
                        identity_document_type_id: null
                    },
                    delivery: {
                        country_id: 'PE',
                        location_id: [],
                        address: null,
                    },
                    origin: {
                        country_id: 'PE',
                        location_id: [],
                        address: null,
                    },
                    // optional: {
                    //     invoice_number: this.document.series+'-'+this.document.number
                    // },
                    items: [],

                }
            },
            changeEstablishment() {
                this.series = _.filter(this.seriesAll, {
                    'establishment_id': this.form.establishment_id,
                    'document_type_id': this.form.document_type_id
                });

                this.code = this.form.establishment_id;
                this.establishment_id = this.form.establishment_id;
            },
            filterProvince(origin = true) {
                if (origin) {
                    this.provincesOrigin = _.filter(this.provincesAll, {
                        'department_id': this.form.origin.department_id
                    });

                    this.$set(this.form.origin, 'province_id', null);
                    this.$set(this.form.origin, 'location_id', null);

                    return;
                }

                this.provincesDelivery = _.filter(this.provincesAll, {
                    'department_id': this.form.delivery.department_id
                });

                this.$set(this.form.delivery, 'province_id', null);
                this.$set(this.form.delivery, 'location_id', null);
            },
            filterDistrict(origin = true) {
                if (origin) {
                    this.districtsOrigin = _.filter(this.districtsAll, {
                        'province_id': this.form.origin.province_id
                    });

                    this.$set(this.form.origin, 'location_id', null);

                    return;
                }

                this.districtsDelivery = _.filter(this.districtsAll, {
                    'province_id': this.form.delivery.province_id
                });

                this.$set(this.form.delivery, 'location_id', null);
            },
            addItem(form) {

                let exist = this.form.items.find((item) => item.id == form.item.id);

                if (exist) {
                    exist.quantity += form.quantity;
                    return;
                }

                this.form.items.push({
                    'description': form.item.description,
                    'internal_id': form.item.internal_id,
                    'quantity': form.quantity,
                    'item_id': form.item.id,
                    'unit_type_id': form.item.unit_type_id,
                    'id': form.item.id,
                });
            },
            clickRemoveItem(index) {
                this.form.items.splice(index, 1);
            },
            submit() {

                // console.log(this.form)
                if(this.form.origin.location_id.length != 3 || this.form.delivery.location_id.length != 3)
                    return this.$message.error('El campo ubigeo es obligatorio')

                this.loading_submit = true;

                this.$http.post(`/${this.resource}`, this.form).then(response => {
                        if (response.data.success) {
                            this.initForm();

                            this.$message.success(response.data.message)
                        }
                        else {
                            this.$message.error(response.data.message);
                        }
                    }).catch(error => {
                        this.loading_submit = false;

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
            clean() {
                this.form = {
                    time_of_issue: moment().format('HH:mm:ss'),
                    dispatcher: {
                        identity_document_type_id: null
                    },
                    driver: {
                        identity_document_type_id: null
                    },
                    document_type_id: '09',
                    delivery: {
                        country_id: 'PE'
                    },
                    origin: {
                        country_id: 'PE'
                    },
                    number: '#',
                    items: [],
                    total_weight: null,
                    packages_number: null,
                    container_number: null
                }
            },
            close() {
                location.href = '/dispatches';
            },
        }
    }
</script>

<template>
    <div>
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Filter</strong> Elements
                        </div>
                        <form class="form-horizontal" @submit.prevent="postValues">
                        <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Campaña</label>
                                    <div class="col-md-2">
                                        <select class="form-control form-control-sm" v-model="selectedCompany" @change="getUbigeos" >
                                            <option value="" disabled>Seleccionar</option>
                                            <option v-for="company in companies"  :value='company'>{{ company.fullname }} </option>
                                        </select>
                                        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="false" :height="20"></loading>
                                    </div>
                                    <label class="col-md-2 col-form-label">Ciudades</label>
                                    <div class="col-md-2">
                                        <select class="form-control form-control-sm" v-model="selectedUbigeo">
                                            <option value="" disabled>Seleccionar</option>
                                            <option v-for="ubigeo in ubigeos"  :value="ubigeo.ubigeo">{{ ubigeo.ubigeo }} </option>
                                        </select>
                                        <loading :active.sync="isLoading1" :can-cancel="false" :is-full-page="false" :height="20"></loading>
                                    </div>
                                    <label class="col-md-2 col-form-label">Auditores</label>
                                    <div class="col-md-2">
                                        <select class="form-control form-control-sm" v-model="selectedAuditor">
                                            <option value="" disabled>Seleccionar</option>
                                            <option v-for="auditor in auditors"  :value="auditor" >{{ auditor.fullname }} </option>
                                        </select>
                                        <loading :active.sync="isLoading2" :can-cancel="false" :is-full-page="false" :height="20"></loading>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Categorias</label>
                                    <div class="col-md-2">
                                        <select class="form-control form-control-sm" v-model="selectedCategory" >
                                            <option value="" disabled>Seleccionar</option>
                                            <option v-for="category in categories"  :value="category">{{ category.fullname }} </option>
                                        </select>
                                        <loading :active.sync="isLoading3" :can-cancel="false" :is-full-page="false" :height="20"></loading>
                                    </div>
                                    <label class="col-md-2 col-form-label">Tipo de Sod</label>
                                    <div class="col-md-6 col-form-label">
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-radio1" type="radio" v-model="trabajado"  value="Sod Trabajado" name="inline-radios" checked>
                                            <label class="form-check-label" for="inline-radio1" >Sod Trabajado</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-radio2" type="radio" v-model="trabajado"  value="Sod No Trabajado" name="inline-radios">
                                            <label class="form-check-label" for="inline-radio2">Sod No Trabajado</label>
                                        </div>
                                    </div>
                                </div>
                            <b-alert :show="dismissCountDown"
                                     dismissible
                                     fade
                                     variant="danger"
                                     @dismissed="dismissCountDown=0"
                                     @dismiss-count-down="countDownChanged">
                                {{mensaje}}
                            </b-alert>

                        </div>
                        <div class="card-footer">
                            <div class="row align-items-center mt-3">
                                <div class="col-lg-4 col-sm-4 col-md mb-3 mb-xl-0 text-left">
                                    <button class="btn btn-sm btn-primary">
                                        <i class="fa fa-search"></i> Buscar Ventanas
                                    </button>
                                </div>
                                <div class="col-lg-8 col-sm-8 col-md mb-3 mb-xl-0 text-right">
                                    <span class="badge badge-pill badge-primary" v-if="selectedCompany != ''">{{selectedCompany.fullname}}</span>
                                    <span class="badge badge-success" v-if="selectedUbigeo != ''">{{selectedUbigeo}}</span>
                                    <span class="badge badge-pill badge-light" v-if="selectedAuditor != ''">{{selectedAuditor.fullname}}</span>
                                    <span class="badge badge-pill badge-secondary" v-if="selectedCategory != ''">{{selectedCategory.fullname}}</span>
                                    <span class="badge badge-pill badge-dark" v-if="trabajado != ''">{{trabajado}}</span>
                                </div>
                            </div>

                        </div>
                        </form>
                    </div>

                </div>
            </div>
            <BlockStoresSod ></BlockStoresSod>
        </div>

        <!--Loading Complemento-->
        <!--<div class="vld-parent">
            <loading :active.sync="isLoading"
                     :can-cancel="false"
                     :is-full-page="fullPage">
            </loading>

        </div>-->
    </div>

</template>

<script>
    import CardDoughnutStoreBase from './dashboard/DoughnutStoreBase'
    import BarChartPolls from './dashboard/BarChartPolls'
    import { Callout } from '../components/'

    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    import BlockStoresSod from "./components/BlockStoresSod";
    import EventBus from '../bus';


    export default {
        name: 'MedicionSod',
        components: {
            Callout,
            CardDoughnutStoreBase,
            BarChartPolls,
            BlockStoresSod,
            Loading
        },
        mounted() {
            this.getCampaignes()
            this.getAuditors()
        },
        props: [],
        data(){
            return{
                tipo:'Sod',
                dismissSecs: 2,
                dismissCountDown: 0,
                mensaje:'',
                customer_id:4,
                study_id:6,
                trabajado:0,
                categoryProduct:54,
                selectedCompany: '',
                selectedUbigeo:'',
                selectedAuditor:'',
                selectedCategory:'',
                companies: [],
                ubigeos: [],
                auditors: [],
                categories: [],
                isLoading: false,
                isLoading1: false,
                isLoading2: false,
                isLoading3: false,
                fullPage: false,
                selectedValues:[]
            }
        },
        methods:{

            countDownChanged (dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },
            showAlert () {
                this.dismissCountDown = this.dismissSecs
            },
            getCampaignes()
            {
                this.companies = [];
                this.isLoading = true;
                let urlCombo = '/api/getCampaignes/'+ this.customer_id + '/1/' + this.study_id + '/T/';
                axios.get(urlCombo)
                    .then((response) => {
                        //console.log(response.data)
                        this.companies = response.data;
                        this.isLoading = false;
                    })
                    .catch((response) => {
                        this.isLoading = false;
                        console.log('Error', error);
                    })
            },
            getAuditors()
            {
                this.auditors = [];
                this.isLoading2 = true;
                let urlCombo = '/api/getUsersForType/auditor';
                axios.get(urlCombo)
                    .then((response) => {
                        //console.log(response.data)
                        this.auditors = response.data
                        this.isLoading2 = false;
                    })
                    .catch((response) => {
                        this.isLoading2 = false;
                        console.log('Error', error);
                    })
            },
            getUbigeos()
            {
                this.ubigeos = [];
                this.isLoading1 = true;//console.log(this.selectedCompany);
                let urlCombo = '/api/getUbigeosForCampaigne/'+ this.selectedCompany.id;
                //this.selectedValues =
                axios.get(urlCombo)
                    .then((response) => {
                        this.ubigeos = response.data
                        this.isLoading1 = false;
                        this.getCategories();
                    })
                    .catch((response) => {
                        this.isLoading1 = false;
                        console.log('Error', error);
                    })
            },
            getCategories()
            {
                this.categories = [];
                this.isLoading3 = true;
                let urlCombo = '/api/getPublicitiesForCategory/'+ this.categoryProduct + '/' + this.selectedCompany.id;
                axios.get(urlCombo)
                    .then((response) => {
                        this.categories = response.data
                        this.isLoading3 = false;
                    })
                    .catch((response) => {
                        this.isLoading3 = false;
                        console.log('Error', error);
                    })
            },
            postValues()
            {
                //console.log(this.trabajado);
                if (this.selectedCompany.length == 0 )
                {
                    this.mensaje="No hay campaña seleccionada";this.showAlert();
                }else{
                    if (this.selectedUbigeo=="")
                    {
                        this.mensaje="No hay ciudad seleccionada";this.showAlert();
                    }else{
                        if (this.selectedAuditor.length == 0)
                        {
                            this.mensaje="No hay auditor seleccionado";this.showAlert();
                        }else{
                            if (this.selectedCategory.length == 0 )
                            {
                                this.mensaje="No hay Categoria seleccionada";this.showAlert();
                            }else{
                                if (this.trabajado == 0)
                                {
                                    this.mensaje="No hay Tipo de Sod seleccionado";this.showAlert();
                                }else{
                                    this.mensaje=0;
                                    this.selectedValues.push({objCompany: this.selectedCompany, ubigeo: this.selectedUbigeo,objAuditor: this.selectedAuditor, objCategory:this.selectedCategory, trabajado:this.trabajado, tipo:this.tipo});
                                    EventBus.$emit('sendValuesSod', this.selectedValues);
                                }
                            }
                        }
                    }
                }
            }

        }
    }
</script>

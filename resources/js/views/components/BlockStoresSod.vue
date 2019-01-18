<template>
    <div v-if="verComponente">
        <div class="row">
            <div class="col-sm-4">
                <div class="callout callout-info">
                    <small class="text-muted">Publicidad</small>
                    <br>
                    <strong class="h4">{{this.selectedCategory.fullname + "(" + this.selectedCategory.id + ")"}}</strong>
                    <div class="chart-wrapper">
                        <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="callout callout-warning">
                    <small class="text-muted">Total Base</small>
                    <br>
                    <strong class="h4">{{this.totalBase}}</strong>
                    <div class="chart-wrapper">
                        <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="callout callout-danger">
                    <small class="text-muted">Avance No Medidos</small>
                    <br>
                    <strong class="h4">{{this.totalNoMedidos}}</strong>
                    <div class="chart-wrapper">
                        <canvas id="sparkline-chart-3" width="100" height="30"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            {{stores_indice[indice].store_id}} - {{stores_indice[indice].fullname}}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="callout callout-warning d-inline-flex col-auto" v-for="product in productsPublicities">
                                    <label class="col-form-label">{{product.product}}</label>
                                    <input class="form-control" type="text">
                                </div>
                                <button class="btn btn-sm btn-warning" type="button" @click="avanza()">Grabar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-lg-6"><img :src="'http://ttaudit.com/media/fotos/'+stores_indice[indice].foto" class="rounded img-fluid img-thumbnail" ></div>
                            <div class="col-sm-6 col-lg-6">
                                <BlockResponseSod></BlockResponseSod>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

</template>

<script>
    import EventBus from '../../bus';
    import BlockResponseSod from "./BlockResponseSod";

    export default {
        name: "BlockStoresSod",
        components: {BlockResponseSod},
        props:[],
        data(){
            return{
                selectedCompany:'',
                selectedUbigeo: '',
                selectedCategory:'',
                trabajado:0,
                tipo:'',
                selectedAuditor:'',
                stores:[],
                verComponente:false,
                totalBase:0,
                totalNoMedidos:0,
                indice:0,
                stores_indice:[],
                productsPublicities:[]
            }
        },
        mounted(){
            EventBus.$on('sendValuesSod', (item) => {
                this.selectedCompany = item[0].objCompany;
                this.selectedUbigeo = item[0].ubigeo;
                this.selectedAuditor = item[0].objAuditor;
                this.selectedCategory = item[0].objCategory;
                //this.trabajado = item[0].trabajado;
                this.tipo = item[0].tipo;
                if (item[0].trabajado=="Sod Trabajado")
                {
                    this.trabajado =1;
                }else{
                    this.trabajado =0;
                }
                this.getSods();
            });
        },
        methods:{
            avanza(){
                if ((this.indice+1)<this.totalNoMedidos)
                {
                    this.indice = this.indice + 1;
                }
            },
            getSods() {
                let urlBase = '/api/listStoresPublicities';
                axios.post(urlBase, {
                    company_id: this.selectedCompany.id,
                    ciudad: this.selectedUbigeo,
                    auditor: this.selectedAuditor.id,
                    publicity: this.selectedCategory.id,
                    tipo: this.tipo,
                    trabajada: this.trabajado
                })
                    .then((response) => {
                        this.stores = response.data.BaseNoMedidos;
                        this.verComponente = true;
                        this.totalBase = response.data.TotalBase;
                        this.totalNoMedidos = response.data.TotalNoMedidos;
                        console.log(response);
                        console.log(this.stores);
                        var storeReor = this.stores;
                        for (var indice1 in storeReor) {
                            //console.log("En el índice " + indice + " hay este valor: " + valor);
                            this.stores_indice.push({
                                store_id: indice1,
                                fullname: storeReor[indice1][0]['fullname'],
                                foto: storeReor[indice1][0]['Foto'],
                                publicity_id: storeReor[indice1][0]['publicity_id'],
                                publicity_details_id: storeReor[indice1][0]['publicity_details_id']
                            });
                        }
                        console.log(this.stores_indice[this.indice].publicity_id);
                        this.getProducts();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getProducts(){
                let urlResponse = '/api/getProductsPublicity/' + this.selectedCompany.id + '/' + this.stores_indice[this.indice].publicity_id;

                axios.get(urlResponse)
                    .then((response) => {
                        // handle success
                        this.productsPublicities = response.data;
                        console.log(this.productsPublicities);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
            }
        }
    }
</script>

<style scoped>

</style>
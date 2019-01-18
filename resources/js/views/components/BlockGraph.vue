<template>
    <div class="chart-wrapper" >
        <loading :active.sync="isLoading2" :can-cancel="false" :is-full-page="false" :height="20"></loading>
        <div class="row" v-if="poll.options==1 && poll.sino==1">
            <div class="col-sm-6 col-lg-6">
                <div  ref="chartDonout" style="height: 200px">
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div  ref="chartBar" style="height: 250px">
                </div>
            </div>
        </div>
        <div class="row" v-if="poll.options==1 && poll.sino==1">
            <div class="col-sm-6 col-lg-6">
                <div class="accordion" id="accordionDonout">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOneD1" aria-expanded="true" aria-controls="collapseOneD1">
                                    <i class="fa fa-align-justify"></i> Datos Si No
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOneD1" class="collapse" aria-labelledby="headingOne" data-parent="#accordionDonout">
                            <div class="card-body">
                                <table class="table table-responsive-sm">
                                    <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Valor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data,index) in leyendasDonouts ">
                                        <td><span class="btn-link" data-toggle="modal" data-target="#infoModal" @click="loadValuesModal(index,data.type)">{{data.opcion}}</span></td>
                                        <td>{{data.valor}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fa fa-align-justify"></i> Datos Opciones
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <table class="table table-responsive-sm">
                                    <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Valor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data,index) in leyendas ">
                                        <td><span class="btn-link" data-toggle="modal" data-target="#infoModal" @click="loadValuesModal(index,data.type)">{{data.opcion}}</span></td>
                                        <td>{{data.valor}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="row" v-if="poll.options==1 && poll.sino==0">
            <div class="col-sm-6 col-lg-6">
                <div  ref="chartBar" style="height: 250px">
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="accordion" id="accordionOptions1">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOneOption1" aria-expanded="true" aria-controls="collapseOneOption1">
                                    <i class="fa fa-align-justify"></i> Datos Opciones
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOneOption1" class="collapse" aria-labelledby="headingOne" data-parent="#accordionOptions1">
                            <div class="card-body">
                                <table class="table table-responsive-sm">
                                    <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Valor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data,index) in leyendas ">
                                        <td><span class="btn-link" data-toggle="modal" data-target="#infoModal" @click="loadValuesModal(index,data.type)">{{data.opcion}}</span></td>
                                        <td>{{data.valor}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if="poll.options==0 && poll.sino==1">
            <div class="col-sm-6 col-lg-6">
                <div  ref="chartDonout" style="height: 200px">
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="accordion" id="accordionDonoutD2">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOneD2" aria-expanded="true" aria-controls="collapseOneD2">
                                    <i class="fa fa-align-justify"></i> Datos Si No
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOneD2" class="collapse" aria-labelledby="headingOne" data-parent="#accordionDonoutD2">
                            <div class="card-body">
                                <table class="table table-responsive-sm">
                                    <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Valor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data,index) in leyendasDonouts ">
                                        <td><span class="btn-link" data-toggle="modal" data-target="#infoModal" @click="loadValuesModal(index,data.type)">{{data.opcion}}</span></td>
                                        <td>{{data.valor}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import CardDoughnutStoreBase from '../dashboard/DoughnutStoreBaseAmchart';
    import BarChartPolls from '../dashboard/BarChartPolls'
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4charts from "@amcharts/amcharts4/charts";
    import am4themes_animated from "@amcharts/amcharts4/themes/animated";
    import EventBus from '../../bus';

    am4core.useTheme(am4themes_animated);

    export default {
        name: "BlockGraph",
        props:['poll','ubigeo'],
        components: {
            CardDoughnutStoreBase,
            BarChartPolls,
            Loading
        },
        mounted() {
            this.getResponses();
        },
        methods:{
            loadValuesModal(index,type) {
                if (type=="sino")
                {
                    this.id=this.leyendasDonouts[index];
                }else{
                    this.id=this.leyendas[index];
                }

                EventBus.$emit('loadValuesModal', this.id);
            },
            getResponses: function () {
                this.isLoading2 = true;
                let type;
                if (this.poll.sino == 1) {
                    type = 1;
                }
                if (this.poll.options == 1) {
                    type = 2;
                }
                if ((this.poll.sino == 1) && (this.poll.options == 1)) {
                    type = 3;
                }
                let poll_id = this.poll.id;
                let ciudad = this.ubigeo;
                let urlResponse = "";
                if (ciudad != '') {
                    urlResponse = '/api/getPollDetailsForPollId/' + poll_id + '/' + type + '/' + ciudad;
                } else {
                    urlResponse = '/api/getPollDetailsForPollId/' + poll_id + '/' + type;
                }

                axios.get(urlResponse)
                    .then((response) => {
                        this.isLoading2 = false;
                        //console.log(urlResponse);

                        if ((type == 1) || (type == 3)) {
                            //console.log(response);
                            let si = response.data['si'];
                            let no = response.data['no'];
                            /*this.datacollection = {
                                labels: ['Si', 'No'],
                                datasets: [
                                    {
                                        backgroundColor: [
                                            '#36A2EB',
                                            '#FF6384',
                                            '#00D8FF',
                                            '#DD1B16'
                                        ],
                                        data: [si, no ]
                                    }
                                ]
                            };*/
                            this.datos = [{
                                "SiNo": "Si",
                                "cantidad": si
                            }, {
                                "SiNo": "No",
                                "cantidad": no
                            }];
                            this.datosSiNo= [{
                                "SiNo": "Si",
                                "cantidad": si,
                                "stores": response.data['storesSi']
                            }, {
                                "SiNo": "No",
                                "cantidad": no,
                                "stores": response.data['storesNo']
                            }];
                            this.createdDonout();
                        }
                        if ((type == 2) || (type == 3)) {
                            /*this.dataPollBar = {
                                labels:response.data['opciones'],
                                type: 'horizontalBar',
                                datasets:[
                                    {
                                        label:'Opciones',
                                        backgroundColor:'#36A2EB',
                                        data:response.data['count']
                                    }
                                ]
                            }*/
                            for (var indice in response.data['opciones']) {
                                this.datos.push({opcion: response.data['opciones'][indice], valor: response.data['count'][indice]});
                                this.datosOptions.push({opcion: response.data['opciones'][indice], valor: response.data['count'][indice], opcion_id: response.data['options_id'][indice], storesOption: response.data['storesOption']});
                            }
                            /*for (var indice in this.datos) {
                                console.log("opcion: '" + this.datos[indice]['opcion'] + "' valor: " + this.datos[indice]['valor']);
                            }*/
                            //console.log(this.datos);
                            this.createdBar();
                        }


                    })
                    .catch((response) => {
                        this.isLoading2 = false;
                        console.log('Error', response);


                    })
            },
            createdDonout(){
                for (var indice in this.datosSiNo) {
                    this.leyendasDonouts.push({
                        "ciudad": this.ubigeo,
                        "poll_id": this.poll.id,
                        "type":"sino",
                        "option_id":0,
                        "opcion": this.datosSiNo[indice]['SiNo'],
                        "valor": this.datosSiNo[indice]['cantidad'],
                        "stores":this.datosSiNo[indice]['stores']
                    });
                }//console.log(this.leyendasDonouts);
                let chart = am4core.create(this.$refs.chartDonout, am4charts.PieChart3D);

                chart.data = this.datos;
                chart.exporting.menu = new am4core.ExportMenu();
                chart.numberFormatter.outputFormat = "#.";

                let pieSeries = chart.series.push(new am4charts.PieSeries3D());
                chart.innerRadius = am4core.percent(40);
                pieSeries.dataFields.value = "cantidad";
                pieSeries.dataFields.category = "SiNo";
                this.datos=[];
            },
            createdBar(){
                for (var indice in this.datosOptions) {
                    this.leyendas.push({
                        "ciudad": this.ubigeo,
                        "poll_id": this.poll.id,
                        "type":"option",
                        "option_id":this.datosOptions[indice]['opcion_id'],
                        "opcion": this.datosOptions[indice]['opcion'],
                        "valor": this.datosOptions[indice]['valor'],
                        "stores":this.datosOptions[indice]['storesOption'][this.datosOptions[indice]['opcion_id']]
                    });
                }//console.log(this.leyendas);
                // Use themes
                am4core.useTheme(am4themes_animated);

// Create chart instance
                var chart = am4core.create(this.$refs.chartBar, am4charts.XYChart3D);

                chart.data =this.datos;
                chart.exporting.menu = new am4core.ExportMenu();
                var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "opcion";
                //categoryAxis.title.text = "Opciones";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.minGridDistance = 30;

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.title.text = "Auditorias";

                /*valueAxis.calculateTotals = true;
                valueAxis.min = 0;
                valueAxis.strictMinMax = true;
                valueAxis.renderer.labels.template.adapter.add("text", function(text) {
                    return text + "%";
                });*/

                /* Create series */
                var series1 = chart.series.push(new am4charts.ColumnSeries3D());
                series1.columns.template.width = am4core.percent(80);
                series1.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
                //series1.name = this.datos[indice]['opcion'];
                series1.dataFields.categoryX = "opcion";
                series1.dataFields.valueY = "valor";
                //series1.calculateTotals = true;
                series1.stacked = true;


                //
                this.datos=[];
            }
        },
        data(){
            return{
                datacollection: null,
                dataPollBar: null,
                isLoading2: false,
                fullPage: false,
                datos:[],
                datosSiNo:[],
                datosOptions:[],
                leyendas:[],
                leyendasDonouts:[],
                id:0
            }
        }
    }
</script>

<style scoped>

</style>
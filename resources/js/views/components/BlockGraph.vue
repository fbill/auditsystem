<template>
    <div class="chart-wrapper" >
        <loading :active.sync="isLoading2" :can-cancel="false" :is-full-page="false" :height="20"></loading>
        <div class="row" v-if="poll.options==1 && poll.sino==1">
            <div class="col-sm-12 col-lg-12">
                <div  ref="chartDonout" style="height: 200px">
                </div>
            </div>
        </div>
        <div class="row" v-if="poll.options==1 && poll.sino==1">
            <div class="col-sm-12 col-lg-12">
                <div  ref="chartBar" style="height: 500px">
                </div>
            </div>
        </div>
        <div class="row" v-if="poll.options==1 && poll.sino==0">
            <div class="col-sm-12 col-lg-12">
                <div  ref="chartBar" style="height: 500px">
                </div>
            </div>
        </div>
        <div class="row" v-if="poll.options==0 && poll.sino==1">
            <div class="col-sm-12 col-lg-12">
                <div class="col-sm-12 col-lg-12">
                    <div  ref="chartDonout" style="height: 200px">
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
                            this.createdDonout();
                        }
                        if ((type == 2) || (type == 3)) {
                            console.log(this.datos);
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
                                console.log("opcion: '" + response.data['opciones'][indice] + "' valor: " + response.data['count'][indice]);
                                this.datos.push({opcion: response.data['opciones'][indice], valor: response.data['count'][indice]});
                            }
                            this.createdBar();
                        }


                    })
                    .catch((response) => {
                        this.isLoading2 = false;
                        console.log('Error', response);


                    })
            },
            createdDonout(){
                let chart = am4core.create(this.$refs.chartDonout, am4charts.PieChart);

                chart.data = this.datos;

                let pieSeries = chart.series.push(new am4charts.PieSeries());
                chart.innerRadius = am4core.percent(40);
                pieSeries.dataFields.value = "cantidad";
                pieSeries.dataFields.category = "SiNo";
                this.datos=[];
            },
            createdBar(){
                let chart = am4core.create(this.$refs.chartBar, am4charts.XYChart);
                chart.scrollbarX = new am4core.Scrollbar();
                chart.data = this.datos;


// Create axes
                var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "opcion";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.minGridDistance = 3;
                categoryAxis.renderer.labels.template.horizontalCenter = "right";
                categoryAxis.renderer.labels.template.verticalCenter = "middle";
                categoryAxis.renderer.labels.template.rotation = 270;
                categoryAxis.tooltip.disabled = true;
                categoryAxis.renderer.minHeight = 5;

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.calculateTotals = false;
                /*valueAxis.min = 0;
                valueAxis.max = 100;
                valueAxis.strictMinMax = true;
                valueAxis.renderer.labels.template.adapter.add("text", function(text) {
                    return text + "%";
                });*/

// Create series
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.sequencedInterpolation = true;
                series.dataFields.valueY = "valor";
                series.dataFields.categoryX = "opcion";
                series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
                series.columns.template.strokeWidth = 0;

                series.tooltip.pointerOrientation = "vertical";

                series.columns.template.column.cornerRadiusTopLeft = 10;
                series.columns.template.column.cornerRadiusTopRight = 10;
                series.columns.template.column.fillOpacity = 0.8;

                series.legendSettings.labelText = "Series: [bold {stroke}]{name}[/]";
                series.legendSettings.valueText = "{valueY.close}";

// on hover, make corner radiuses bigger
                let hoverState = series.columns.template.column.states.create("hover");
                hoverState.properties.cornerRadiusTopLeft = 0;
                hoverState.properties.cornerRadiusTopRight = 0;
                hoverState.properties.fillOpacity = 1;

                series.columns.template.adapter.add("fill", (fill, target)=>{
                    return chart.colors.getIndex(target.dataItem.index);
                })
                chart.legend = new am4charts.Legend();

// Cursor
                chart.cursor = new am4charts.XYCursor();

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
                datos:[]
            }
        }
    }
</script>

<style scoped>

</style>
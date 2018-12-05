<template>
    <div  ref="chartdiv">
    </div>
</template>
<script>
    import * as am4core from "@amcharts/amcharts4/core";
    import * as am4charts from "@amcharts/amcharts4/charts";
    import am4themes_animated from "@amcharts/amcharts4/themes/animated";

    am4core.useTheme(am4themes_animated);
console.log(this.datos);
    export default {
        name: "DoughnutStoreBaseAmchart",
        props: {
            datos: {
                type: Array
            }
        },
        mounted () {
            let chart = am4core.create(this.$refs.chartdiv, am4charts.PieChart);

            chart.data = this.datos;
            let pieSeries = chart.series.push(new am4charts.PieSeries());
            chart.innerRadius = am4core.percent(40);
            pieSeries.dataFields.value = "cantidad";
            pieSeries.dataFields.category = "SiNo";
            this.grafica();
        },
        methods:{
            grafica(){
                console.log(this.datos);
            }
        }
    }

</script>

<script>
    import { Doughnut , mixins } from 'vue-chartjs'
    const { reactiveProp } = mixins

    export default {
        extends: Doughnut,
        mixins: [reactiveProp],
        mounted () { console.log(this.datacollection);
            this.renderChart(this.datacollection, {responsive: true, maintainAspectRatio: false})
        }
    }

</script>

<script>
    import { HorizontalBar,mixins } from 'vue-chartjs'
    const { reactiveProp } = mixins
    export default (
        {
            extends: HorizontalBar,
            mixins: [reactiveProp],
            mounted () {
                // Overwriting base render method with actual data.
                // this.renderChart({
                //     labels: ['January', 'February',],
                //     datasets: [
                //         {
                //             label: 'GitHub Commits',
                //             backgroundColor: '#f87979',
                //             data: [40, 20]
                //         }
                //     ]
                // })
                this.renderChart(this.dataPollBar, {responsive: true, maintainAspectRatio: false})
            }
    })
</script>
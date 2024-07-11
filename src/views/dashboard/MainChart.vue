<template>
  <CChart type="line" :data="data" :options="options" ref="mainChartRef" />
</template>

<script>
import { ref } from 'vue'
import { CChart } from '@coreui/vue-chartjs'
import { getStyle } from '@coreui/utils'
import { statistique } from '../../services';

const random = (min, max) => Math.floor(Math.random() * (max - min + 5) + min)

export default {
  name: 'MainChartExample',
  components: {
    CChart,
  },
  data() {
    return {
      data: {
        labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juiellet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
        datasets: [
          {
            label: 'My First dataset',
            backgroundColor: `rgba(${getStyle('--cui-info-rgb')}, .1)`,
            borderColor: getStyle('--cui-info'),
            pointHoverBackgroundColor: getStyle('--cui-info'),
            borderWidth: 2,
            data: [
              random(50, 500),
              random(50, 500),
              random(50, 500),
              random(50, 500),
              random(50, 500),
              random(50, 500),
              random(50, 500),
              random(50, 500),
              random(50, 500),
              random(50, 500),
              random(50, 500),
              random(50, 500),
            ],
            fill: true,
          },
        ],
      }
    }
  },
  setup() {
    const mainChartRef = ref();
    const options = {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          grid: {
            color: getStyle('--cui-border-color-translucent'),
            drawOnChartArea: false,
          },
          ticks: {
            color: getStyle('--cui-body-color'),
          },
        },
        y: {
          beginAtZero: true,
          border: {
            color: getStyle('--cui-border-color-translucent'),
          },
          grid: {
            color: getStyle('--cui-border-color-translucent'),
          },
          max: 1000,
          ticks: {
            color: getStyle('--cui-body-color'),
            maxTicksLimit: 5,
            stepSize: Math.ceil(250 / 5),
          },
        },
      },
      elements: {
        line: {
          tension: 0.4,
        },
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3,
        },
      },
    }

    return { mainChartRef, options }
  },
  mounted() {
    statistique.rapportVente().then((response) => {
      const apiData = response.data
      let donnees = apiData.map(item => item.total_vente + 200)
      let formatedData = Object.fromEntries(donnees.map((valeur, index) => [index, valeur]));
      // this.data.datasets[0].data = formatedData

      console.log(formatedData);
      console.log(this.data.datasets[0].data);
    })

    document.documentElement.addEventListener('ColorSchemeChange', () => {
      if (this.mainChartRef.value) {
        this.mainChartRef.value.chart,
          (this.options.scales.x.grid.borderColor = getStyle(
            '--cui-border-color-translucent',
          ))
        this.mainChartRef.value.chart,
          (this.options.scales.x.grid.color = getStyle(
            '--cui-border-color-translucent',
          ))
        this.mainChartRef.value.chart,
          (this.options.scales.x.ticks.color = getStyle('--cui-body-color'))
        this.mainChartRef.value.chart,
          (this.options.scales.y.grid.borderColor = getStyle(
            '--cui-border-color-translucent',
          ))
        this.mainChartRef.value.chart,
          (this.options.scales.y.grid.color = getStyle(
            '--cui-border-color-translucent',
          ))
        this.mainChartRef.value.chart,
          (this.options.scales.y.ticks.color = getStyle('--cui-body-color'))
        this.mainChartRef.value.chart.update()
      }
    })
  },
}
</script>

<template>
  <CChart type="line" :data="data" :options="options" ref="mainChartRef" />
</template>

<script>
import { onMounted, ref } from 'vue'
import { CChart } from '@coreui/vue-chartjs'
import { getStyle } from '@coreui/utils'
import { statistique } from '../../services';

const random = (min, max) => Math.floor(Math.random() * (max - min + 5) + min)

export default {
  name: 'MainChartExample',
  components: {
    CChart,
  },
  setup() {
    const mainChartRef = ref()
    const data = {
      labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juiellet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre' ],
      datasets: [
        {
          label: 'My First dataset',
          backgroundColor: `rgba(${getStyle('--cui-info-rgb')}, .1)`,
          borderColor: getStyle('--cui-info'),
          pointHoverBackgroundColor: getStyle('--cui-info'),
          borderWidth: 2,
          data: [
            random(50, 200),
            random(50, 200),
            random(50, 200),
            random(50, 200),
            random(50, 200),
            random(50, 200),
            random(50, 200),
            random(50, 200),
            random(50, 200),
            random(50, 200),
            random(50, 200),
            random(50, 200),
          ],
          fill: true,
        },
      ],
    }

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

    onMounted(() => {
      document.documentElement.addEventListener('ColorSchemeChange', () => {
        if (mainChartRef.value) {
          mainChartRef.value.chart,
            (options.scales.x.grid.borderColor = getStyle(
              '--cui-border-color-translucent',
            ))
          mainChartRef.value.chart,
            (options.scales.x.grid.color = getStyle(
              '--cui-border-color-translucent',
            ))
          mainChartRef.value.chart,
            (options.scales.x.ticks.color = getStyle('--cui-body-color'))
          mainChartRef.value.chart,
            (options.scales.y.grid.borderColor = getStyle(
              '--cui-border-color-translucent',
            ))
          mainChartRef.value.chart,
            (options.scales.y.grid.color = getStyle(
              '--cui-border-color-translucent',
            ))
          mainChartRef.value.chart,
            (options.scales.y.ticks.color = getStyle('--cui-body-color'))
          mainChartRef.value.chart.update()
        }
      })
    })

    return {
      data,
      mainChartRef,
      options,
    }
  },
  data() {
    return {
      donnees: []
    }
  },
  mounted() {
    statistique.rapportVente().then((response) => {
      console.log(response);
    } )
  },
}
</script>

<template>
  <v-container fluid grid-list-md v-show="success">
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <v-card>
          <v-card-title primary-title>
            <div>
              <h1 class="title mb-0">Ingresos VS Egresos 2019</h1><br>
              <p class="caption mb-0">Monitoreo de ingresos y gastos del año actual.</p>
            </div>
          </v-card-title>
          <div class="chart" ref="chartdiv"></div>
        </v-card>
      </v-flex>
    </v-layout>
    <v-layout row wrap>
      <v-flex xs12 sm12 md6 lg6 xl6>
        <v-card>
          <v-card-title primary-title>
            <div>
              <h1 class="title mb-0">Egresos por proyecto / {{ curdate() }}</h1>
              <p class="caption mb-0">Monitoreo de gastos del mes actual.</p>
            </div>
          </v-card-title>
          <div class="chart" ref="piediv"></div>
        </v-card>
      </v-flex>
      <v-flex xs12 sm12 md6 lg6 xl6>
        <v-card>
          <v-card-title primary-title>
            <div>
              <h1 class="title mb-0">Ingresos por proyecto / {{ curdate() }}</h1>
              <p class="caption mb-0">Monitoreo de ingresos del mes actual.</p>
            </div>
          </v-card-title>
          <div class="chart" ref="pie2div"></div>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import curdate from '../../mixins/curdate'
  import ReportService from '../../services/report.service'
  import * as am4core from "@amcharts/amcharts4/core";
  import * as am4charts from "@amcharts/amcharts4/charts";
  import am4themes_animated from "@amcharts/amcharts4/themes/animated";
  import am4themes_dataviz from "@amcharts/amcharts4/themes/dataviz";
  import am4themes_moonrisekingdom from "@amcharts/amcharts4/themes/moonrisekingdom";

  am4core.useTheme(am4themes_animated);
  am4core.useTheme(am4themes_dataviz);

  export default {
    name: 'Dashboard',
    data () {
      return {
        success: false 
      }
    },

    mixins: [curdate],

    mounted() {
      this.getQueryForGraphics()
    },

    methods: {
      getQueryForGraphics: async function() {
        const response = await ReportService.getIncomeAndExpenseForYear('graphics')

        if (response.status === 200) { 
          this.getColumnChart(response.data.year)
          this.getPieChart(response.data.expense)
          this.getPie2Chart(response.data.income)
          this.success = true
        }
      },
      getColumnChart(data) {
        let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);

        chart.data = data

        //create category axis for years
        let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "month";

        //create value axis for income and expenses
        let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        //create columns
        let series = chart.series.push(new am4charts.ColumnSeries());
        series.name = "Ingresos";
        series.dataFields.valueY = "income";
        series.dataFields.categoryX = "month";
        series.columns.template.fillOpacity = 0.5;
        series.columns.template.strokeOpacity = 0;
        series.tooltipText = "Ingresos en {categoryX}: {valueY.value}";

        //create line
        let lineSeries = chart.series.push(new am4charts.LineSeries());
        lineSeries.name = "Egresos";
        lineSeries.dataFields.valueY = "expense";
        lineSeries.dataFields.categoryX = "month";
        lineSeries.strokeWidth = 3;
        lineSeries.tooltipText = "Egresos en {categoryX}: {valueY.value}";

        //add bullets
        let circleBullet = lineSeries.bullets.push(new am4charts.CircleBullet());
        circleBullet.circle.fill = am4core.color("#fff");
        circleBullet.circle.strokeWidth = 2;

        //add chart cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomX";

        //add legend
        chart.legend = new am4charts.Legend();
      },

      getPieChart(data) {
        // Create chart instance
        let chart = am4core.create(this.$refs.piediv, am4charts.PieChart);

        // Add and configure Series
        let pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "total";
        pieSeries.dataFields.category = "project";

        // Let's cut a hole in our Pie chart the size of 30% the radius
        chart.innerRadius = am4core.percent(30);

        // Put a thick white border around each Slice
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.slices.template
          // change the cursor on hover to make it apparent the object can be interacted with
          .cursorOverStyle = [
            {
              "property": "cursor",
              "value": "pointer"
            }
          ];

        pieSeries.labels.template.disabled = true;

        // Create a base filter effect (as if it's not there) for the hover to return to
        let shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
        shadow.opacity = 0;

        // Create hover state
        let hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

        // Slightly shift the shadow and make it more prominent on hover
        let hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
        hoverShadow.opacity = 0.7;
        hoverShadow.blur = 5;

        // Add a legend
        chart.legend = new am4charts.Legend();

        chart.data = data;
      },

      getPie2Chart(data) {
        // am4core.useTheme(am4themes_moonrisekingdom);
        // Create chart instance
        let chart = am4core.create(this.$refs.pie2div, am4charts.PieChart);

        // Add and configure Series
        let pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "total";
        pieSeries.dataFields.category = "project";

        // Let's cut a hole in our Pie chart the size of 30% the radius
        chart.innerRadius = am4core.percent(30);

        // Put a thick white border around each Slice
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.slices.template
          // change the cursor on hover to make it apparent the object can be interacted with
          .cursorOverStyle = [
            {
              "property": "cursor",
              "value": "pointer"
            }
          ];

        pieSeries.labels.template.disabled = true;

        // Create a base filter effect (as if it's not there) for the hover to return to
        let shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
        shadow.opacity = 0;

        // Create hover state
        let hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

        // Slightly shift the shadow and make it more prominent on hover
        let hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
        hoverShadow.opacity = 0.7;
        hoverShadow.blur = 5;

        // Add a legend
        chart.legend = new am4charts.Legend();

        chart.data = data;
      }
    }
  }
</script>

<style scoped>
  .chart {
    width: 100%;
    height: 500px;
  }
</style>

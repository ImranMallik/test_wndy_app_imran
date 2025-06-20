
$(document).ready(function () {
  if (session_user_type == "Buyer") {
    makeItemListingPieChart();
    makeScrapValuationChart();
    makeCollectorPurchasedChart();
    makeBuyerEarningDromSalesChart();
  }
  if (session_user_type == "Seller") {
    makeSellerItemListingPieChart();
    makeSellerScrapValuationChart();
  }
});

// for buyer chart
function makeItemListingPieChart() {
  var options = {
    // series: [44, 55, 13, 43, 22],
    series: itemListingValue,
    chart: {
      width: '100%',
      type: 'pie',
    },
    // labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
    labels: itemListingLable,
    // colors: ['black', '#E91E63', '#9C27B0'],
    colors: itemListingColor,
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val.toFixed(2) + "%"
      },
    },
    legend: {
      position: 'bottom'
    },
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: '100%'
        },
      }
    }]
  };

  var chart = new ApexCharts(_("#itemListingChart"), options);
  chart.render();
}

function makeScrapValuationChart() {
  var options = {
    // series: [44, 55, 13, 43, 22],
    series: scrapValuationValue,
    chart: {
      width: '100%',
      type: 'donut',
      events: {
        dataPointSelection: (event, chartContext, config) => {
          console.log(config.w.config.series[config.dataPointIndex])
          console.log(config.w.config.labels[config.dataPointIndex])
          // do something basis on label 
        }
      },
    },
    dataLabels: {
      enabled: true,
      formatter: function (val, opts) {
        return val.toFixed(2) + "%"
        // return opts.w.config.series[opts.seriesIndex]
      },
    },
    // labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
    labels: scrapValuationLable,
    // colors: ['black', '#E91E63', '#9C27B0'],
    colors: scrapValuationColor,


    legend: {
      position: 'bottom'
    },
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: '100%'
        },
      }
    }]
  };

  var chart = new ApexCharts(_("#scrapValuationChart"), options);
  chart.render();
}

function makeCollectorPurchasedChart() {
  var options = {
    series: [
      {
        name: "Collector Purchased Value",
        // data: [28, 29, 33, 36, 32, 32, 33]
        data: collectorPurchasedValue
      },
    ],
    chart: {
      height: 350,
      type: 'line',
      dropShadow: {
        enabled: true,
        color: '#000',
        top: 18,
        left: 7,
        blur: 10,
        opacity: 0.2
      },
      zoom: {
        enabled: true
      },
      toolbar: {
        show: true
      }
    },
    colors: ['#77B6EA'],
    dataLabels: {
      enabled: true,
    },
    stroke: {
      curve: 'smooth'
    },
    // title: {
    //   text: 'Average High & Low Temperature',
    //   align: 'left'
    // },
    grid: {
      borderColor: '#e7e7e7',
      row: {
        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
        opacity: 0.5
      },
    },
    markers: {
      size: 1
    },
    xaxis: {
      // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
      categories: collectorPurchasedLable,
      title: {
        text: 'Collectors'
      }
    },
    yaxis: {
      title: {
        text: 'Amount'
      },
      min: collectorMinAmountValue,
      max: collectorMaxAmountValue
    },
    legend: {
      position: 'top',
      horizontalAlign: 'right',
      floating: true,
      offsetY: -25,
      offsetX: -5
    }
  };

  var chart = new ApexCharts(document.querySelector("#collectorPurchasedChart"), options);
  chart.render();
}

function makeBuyerEarningDromSalesChart() {
  var options = {
    series: [{
      name: "sales",
      data: buyerEarningsData
    }],
    chart: {
      type: 'bar',
      height: 380
    },
    xaxis: {
      type: 'category',
      labels: {
        formatter: function (val) {
          return val
        }
      },
    },

    tooltip: {
      x: {
        formatter: function (val) {
          return val
        }
      }
    },
  };

  var chart = new ApexCharts(document.querySelector("#buyerEarningSalesChart"), options);
  chart.render();
}

// for seller chart
function makeSellerItemListingPieChart() {
  var options = {
    // series: [44, 55, 13, 43, 22],
    series: sellerItemListingValue,
    chart: {
      width: '100%',
      type: 'pie',
    },
    // labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
    labels: sellerItemListingLable,
    // colors: ['black', '#E91E63', '#9C27B0'],
    colors: sellerItemListingColor,
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val.toFixed(2) + "%"
      },
    },
    legend: {
      position: 'bottom'
    },
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: '100%'
        },
      }
    }]
  };

  var chart = new ApexCharts(_("#sellerItemListingChart"), options);
  chart.render();
}

function makeSellerScrapValuationChart() {
  var options = {
    series: [{
      name: "Scrap Valuation",
      data: sellerScrapValuationValue
    }],
    chart: {
      height: 350,
      type: 'bar',
      events: {
        click: function (chart, w, e) {
          // console.log(chart, w, e)
        }
      }
    },
    colors: ['#145F82', '#E87331', '#186C24'],
    plotOptions: {
      bar: {
        // columnWidth: '45%',
        distributed: true,
      }
    },
    dataLabels: {
      enabled: true
    },
    legend: {
      show: false
    },
    tooltip: {
      x: {
        formatter: function (val) {
          return val
        }
      }
    },
    xaxis: {
      categories: sellerScrapValuationLabel,
      labels: {
        style: {
          colors: ['#145F82', '#E87331', '#186C24'],
          fontSize: '12px'
        }
      }
    }
  };

  var chart = new ApexCharts(document.querySelector("#sellerScrapValuationChart"), options);
  chart.render();
}
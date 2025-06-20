
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
    series: itemListingValue,
    chart: {
      width: '100%',
      type: 'pie',
    },
    labels: itemListingLable,
    colors: itemListingColor, // Dynamically assigned colors
    dataLabels: {
      enabled: true,
      formatter: function (val, opts) {
        return opts.w.globals.series[opts.seriesIndex] + " (" + val.toFixed(2) + "%)";
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

  var chart = new ApexCharts(document.querySelector("#itemListingChart"), options);
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

// function makeCollectorPurchasedChart() {
//   var options = {
//     series: [
//       {
//         name: "Collector Purchased Value",
//         // data: [28, 29, 33, 36, 32, 32, 33]
//         data: collectorPurchasedValue
//       },
//     ],
//     chart: {
//       height: 350,
//       type: 'line',
//       dropShadow: {
//         enabled: true,
//         color: '#000',
//         top: 18,
//         left: 7,
//         blur: 10,
//         opacity: 0.2
//       },
//       zoom: {
//         enabled: true
//       },
//       toolbar: {
//         show: true
//       }
//     },
//     colors: ['#77B6EA'],
//     dataLabels: {
//       enabled: true,
//     },
//     stroke: {
//       curve: 'smooth'
//     },
//     // title: {
//     //   text: 'Average High & Low Temperature',
//     //   align: 'left'
//     // },
//     grid: {
//       borderColor: '#e7e7e7',
//       row: {
//         colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
//         opacity: 0.5
//       },
//     },
//     markers: {
//       size: 1
//     },
//     xaxis: {
//       // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
//       categories: collectorPurchasedLable,
//       title: {
//         text: 'Collectors'
//       }
//     },
//     yaxis: {
//       title: {
//         text: 'Amount'
//       },
//       min: collectorMinAmountValue,
//       max: collectorMaxAmountValue
//     },
//     legend: {
//       position: 'top',
//       horizontalAlign: 'right',
//       floating: true,
//       offsetY: -25,
//       offsetX: -5
//     }
//   };

//   var chart = new ApexCharts(document.querySelector("#collectorPurchasedChart"), options);
//   chart.render();
// }

// function makeCollectorPurchasedChart() {
//     // Check if data is present and valid
//     if (
//         !collectorPurchasedValue ||
//         collectorPurchasedValue.length === 0 ||
//         collectorPurchasedValue.every(val => val === 0)
//     ) {
//         console.warn("No valid data to display in collectorPurchasedChart.");
//         return;
//     }

//     // Calculate dynamic Y-axis max value with safe padding
//     const dynamicMax = collectorMaxAmountValue > 0 ? collectorMaxAmountValue * 1.2 : 1000;

//     var options = {
//         series: [{
//             name: "Collector Purchased Value",
//             data: collectorPurchasedValue
//         }],
//         chart: {
//             height: 350,
//             type: 'line',
//             dropShadow: {
//                 enabled: true,
//                 color: '#000',
//                 top: 18,
//                 left: 7,
//                 blur: 10,
//                 opacity: 0.2
//             },
//             zoom: {
//                 enabled: true
//             },
//             toolbar: {
//                 show: true
//             }
//         },
//         colors: ['#77B6EA'],
//         dataLabels: {
//             enabled: true,
//             formatter: function (val) {
//                 return "₹" + val.toLocaleString();
//             }
//         },
//         stroke: {
//             curve: 'smooth'
//         },
//         grid: {
//             borderColor: '#e7e7e7',
//             row: {
//                 colors: ['#f3f3f3', 'transparent'],
//                 opacity: 0.5
//             }
//         },
//         markers: {
//             size: 4
//         },
//         xaxis: {
//             categories: collectorPurchasedLable,
//             title: {
//                 text: 'Collectors'
//             }
//         },
//         yaxis: {
//             title: {
//                 text: 'Total Purchased (₹)'
//             },
//             min: 0,
//             max: dynamicMax
//         },
//         tooltip: {
//             y: {
//                 formatter: function (val) {
//                     return "₹" + val.toLocaleString();
//                 }
//             }
//         },
//         legend: {
//             position: 'top',
//             horizontalAlign: 'right',
//             floating: true,
//             offsetY: -25,
//             offsetX: -5
//         }
//     };

//     // Render the chart
//     var chart = new ApexCharts(document.querySelector("#collectorPurchasedChart"), options);
//     chart.render();
// }
function makeCollectorPurchasedChart() {
    // ✅ Check for valid data
    if (
        !collectorPurchasedValue ||
        collectorPurchasedValue.length === 0 ||
        collectorPurchasedValue.every(val => val === 0)
    ) {
        console.warn("No valid data to display in collectorPurchasedChart.");
        return;
    }

    // ✅ Dynamic max with padding
    const dynamicMax = collectorMaxAmountValue > 0 ? collectorMaxAmountValue * 1.2 : 1000;

    const options = {
        series: [{
            name: "Collector Purchased Value",
            data: collectorPurchasedValue
        }],
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: true
            }
        },
        colors: ['#845834'],
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return "₹" + formatIndianCurrency(val);
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '25%',
                endingShape: 'rounded'
            }
        },
        xaxis: {
            categories: collectorPurchasedLable,
            title: {
                text: 'Collectors'
            }
        },
        yaxis: {
            title: {
                text: 'Total Purchased (₹)'
            },
            min: 0,
            max: dynamicMax,
            tickAmount: 4,
            labels: {
                formatter: function (val) {
                    return "₹" + formatIndianCurrency(val);
                }
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "₹" + formatIndianCurrency(val);
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -25,
            offsetX: -5
        }
    };

    // ✅ Render chart
    const chart = new ApexCharts(document.querySelector("#collectorPurchasedChart"), options);
    chart.render();
}

// ✅ Helper to format Indian currency (e.g. 1,42,200)
function formatIndianCurrency(value) {
    return Math.round(value).toString().replace(/\B(?=(\d{2})+(?!\d))/g, ",");
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
    colors: ['#B17F4A'],
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

// for seller chart------------------------------------------------
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

// function makeSellerScrapValuationChart() {
//     // Prevent rendering if all values are zero
//     const nonZeroCount = sellerScrapValuationValue.filter(val => val > 0).length;
//     if (nonZeroCount === 0) {
//         document.getElementById("sellerScrapValuationChart").innerHTML = "<p style='color:red; text-align:center;'>No Data Found</p>";
//         return;
//     }

//     const adjustedValues = sellerScrapValuationValue;

//     var options = {
//         series: [{
//             name: "Scrap Valuation",
//             data: adjustedValues
//         }],
//         chart: {
//             height: 350,
//             type: 'bar',
//         },
//         colors: sellerScrapValuationColor,
//         plotOptions: {
//             bar: {
//                 columnWidth: '50%',
//                 barHeight: '100%',
//                 distributed: true,
//             }
//         },
//         dataLabels: {
//             enabled: true,
//             formatter: function (val) {
//                 return val.toFixed(0); // Show whole numbers
//             }
//         },
//         legend: {
//             show: false
//         },
//         tooltip: {
//             x: {
//                 formatter: function (val) {
//                     return val;
//                 }
//             }
//         },
//         xaxis: {
//             categories: sellerScrapValuationLabel,
//             labels: {
//                 style: {
//                     colors: sellerScrapValuationColor,
//                     fontSize: '12px'
//                 }
//             }
//         },
//         yaxis: {
//             min: 0,
//             max: Math.max(...adjustedValues) * 1.2,
//         }
//     };

//     var chart = new ApexCharts(document.querySelector("#sellerScrapValuationChart"), options);
//     chart.render();
// }
function makeSellerScrapValuationChart() {

    const nonZeroCount = sellerScrapValuationValue.filter(val => val > 0).length;
    if (nonZeroCount === 0) {
        document.getElementById("sellerScrapValuationChart").innerHTML = "<p style='color:red; text-align:center;'>No Data Found</p>";
        return;
    }

    const adjustedValues = sellerScrapValuationValue;

    var options = {
        series: [{
            name: "Scrap Valuation",
            data: adjustedValues
        }],
        chart: {
            height: 350,
            type: 'bar',
        },
        colors: sellerScrapValuationColor,
        plotOptions: {
            bar: {
                columnWidth: '50%',
                barHeight: '100%',
                distributed: true,
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return '₹' + val.toFixed(0); // Add ₹ before number
            }
        },
        legend: {
            show: false
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return '₹' + val.toFixed(0);
                }
            }
        },
        xaxis: {
            categories: sellerScrapValuationLabel,
            labels: {
                style: {
                    colors: sellerScrapValuationColor,
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            min: 0,
            max: Math.max(...adjustedValues) * 1.2,
        }
    };

    var chart = new ApexCharts(document.querySelector("#sellerScrapValuationChart"), options);
    chart.render();
}



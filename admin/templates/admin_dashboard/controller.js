$(document).ready(function () {
  make_select2_ajx("state");
  make_select2_ajx("city");
  make_select2_ajx("pincode");

  make_select2_ajx("transaction_count_state");
  make_select2_ajx("transaction_count_city");
  make_select2_ajx("transaction_count_pincode");

  make_select2_ajx("credit_history_state");
  make_select2_ajx("credit_history_city");
  make_select2_ajx("credit_history_pincode");

  makeSellerBuyerCountChart();
  getBuyerSellerCountDetails();

  makeTransactionCountChart();
  makeTransactionCountPieChart();
  makeTransactionValuationChart();
  makeTransactionValuationPieChart();
  getTransactionCountDetails();

  makeCreditHistoryChart();
  getCreditHistoryData();

  makePostStatusCountChart();
  getPostStatusCountDetails();

  makeTransactionStatusCountChart();
  getTransactionStatusCountDetails();
});

function make_select2_ajx(id) {
  let fileName, sendData;
  switch (id) {
    case "state":
    case "transaction_count_state":
    case "credit_history_state":
      fileName = "select_state_list";
      break;

    case "city":
      fileName = "select_city_list";
      sendData = {
        state: _("#state").value,
      };
      break;
    case "transaction_count_city":
      fileName = "select_city_list";
      sendData = {
        state: _("#transaction_count_state").value,
      };
      break;
    case "credit_history_city":
      fileName = "select_city_list";
      sendData = {
        state: _("#credit_history_state").value,
      };
      break;

    case "pincode":
      fileName = "select_pincode_list";
      sendData = {
        state: _("#state").value,
        city: _("#city").value,
      };
      break;
    case "transaction_count_pincode":
      fileName = "select_pincode_list";
      sendData = {
        state: _("#transaction_count_state").value,
        city: _("#transaction_count_city").value,
      };
      break;
    case "credit_history_pincode":
      fileName = "select_pincode_list";
      sendData = {
        state: _("#credit_history_state").value,
        city: _("#credit_history_city").value,
      };
      break;

    // case 'transaction_count_city':
    //     fileName = 'select_single_city_list';
    //     break;
  }

  $("#" + id).select2({
    minimumInputLength: 0,
    allowClear: true,
    width: "100%",
    ajax: {
      url: "templates/dashboard/" + fileName + ".php",
      dataType: "json",
      type: "post",
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term, // search term
          sendData: JSON.stringify(sendData),
        };
      },
      processResults: function (response) {
        return {
          results: response,
        };
      },
      cache: true,
    },
  });
}

////////////////////////////////////////////////////////////////////////////
//////////////////////// Seller & Buyer Count Chart ////////////////////////
////////////////////////////////////////////////////////////////////////////

var sellerBuyerCountChart;

function makeSellerBuyerCountChart() {
  var options = {
    series: [
      {
        name: "User Data",
        data: [0],
      },
    ],
    chart: {
      type: "bar",
      height: 350,
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "55%",
        endingShape: "rounded",
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 2,
      colors: ["transparent"],
    },
    xaxis: {
      categories: ["X-Axis Data"],
    },
    yaxis: {
      title: {
        text: "User Count",
      },
    },
    fill: {
      opacity: 1,
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return " " + val + " users";
        },
      },
    },
  };

  sellerBuyerCountChart = new ApexCharts(
    document.querySelector(".sellerBuyerCountChart"),
    options
  );
  sellerBuyerCountChart.render();
}

function getBuyerSellerCountDetails() {
  _(".background_overlay").style.display = "block";

  let data = new FormData();
  const sendData = {
    state: _("#state").value,
    city: _("#city").value,
    pincode: _("#pincode").value,
    from_date: $("#from_date").val(),
    to_date: $("#to_date").val(),
  };
  data.append("sendData", JSON.stringify(sendData));
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);

        let buyerData = [];
        let sellerData = [];
        let dataName = [];

        let thead = "<tr><th></th>";
        let tbodyBuyer = "<tr><th>Buyer</th>";
        let tbodySeller = "<tr><th>Seller</th>";

        for (let index = 0; index < response.length; index++) {
          buyerData.push(response[index]["buyer_count"]);
          sellerData.push(response[index]["seller_count"]);
          dataName.push(response[index]["data"]);

          thead += "<th>" + response[index]["data"] + "</th>";
          tbodyBuyer += "<td>" + response[index]["buyer_count"] + "</td>";
          tbodySeller += "<td>" + response[index]["seller_count"] + "</td>";
        }

        thead += "</tr>";
        tbodyBuyer += "</tr>";
        tbodySeller += "</tr>";

        _(".sellerBuyerCountTable").innerHTML =
          thead + tbodyBuyer + tbodySeller;

        // PREVIOUS FUNCTION RENDERING  BY APEXCHART
        // sellerBuyerCountChart.updateOptions({
        //   series: [
        //     {
        //       name: "Buyer",
        //       data: buyerData,
        //     },
        //     {
        //       name: "Seller",
        //       data: sellerData,
        //     },
        //   ],
        //   xaxis: {
        //     categories: dataName,
        //   },
        // });

        // LATEST FUNCTION RENDERING BY APEXCHART
        sellerBuyerCountChart.updateSeries([
          {
            name: "Buyer",
            data: buyerData,
          },
          {
            name: "Seller",
            data: sellerData,
          },
        ]);

        _(".background_overlay").style.display = "none";
      } else {
        toastr["error"]("Failed to retrieve data!", "ERROR!!");
        _(".background_overlay").style.display = "none";
      }
    }
  };
  xhr.open(
    "POST",
    "templates/dashboard/get_seller_buyer_count_details.php",
    true
  );
  xhr.send(data);
}

////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////// State, city, pincode wise Trans Count & Valuation ////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

var transactionCountChart;
function makeTransactionCountChart() {
  var colors = [
    "#008FFB",
    "#00E396",
    "#FEB019",
    "#FF4560",
    "#775DD0",
    "#546E7A",
    "#26a69a",
    "#D10CE8",
    "#00E396",
    "#FEB019",
    "#FF4560",
    "#775DD0",
    "#546E7A",
    "#26a69a",
    "#D10CE8",
  ];

  var options = {
    series: [
      {
        name: "Count Data",
        data: [0],
      },
    ],
    chart: {
      height: 350,
      type: "bar",
      events: {
        click: function (chart, w, e) {
          // console.log(chart, w, e)
        },
      },
    },
    colors: colors,
    plotOptions: {
      bar: {
        columnWidth: "45%",
        distributed: true,
      },
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    yaxis: {
      title: {
        text: "Transaction Count",
      },
    },
    xaxis: {
      categories: ["At First Choose State"],
      labels: {
        style: {
          colors: colors,
          fontSize: "12px",
        },
      },
    },
  };

  transactionCountChart = new ApexCharts(
    document.querySelector(".transactionCountChart"),
    options
  );
  transactionCountChart.render();
}

var transactionCountPieChart;
function makeTransactionCountPieChart() {
  var options = {
    series: [0],
    chart: {
      width: "100%",
      type: "pie",
      toolbar: {
        show: true,
        offsetX: 0,
        offsetY: 0,
        tools: {
          download: true,
          selection: true,
          zoom: true,
          zoomin: true,
          zoomout: true,
          pan: true,
          reset: true | '<img src="/static/icons/reset.png" width="20">',
          customIcons: [],
        },
        export: {
          csv: {
            filename: undefined,
            columnDelimiter: ",",
            headerCategory: "category",
            headerValue: "value",
            categoryFormatter(x) {
              return x;
            },
            valueFormatter(y) {
              return y;
            },
          },
          svg: {
            filename: undefined,
          },
          png: {
            filename: undefined,
          },
        },
        autoSelected: "zoom",
      },
    },
    labels: [
      "Metals",
      "Books",
      "Cardboard",
      "Newspapers",
      "Glass",
      "Plastic",
      "E waste",
      "Furniture",
      "Batteries",
      "Utensils",
    ],
    colors: [
      "#008FFB",
      "#00E396",
      "#FEB019",
      "#FF4560",
      "#775DD0",
      "#546E7A",
      "#26a69a",
      "#D10CE8",
      "#00E396",
      "#FEB019",
      "#FF4560",
      "#775DD0",
      "#546E7A",
      "#26a69a",
      "#D10CE8",
    ],
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val.toFixed(2) + "%";
      },
    },
    legend: {
      position: "bottom",
    },
    responsive: [
      {
        // breakpoint: 480,
        options: {
          chart: {
            width: "100%",
          },
        },
      },
    ],
  };

  transactionCountPieChart = new ApexCharts(
    _(".transactionCountPieChart"),
    options
  );
  transactionCountPieChart.render();
}

var transactionValuationChart;
function makeTransactionValuationChart() {
  var colors = [
    "#008FFB",
    "#00E396",
    "#FEB019",
    "#FF4560",
    "#775DD0",
    "#546E7A",
    "#26a69a",
    "#D10CE8",
    "#00E396",
    "#FEB019",
    "#FF4560",
    "#775DD0",
    "#546E7A",
    "#26a69a",
    "#D10CE8",
  ];

  var options = {
    series: [
      {
        name: "Valuation Data",
        data: [0],
      },
    ],
    chart: {
      height: 350,
      type: "bar",
      events: {
        click: function (chart, w, e) {
          // console.log(chart, w, e)
        },
      },
    },
    colors: colors,
    plotOptions: {
      bar: {
        columnWidth: "45%",
        distributed: true,
      },
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    yaxis: {
      title: {
        text: "Transaction Valuation",
      },
    },
    xaxis: {
      categories: ["At First Choose State"],
      labels: {
        style: {
          colors: colors,
          fontSize: "12px",
        },
      },
    },
  };

  transactionValuationChart = new ApexCharts(
    document.querySelector(".transactionValuationChart"),
    options
  );
  transactionValuationChart.render();
}

var transactionValuationPieChart;
function makeTransactionValuationPieChart() {
  var options = {
    series: [0],
    chart: {
      width: "100%",
      type: "pie",
      toolbar: {
        show: true,
        offsetX: 0,
        offsetY: 0,
        tools: {
          download: true,
          selection: true,
          zoom: true,
          zoomin: true,
          zoomout: true,
          pan: true,
          reset: true | '<img src="/static/icons/reset.png" width="20">',
          customIcons: [],
        },
        export: {
          csv: {
            filename: undefined,
            columnDelimiter: ",",
            headerCategory: "category",
            headerValue: "value",
            categoryFormatter(x) {
              return x;
            },
            valueFormatter(y) {
              return y;
            },
          },
          svg: {
            filename: undefined,
          },
          png: {
            filename: undefined,
          },
        },
        autoSelected: "zoom",
      },
    },
    labels: [
      "Metals",
      "Books",
      "Cardboard",
      "Newspapers",
      "Glass",
      "Plastic",
      "E waste",
      "Furniture",
      "Batteries",
      "Utensils",
    ],
    colors: [
      "#008FFB",
      "#00E396",
      "#FEB019",
      "#FF4560",
      "#775DD0",
      "#546E7A",
      "#26a69a",
      "#D10CE8",
      "#00E396",
      "#FEB019",
      "#FF4560",
      "#775DD0",
      "#546E7A",
      "#26a69a",
      "#D10CE8",
    ],
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val.toFixed(2) + "%";
      },
    },
    legend: {
      position: "bottom",
    },
    responsive: [
      {
        // breakpoint: 480,
        options: {
          chart: {
            width: "100%",
          },
        },
      },
    ],
  };

  transactionValuationPieChart = new ApexCharts(
    _(".transactionValuationPieChart"),
    options
  );
  transactionValuationPieChart.render();
}

function getTransactionCountDetails() {
  _(".background_overlay").style.display = "block";

  let data = new FormData();
  const sendData = {
    state: _("#transaction_count_state").value,
    city: _("#transaction_count_city").value,
    pincode: _("#transaction_count_pincode").value,
    from_date: $("#from_date_trans").val(),
    to_date: $("#to_date_trans").val(),
  };
  data.append("sendData", JSON.stringify(sendData));
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);

        let transactionCountData = [];
        let transactionValuationData = [];
        let categoriesData = [];
        let thead = "<tr>";
        let countTbody = "<tr>";
        let valuationTbody = "<tr>";

        for (let index = 0; index < response.length; index++) {
          transactionCountData.push(Number(response[index]["trans_count"]));
          transactionValuationData.push(
            Number(response[index]["trans_valuation"])
          );
          categoriesData.push(response[index]["category_name"]);

          let transactionValuation =
            response[index]["trans_valuation"] == null
              ? 0
              : response[index]["trans_valuation"];
          let transactionCount =
            response[index]["trans_count"] == null
              ? 0
              : response[index]["trans_count"];

          thead += "<th>" + response[index]["category_name"] + "</th>";
          valuationTbody += "<td>" + transactionValuation + "</td>";
          countTbody += "<td>" + transactionCount + "</td>";
        }

        thead += "</tr>";
        countTbody += "</tr>";
        valuationTbody += "</tr>";

        _(".transactionCountTable").innerHTML = thead + countTbody;
        _(".transactionValuationTable").innerHTML = thead + valuationTbody;

        // PERIVOUS FUNCTION TO RENDER APEXCHART
        // transactionCountChart.updateOptions({
        //   series: [
        //     {
        //       data: transactionCountData,
        //     },
        //   ],
        //   xaxis: {
        //     categories: categoriesData,
        //   },
        // });

        // transactionCountPieChart.updateOptions({
        //   series: transactionCountData,
        //   labels: categoriesData,
        // });

        // transactionValuationChart.updateOptions({
        //   series: [
        //     {
        //       data: transactionValuationData,
        //     },
        //   ],
        //   xaxis: {
        //     categories: categoriesData,
        //   },
        // });
        // transactionValuationPieChart.updateOptions({
        //   series: transactionValuationData,
        //   labels: categoriesData,
        // });

        // LATEST FUNCTION TO RENDER APEXCHART
        transactionCountChart.updateSeries([
          {
            data: transactionCountData,
          },
        ]);

        transactionCountPieChart.updateSeries(
          transactionCountData,
          categoriesData
        );

        transactionValuationChart.updateSeries([
          {
            data: transactionValuationData,
          },
        ]);

        transactionValuationPieChart.updateSeries(
          transactionValuationData,
          categoriesData
        );

        _(".background_overlay").style.display = "none";
      } else {
        toastr["error"]("Failed to retrieve data!", "ERROR!!");
        _(".background_overlay").style.display = "none";
      }
    }
  };
  xhr.open("POST", "templates/dashboard/get_trans_count_details.php", true);
  xhr.send(data);
}

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////// Credit History Data & Chart ////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

var creditHistoryChart;

function makeCreditHistoryChart() {
  var options = {
    series: [
      {
        name: "Months Data",
        data: [0],
      },
    ],
    chart: {
      type: "bar",
      height: 350,
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "55%",
        endingShape: "rounded",
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 2,
      colors: ["transparent"],
    },
    xaxis: {
      categories: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
    },
    yaxis: {
      title: {
        text: "Credits",
      },
    },
    fill: {
      opacity: 1,
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return " " + val + " Credits";
        },
      },
    },
  };

  creditHistoryChart = new ApexCharts(
    document.querySelector(".creditHistoryChart"),
    options
  );
  creditHistoryChart.render();
}

function getCreditHistoryData() {
  _(".background_overlay").style.display = "block";

  let data = new FormData();
  const sendData = {
    filter_year: _("#credit_history_filter_year").value,
    state: _("#credit_history_state").value,
    city: _("#credit_history_city").value,
    pincode: _("#credit_history_pincode").value,
    from_date: $("#from_date_credit").val(),
    to_date: $("#to_date_credit").val(),
  };
  data.append("sendData", JSON.stringify(sendData));
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);

        let purchasedCredits = [];
        let usedCredits = [];

        for (let index = 0; index < response.length; index++) {
          purchasedCredits.push(response[index]["in_credit"]);
          usedCredits.push(response[index]["out_credit"]);
        }

        // PREVIOUS FUNCTION TO RENDER APEXCHART
        // creditHistoryChart.updateOptions({
        //   series: [
        //     {
        //       name: "Purchased Credit",
        //       data: purchasedCredits,
        //     },
        //     {
        //       name: "Used Credits",
        //       data: usedCredits,
        //     },
        //   ],
        // });

        // LATEST FUNCTION TO RENDER APEXCHART
        creditHistoryChart.updateSeries([
          {
            name: "Purchased Credit",
            data: purchasedCredits,
          },
          {
            name: "Used Credits",
            data: usedCredits,
          },
        ]);

        _(".background_overlay").style.display = "none";
      } else {
        toastr["error"]("Failed to retrieve data!", "ERROR!!");
        _(".background_overlay").style.display = "none";
      }
    }
  };
  xhr.open("POST", "templates/dashboard/get_credit_history_data.php", true);
  xhr.send(data);
}

////////////////////////////////////////////////////////////////////////////////////
//////////////////////// status wise post count & bar graph ////////////////////////
////////////////////////////////////////////////////////////////////////////////////

var postStatusCountChart;
function makePostStatusCountChart() {
  var colors = [
    "#008FFB",
    "#00E396",
    "#FEB019",
    "#FF4560",
    "#775DD0",
    "#546E7A",
  ];

  var options = {
    series: [
      {
        name: "Status Count Data",
        data: [0],
      },
    ],
    chart: {
      height: 350,
      type: "bar",
    },
    colors: colors,
    plotOptions: {
      bar: {
        columnWidth: "15%",
        distributed: true,
      },
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    yaxis: {
      title: {
        text: "Post Status Count",
      },
    },
    xaxis: {
      categories: [
        "Active",
        "Post Viewed",
        "Under Negotiation",
        "Offer Accepted",
        "Pickup Scheduled",
        "Completed",
      ],
      labels: {
        style: {
          colors: colors,
          fontSize: "12px",
        },
      },
    },
  };

  postStatusCountChart = new ApexCharts(
    document.querySelector(".postStatusCountChart"),
    options
  );
  postStatusCountChart.render();
}

function getPostStatusCountDetails() {
  _(".background_overlay").style.display = "block";

  let data = new FormData();
  const sendData = {
    from_date: $("#from_date_post_status").val(),
    to_date: $("#to_date_post_status").val(),
  };
  data.append("sendData", JSON.stringify(sendData));

  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);

        let postCountData = [];
        let statusData = [];
        let thead = "<tr>";
        let countTbody = "<tr>";

        for (let index = 0; index < response.length; index++) {
          statusData.push(response[index]["product_status"]);
          postCountData.push(response[index]["product_count"]);

          thead += "<th>" + response[index]["product_status"] + "</th>";
          countTbody += "<td>" + response[index]["product_count"] + "</td>";
        }

        thead += "</tr>";
        countTbody += "</tr>";

        _(".postStatusCountTable").innerHTML = thead + countTbody;

        // PREVIOUS FUNCTION TO RENDER APEXCHART
        // postStatusCountChart.updateOptions({
        //   series: [
        //     {
        //       data: postCountData,
        //     },
        //   ],
        //   xaxis: {
        //     categories: statusData,
        //   },
        // });

        // LATEST FUNCTION TO RENDER APEXCHART
        postStatusCountChart.updateSeries([
          {
            data: postCountData,
          },
        ]);

        _(".background_overlay").style.display = "none";
      } else {
        toastr["error"]("Failed to retrieve data!", "ERROR!!");
        _(".background_overlay").style.display = "none";
      }
    }
  };
  xhr.open(
    "POST",
    "templates/dashboard/get_post_status_count_details.php",
    true
  );
  xhr.send(data);
}

////////////////////////////////////////////////////////////////////////////////////
//////////////////////// transaction status wise product count & bar graph ////////////////////////
////////////////////////////////////////////////////////////////////////////////////

var transactionStatusCountChart;
function makeTransactionStatusCountChart() {
  var colors = [
    "#008FFB",
    "#FEB019",
    "#775DD0",
    "#546E7A",
    "#FF4560",
    "#00E396",
  ];

  var options = {
    series: [
      {
        name: "Transaction Status Count Data",
        data: [0],
      },
    ],
    chart: {
      height: 350,
      type: "bar",
    },
    colors: colors,
    plotOptions: {
      bar: {
        columnWidth: "45%",
        distributed: true,
      },
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    yaxis: {
      title: {
        text: "Transaction Status Count",
      },
    },
    xaxis: {
      categories: [
        "Credit Used",
        "Under Negotiation",
        "Offer Accepted",
        "Pickup Scheduled",
        "Offer Rejected",
        "Completed",
      ],
      labels: {
        style: {
          colors: colors,
          fontSize: "12px",
        },
      },
    },
  };

  transactionStatusCountChart = new ApexCharts(
    document.querySelector(".transactionStatusCountChart"),
    options
  );
  transactionStatusCountChart.render();
}

function getTransactionStatusCountDetails() {
  _(".background_overlay").style.display = "block";

  let data = new FormData();
  const sendData = {
    from_date: $("#from_date_transaction_status").val(),
    to_date: $("#to_date_transaction_status").val(),
  };
  data.append("sendData", JSON.stringify(sendData));

  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);

        let transactionCountData = [];
        let transactionStatusData = [];
        let thead = "<tr>";
        let countTbody = "<tr>";

        for (let index = 0; index < response.length; index++) {
          transactionStatusData.push(response[index]["deal_status"]);
          transactionCountData.push(
            response[index]["product_transaction_count"]
          );

          thead += "<th>" + response[index]["deal_status"] + "</th>";
          countTbody +=
            "<td>" + response[index]["product_transaction_count"] + "</td>";
        }

        thead += "</tr>";
        countTbody += "</tr>";

        _(".transactionStatusCountTable").innerHTML = thead + countTbody;

        transactionStatusCountChart.updateOptions({
          series: [
            {
              data: transactionCountData,
            },
          ],
          xaxis: {
            categories: transactionStatusData,
          },
        });

        _(".background_overlay").style.display = "none";
      } else {
        toastr["error"]("Failed to retrieve data!", "ERROR!!");
        _(".background_overlay").style.display = "none";
      }
    }
  };
  xhr.open(
    "POST",
    "templates/dashboard/get_transaction_status_count_details.php",
    true
  );
  xhr.send(data);
}

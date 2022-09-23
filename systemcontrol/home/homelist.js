var highColors = [bgPrimary, bgWarning, bgInfo, bgAlert,bgDanger, bgSuccess, bgSystem, bgDark];
$(document).ready(function() {
  $('#daterangepicker1').daterangepicker({
    timePicker: false,
    locale: {
      format: 'DD/MM/YYYY'
    }
  });
  var InShowData = $('#FrmOnDashboard input[name=InShowData]').val();
  // alert(InShowData);
  $('ul.nav-tabs li:first-child > a').click();
  // loadgraph();
  // if(InShowData){
    main();
    loadpageajax(1);
  // }
});
function submitDate(t){
  main();
  return false;
}
function loadpageajax(page){
  var listResult = $('#listResult');
	var json = (function () {
    var LoginData = $('#ajaxFrm #LoginData').val();
		var json = null;
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:page,LoginData:LoginData},
			'url': 'ajax-loadpageproduct-json.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    $('.ajax-loader').css("visibility", "hidden");
		  }
		});
		return json;
	})();
	var len = json['result'].length;
  var html = '';
  html +='<thead>';
    html +='<tr>';
      html +='<th class="w175">เมนู</th>';
			// html +='<th class="w225">Group</th>';
      html +='<th class="w175">Update</th>';
			html +='<th class="">Subject</th>';
    html +='</tr>';
  html +='</thead>';
  html +='<tbody>';
	if(len>0){
		for (var i = 0; i< len; i++) {
			html +='<tr>';
        html +='<td>';
            html +='<span>'+json['result'][i].ListKey+'</span>';
        html +='</td>';
				// html +='<td>';
				//     html +='<span>'+json['result'][i].GroupName+'</span>';
			  // html +='</td>';
        html +='<td>';
				    html +='<span>'+json['result'][i].Dateshow+'</span>';
			  html +='</td>';
				html +='<td>';
				    html +='<span>'+json['result'][i].Subject+'</span>';
			  html +='</td>';
			html +='</tr>';
		}
	}
  html +='</tbody>';

	listResult.find("table").html(html);
}
function loadgraph(){
  var homerang = $('#FrmOnDashboard input[name=daterange]').val();
  var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:1,homerang:homerang},
			'url': 'ajax-loadcountall.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    $('.ajax-loader').css("visibility", "hidden");
		  }
		});
		return json;
	})();

	var countregister = json["dataRegister"];
	var dataRegisterCategories = json["dataRegisterCat"];
  var dataRegisterSelect = json["dataRegisterSelect"];
  $('.showDateText').html(dataRegisterSelect);
	var registercount = json["dataregistercountformat"];
	$('.RegisterTotal').html(registercount);
	var dataregistertext = json["dataregistertext"];
	$('.RegisterTotalText').html(dataregistertext);

  var registercount = json["dataSum01Format"];
  $('.Sum01').html(registercount);
  var registercount = json["dataSum02Format"];
	$('.Sum02').html(registercount);
  var registercount = json["dataSum03Format"];
	$('.Sum03').html(registercount);

  var countlevel = new Array();
	countlevel.push(['Company '+json["dataSum01Format"]+' คน',parseInt(json["dataSum01"])]);
	countlevel.push(['Restaurant '+json["dataSum02Format"]+' คน',parseInt(json["dataSum02"])]);
	countlevel.push(['Visitor '+json["dataSum03Format"]+' คน',parseInt(json["dataSum03"])]);

  var countlevelFix = new Array();
	countlevelFix.push(['Company '+json["dataSum01FixFormat"]+' คน',parseInt(json["dataSum01Fix"])]);
	countlevelFix.push(['Restaurant '+json["dataSum02FixFormat"]+' คน',parseInt(json["dataSum02Fix"])]);
	countlevelFix.push(['Visitor '+json["dataSum03FixFormat"]+' คน',parseInt(json["dataSum03Fix"])]);

  var line1 = $('#high-lineregister');
  var pie1 = $('#high-pie-Level');
  var pie2 = $('#high-pie-LevelFix');
  if (line1.length) {
      // High Line 3
      line1.highcharts({
          credits: false,
          colors: highColors,
          chart: {
              backgroundColor: '#f9f9f9',
              className: 'br-r',
              type: 'line',
              zoomType: 'x',
              panning: true,
              panKey: 'shift',
              marginTop: 25,
              marginRight: 1,
          },
          title: {
              text: null
          },
          xAxis: {
              gridLineColor: '#EEE',
              lineColor: '#EEE',
              tickColor: '#EEE',
              categories: dataRegisterCategories
          },
          yAxis: {
              min: 0,
              tickInterval: 5,
              gridLineColor: '#EEE',
              title: {
                  text: null,
              }
          },
          plotOptions: {
              spline: {
                  lineWidth: 3,
              },
              area: {
                  fillOpacity: 0.2
              }
          },
          legend: {
              enabled: false,
          },
          series: countregister
      });

  }
  if (pie1.length) {
      // Pie Chart1
      pie1.highcharts({
          credits: false,
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false
          },
          title: {
              text: null
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  center: ['30%', '50%'],
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: false
                  },
                  showInLegend: true
              }
          },
          colors: highColors,
          legend: {
              x: 150,
              floating: true,
              verticalAlign: "middle",
              layout: "vertical",
              itemMarginTop: 10
          },
          series: [{
              type: 'pie',
              name: 'Level share',
              data: countlevel
          }]
      });
  }
  if (pie2.length) {
      // Pie Chart1
      pie2.highcharts({
          credits: false,
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false
          },
          title: {
              text: null
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  center: ['30%', '50%'],
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: false
                  },
                  showInLegend: true
              }
          },
          colors: highColors,
          legend: {
              x: 150,
              floating: true,
              verticalAlign: "middle",
              layout: "vertical",
              itemMarginTop: 10
          },
          series: [{
              type: 'pie',
              name: 'Level share',
              data: countlevelFix
          }]
      });
  }
}
async function main() {
  await loadgraphMember();
  await loadgraphProduct();
  await loadgraphRestaurant();
}
function loadgraphMember(){
  var homerang = $('#FrmOnDashboard input[name=daterange]').val();
  var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:1,homerang:homerang},
			'url': 'ajax-loadcountall-member.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    $('.ajax-loader').css("visibility", "hidden");
		  }
		});
		return json;
	})();

	var countregister = json["dataRegister"];
	var dataRegisterCategories = json["dataRegisterCat"];
  var dataRegisterSelect = json["dataRegisterSelect"];
  $('.showDateText').html(dataRegisterSelect);
	var registercount = json["dataregistercountformat"];
	$('.RegisterTotal').html(registercount);
	var dataregistertext = json["dataregistertext"];
	$('.RegisterTotalText').html(dataregistertext);

  var registercount = json["dataSum01Format"];
  $('.Sum01').html(registercount);
  var registercount = json["dataSum02Format"];
	$('.Sum02').html(registercount);
  var registercount = json["dataSum03Format"];
	$('.Sum03').html(registercount);

  var countlevel = new Array();
	countlevel.push(['Company '+json["dataSum01Format"]+' คน',parseInt(json["dataSum01"])]);
	countlevel.push(['Restaurant '+json["dataSum02Format"]+' คน',parseInt(json["dataSum02"])]);
	countlevel.push(['Visitor '+json["dataSum03Format"]+' คน',parseInt(json["dataSum03"])]);

  var countlevelFix = new Array();
	countlevelFix.push(['Company '+json["dataSum01FixFormat"]+' คน',parseInt(json["dataSum01Fix"])]);
	countlevelFix.push(['Restaurant '+json["dataSum02FixFormat"]+' คน',parseInt(json["dataSum02Fix"])]);
	countlevelFix.push(['Visitor '+json["dataSum03FixFormat"]+' คน',parseInt(json["dataSum03Fix"])]);

  var line1 = $('#high-lineregister');
  var pie1 = $('#high-pie-Level');
  var pie2 = $('#high-pie-LevelFix');
  if (line1.length) {
      // High Line 3
      line1.highcharts({
          credits: false,
          colors: highColors,
          chart: {
              backgroundColor: '#f9f9f9',
              className: 'br-r',
              type: 'line',
              zoomType: 'x',
              panning: true,
              panKey: 'shift',
              marginTop: 25,
              marginRight: 1,
          },
          title: {
              text: null
          },
          xAxis: {
              gridLineColor: '#EEE',
              lineColor: '#EEE',
              tickColor: '#EEE',
              categories: dataRegisterCategories
          },
          yAxis: {
              min: 0,
              tickInterval: 5,
              gridLineColor: '#EEE',
              title: {
                  text: null,
              }
          },
          plotOptions: {
              spline: {
                  lineWidth: 3,
              },
              area: {
                  fillOpacity: 0.2
              }
          },
          legend: {
              enabled: false,
          },
          series: countregister
      });

  }
  if (pie1.length) {
      // Pie Chart1
      pie1.highcharts({
          credits: false,
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false
          },
          title: {
              text: null
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  center: ['30%', '50%'],
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: false
                  },
                  showInLegend: true
              }
          },
          colors: highColors,
          legend: {
              x: 150,
              floating: true,
              verticalAlign: "middle",
              layout: "vertical",
              itemMarginTop: 10
          },
          series: [{
              type: 'pie',
              name: 'Level share',
              data: countlevel
          }]
      });
  }
  if (pie2.length) {
      // Pie Chart1
      pie2.highcharts({
          credits: false,
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false
          },
          title: {
              text: null
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  center: ['30%', '50%'],
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: false
                  },
                  showInLegend: true
              }
          },
          colors: highColors,
          legend: {
              x: 150,
              floating: true,
              verticalAlign: "middle",
              layout: "vertical",
              itemMarginTop: 10
          },
          series: [{
              type: 'pie',
              name: 'Level share',
              data: countlevelFix
          }]
      });
  }
}
function loadgraphProduct(){
  var homerang = $('#FrmOnDashboard input[name=daterange]').val();
  var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:1,homerang:homerang},
			'url': 'ajax-loadcountall-product.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    $('.ajax-loader').css("visibility", "hidden");
		  }
		});
		return json;
	})();

	var countData = json["dataProduct"];
	var dataCategories = json["dataCat"];
  var dataSelect = json["dataSelect"];
  $('.showProductDateText').html(dataSelect);
	var productcount = json["dataproductcountformat"];
	$('.ProductTotal').html(productcount);
	var dataproducttext = json["dataproducttext"];
	$('.ProductTotalText').html(dataproducttext);

  var Sum01Format = json["dataSum01Format"];
  $('.ProductSum01').html(Sum01Format);
  var Sum02Format = json["dataSum02Format"];
	$('.ProductSum02').html(Sum02Format);
  var Sum03Format = json["dataSum03Format"];
	$('.ProductSum03').html(Sum03Format);
  var Sum04Format = json["dataSum04Format"];
	$('.ProductSum04').html(Sum04Format);

  var countlevel = new Array();
	countlevel.push(['Ready to serve '+json["dataSum01Format"]+' รายการ',parseInt(json["dataSum01"])]);
	countlevel.push(['Ready to Cook '+json["dataSum02Format"]+' รายการ',parseInt(json["dataSum02"])]);
	countlevel.push(['Dipping Sauce '+json["dataSum03Format"]+' รายการ',parseInt(json["dataSum03"])]);
  countlevel.push(['Dessert '+json["dataSum04Format"]+' รายการ',parseInt(json["dataSum04"])]);

  var countlevelFix = new Array();
	countlevelFix.push(['Ready to serve '+json["dataSum01FixFormat"]+' รายการ',parseInt(json["dataSum01Fix"])]);
	countlevelFix.push(['Ready to Cook '+json["dataSum02FixFormat"]+' รายการ',parseInt(json["dataSum02Fix"])]);
	countlevelFix.push(['Dipping Sauce '+json["dataSum03FixFormat"]+' รายการ',parseInt(json["dataSum03Fix"])]);
  countlevelFix.push(['Dessert '+json["dataSum04FixFormat"]+' คน',parseInt(json["dataSum04Fix"])]);

  var lineP = $('#high-lineproduct');
  var pieP1 = $('#high-pie-product');
  var pieP2 = $('#high-pie-productFix');
  if (lineP.length) {
      // High Line 3
      lineP.highcharts({
          credits: false,
          colors: highColors,
          chart: {
              backgroundColor: '#f9f9f9',
              className: 'br-r',
              type: 'line',
              zoomType: 'x',
              panning: true,
              panKey: 'shift',
              marginTop: 25,
              marginRight: 1,
          },
          title: {
              text: null
          },
          xAxis: {
              gridLineColor: '#EEE',
              lineColor: '#EEE',
              tickColor: '#EEE',
              categories: dataCategories
          },
          yAxis: {
              min: 0,
              tickInterval: 5,
              gridLineColor: '#EEE',
              title: {
                  text: null,
              }
          },
          plotOptions: {
              spline: {
                  lineWidth: 3,
              },
              area: {
                  fillOpacity: 0.2
              }
          },
          legend: {
              enabled: false,
          },
          series: countData
      });

  }
  if (pieP1.length) {
      // Pie Chart1
      pieP1.highcharts({
          credits: false,
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false
          },
          title: {
              text: null
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  center: ['30%', '50%'],
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: false
                  },
                  showInLegend: true
              }
          },
          colors: highColors,
          legend: {
              x: 150,
              floating: true,
              verticalAlign: "middle",
              layout: "vertical",
              itemMarginTop: 10
          },
          series: [{
              type: 'pie',
              name: 'Level share',
              data: countlevel
          }]
      });
  }
  if (pieP2.length) {
      // Pie Chart1
      pieP2.highcharts({
          credits: false,
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false
          },
          title: {
              text: null
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  center: ['30%', '50%'],
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: false
                  },
                  showInLegend: true
              }
          },
          colors: highColors,
          legend: {
              x: 150,
              floating: true,
              verticalAlign: "middle",
              layout: "vertical",
              itemMarginTop: 10
          },
          series: [{
              type: 'pie',
              name: 'Level share',
              data: countlevelFix
          }]
      });
  }
}
function loadgraphRestaurant(){
  var homerang = $('#FrmOnDashboard input[name=daterange]').val();
  var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{page:1,homerang:homerang},
			'url': 'ajax-loadcountall-restaurant.php',
			'dataType': "json",
			'success': function (data) {
				json = data;
			},
		  complete: function(){
		    $('.ajax-loader').css("visibility", "hidden");
		  }
		});
		return json;
	})();

	var countData = json["dataRestaurant"];
	var dataCategories = json["dataCat"];
  var dataSelect = json["dataSelect"];
  $('.showRestaurantDateText').html(dataSelect);
	var registercount = json["dataRestaurantcountformat"];
	$('.RestaurantTotal').html(registercount);
	var dataregistertext = json["dataRestauranttext"];
	$('.RestaurantTotalText').html(dataregistertext);

  var registercount_1 = json["dataSum01Format"];
  $('.RestaurantSum01').html(registercount_1);
  var registercount_2 = json["dataSum02Format"];
	$('.RestaurantSum02').html(registercount_2);
  var registercount_3 = json["dataSum03Format"];
	$('.RestaurantSum03').html(registercount_3);
  var registercount_4 = json["dataSum04Format"];
  $('.RestaurantSum04').html(registercount_4);

  var countlevel = new Array();
	countlevel.push(['Casual '+json["dataSum01Format"]+' รายการ',parseInt(json["dataSum01"])]);
	countlevel.push(['Classic '+json["dataSum02Format"]+' รายการ',parseInt(json["dataSum02"])]);
	countlevel.push(['Signature '+json["dataSum03Format"]+' รายการ',parseInt(json["dataSum03"])]);
  countlevel.push(['Unique '+json["dataSum04Format"]+' รายการ',parseInt(json["dataSum04"])]);

  var countlevelFix = new Array();
	countlevelFix.push(['Casual '+json["dataSum01FixFormat"]+' รายการ',parseInt(json["dataSum01Fix"])]);
	countlevelFix.push(['Classic '+json["dataSum02FixFormat"]+' รายการ',parseInt(json["dataSum02Fix"])]);
	countlevelFix.push(['Signature '+json["dataSum03FixFormat"]+' รายการ',parseInt(json["dataSum03Fix"])]);
  countlevelFix.push(['Unique '+json["dataSum04FixFormat"]+' รายการ',parseInt(json["dataSum04Fix"])]);

  var lineRestaurant = $('#high-lineRestaurant');
  var pieRestaurant1 = $('#high-pie-Restaurant');
  var pieRestaurant2 = $('#high-pie-RestaurantFix');
  if (lineRestaurant.length) {
      // High Line 3
      lineRestaurant.highcharts({
          credits: false,
          colors: highColors,
          chart: {
              backgroundColor: '#f9f9f9',
              className: 'br-r',
              type: 'line',
              zoomType: 'x',
              panning: true,
              panKey: 'shift',
              marginTop: 25,
              marginRight: 1,
          },
          title: {
              text: null
          },
          xAxis: {
              gridLineColor: '#EEE',
              lineColor: '#EEE',
              tickColor: '#EEE',
              categories: dataCategories
          },
          yAxis: {
              min: 0,
              tickInterval: 5,
              gridLineColor: '#EEE',
              title: {
                  text: null,
              }
          },
          plotOptions: {
              spline: {
                  lineWidth: 3,
              },
              area: {
                  fillOpacity: 0.2
              }
          },
          legend: {
              enabled: false,
          },
          series: countData
      });

  }
  if (pieRestaurant1.length) {
      // Pie Chart1
      pieRestaurant1.highcharts({
          credits: false,
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false
          },
          title: {
              text: null
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  center: ['30%', '50%'],
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: false
                  },
                  showInLegend: true
              }
          },
          colors: highColors,
          legend: {
              x: 150,
              floating: true,
              verticalAlign: "middle",
              layout: "vertical",
              itemMarginTop: 10
          },
          series: [{
              type: 'pie',
              name: 'Level share',
              data: countlevel
          }]
      });
  }
  if (pieRestaurant2.length) {
      // Pie Chart1
      pieRestaurant2.highcharts({
          credits: false,
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false
          },
          title: {
              text: null
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  center: ['30%', '50%'],
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: false
                  },
                  showInLegend: true
              }
          },
          colors: highColors,
          legend: {
              x: 150,
              floating: true,
              verticalAlign: "middle",
              layout: "vertical",
              itemMarginTop: 10
          },
          series: [{
              type: 'pie',
              name: 'Level share',
              data: countlevelFix
          }]
      });
  }
}

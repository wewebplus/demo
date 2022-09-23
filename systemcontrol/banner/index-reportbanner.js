var highColors = new Array();
var highLineColors = new Array();
// var highColors = [bgPrimary, bgWarning, bgInfo, bgAlert,bgDanger, bgSuccess, bgSystem, bgDark];
$(document).ready(function() {
	$('form').attr('autocomplete', 'off');
	$( "#ListBtn" ).live( "click", function() {
		var mydata = $('#ajaxFrm input[name=LoginData]').val();
		var url = getfullUrl()+'?'+mydata;
		window.location = url;
	});
	$('#daterangepicker1').daterangepicker({
    timePicker: false,
    locale: {
      format: 'DD/MM/YYYY'
    }
  });
  loadgraph();
});
function submitDate(t){
  loadgraph();
  return false;
}
function loadgraph(){
  var saveData = $('#myFrm input[name=saveData]').val();
	var homerang = $('#myFrm input[name=daterange]').val();
  var json = (function () {
		var json = null;
		$.ajax({
			'beforeSend': function(){
					$('.ajax-loader').css("visibility", "visible");
			},
			'async': false,
			'global': false,
			'type':'POST',
			'data':{saveData:saveData,homerang:homerang},
			'url': 'ajax-loadbannercountall.php',
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

	var countregister = json["resultline"].dataRegister;
	var dataRegisterCategories = json["resultline"].dataRegisterCat;
  var dataRegisterSelect = json["resultline"].dataRegisterSelect;
  $('.showDateText').html(dataRegisterSelect);
	var registercount = json["resultline"].dataregistercountformat;
	$('.RegisterTotal').html(registercount);
	var dataregistertext = json["resultline"].dataregistertext;
	$('.RegisterTotalText').html(dataregistertext);
	$.each(countregister, function( index, value ) {
		// console.log(value["incolor"]);
		highLineColors.push(value["incolor"]);
	});

	var countlevel = new Array();
	$.each(json["resultpie"], function( index, value ) {
	  countlevel.push([value["dataName"]+' '+value["dataSumFormat"]+' รายการ',parseInt(value["dataSum"])]);
		highColors.push(value["dataColor"]);
	});
	var countlevelFix = new Array();
	$.each(json["resultpie"], function( index, value ) {
	  countlevelFix.push([value["dataName"]+' '+value["dataSumFixFormat"]+' รายการ',parseInt(value["dataSumFix"])]);
	});
	// console.log(highColors);
	// console.log(countlevel);
  var line1 = $('#high-lineregister');
  var pie1 = $('#high-pie-Level');
  var pie2 = $('#high-pie-LevelFix');
  if (line1.length) {
      // High Line 3
      line1.highcharts({
          credits: false,
          colors: highLineColors,
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
              name: 'Avg.',
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
              name: 'Avg.',
              data: countlevelFix
          }]
      });
  }
}

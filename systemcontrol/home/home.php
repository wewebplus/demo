<?php include("../assets/lib/inc.config.php");?>
<?php include("../home/inc-header-db.php");?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo _TITLE_SITENAME_?></title>
<?php include("../home/inc-scriptcss.php");?>
<link rel="stylesheet" type="text/css" href="../vendor/plugins/daterangepicker-master/daterangepicker.css">
<link href="<?php echo './css/css.css?v='.$myrand?>" rel="stylesheet" type="text/css">
</head>

<body class="dashboard-page sb-l-o sb-r-c">

	<!-- Start: Main -->
  <div id="main">
		<?php include("../home/inc-header.php");?>
		<?php include("../home/inc-leftmenu.php");?>

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">
			<?php include("../home/inc-topbar-dropmenu.php");?>
			<?php include("../home/inc-topbar.php");?>

      <!-- Begin: Content -->
      <section id="content" class="animated">
        <?php
        $date = date("Y-m-d H:i:s");
        $DRStart = date("Y-m-1", strtotime($date));
        $DREnd = date("Y-m-t", strtotime($date));
        $showRangDate = dateformat($DRStart." 00:00:00",'d/m/Y')." - ".dateformat($DREnd." 00:00:00",'d/m/Y');
        $TabOpen = (!empty($_GET["TabOpen"])?$_GET["TabOpen"]:'1');
        ?>

        <div class="tab-block">
          <ul class="nav nav-tabs">
            <li class="active">
              <a href="#tab1" data-toggle="tab">สาขา ฺBs Express</a>
            </li>
            <li>
              <a href="#tab2" data-toggle="tab">Content Update</a>
            </li>
          </ul>
          <div class="tab-content p30">
            <div id="tab1" class="tab-pane active">
            <div class="gmap">
                <!-- /.container-fluid -->
                <div style="position: relative; margin-top: 20px;">
                    <div id="map" style="width:100%; height:650px"></div>
                </div>
            </div>

            </div>
          </div>
        </div>



      </section>
      <!-- End: Content -->

			<?php include("../home/inc-footer.php");?>
    </section>
    <!-- End: Content-Wrapper -->

    <!-- Start: Right Sidebar -->
		<?php include("../home/inc-sidebar_right.php");?>
    <!-- End: Right Sidebar -->

  </div>
  <!-- End: Main -->
<?php
include("../home/inc-scriptjs.php");
?>
<!-- Time/Date Plugin Dependencies -->
<script src="../vendor/plugins/globalize/globalize.min.js"></script>
<script src="../vendor/plugins/daterangepicker-master/moment.min.js"></script>
<!-- DateRange Plugin -->
<script src="../vendor/plugins/daterangepicker-master/daterangepicker.js"></script>

<!-- HighCharts Plugin -->
<script src="../vendor/plugins/highcharts/highcharts.js"></script>

<?php $_api_googlemap = "AIzaSyAKG8Nl4UnfixnR6ATRRhd73sRGUwzAMVQ";?>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_api_googlemap; ?>&callback=initMap&v=weekly&channel=2"
        async></script>
    <script>
    let map;

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(13.736717, 100.523186),
            zoom: 11,
        });



        const iconBase =
            "https://developers.google.com/maps/documentation/javascript/examples/full/images/";
        const icons = {
            parking: {
                icon: iconBase + "parking_lot_maps.png",
            },
            library: {
                icon: iconBase + "library_maps.png",
            },
            info: {
                icon: iconBase + "info-i_maps.png",
            },
        };
        const features = [
                        {
                            position: new google.maps.LatLng(13.7660725,
                                100.4851497),
                            event: "ศูนย์อุบลราชธานี (สำนักงานใหญ่)",
                            code: "EMS_2208310936625",
                            color: "buttgreen",
                            color_text: "เข้าถึงผู้ป่วย",
                            date: "31 ส.ค. 2565",
                            location: "302 ถนนสุริยาตร์ ตำบล ในเมือง อำเภอเมืองอุบลราชธานี อุบลราชธานี 34000",
                            mobile: "0641964515",
                            id: "625",
                        },
                        {
                            position: new google.maps.LatLng(13.918245261497647,
                                100.50487806302093),
                            event: "ศูนย์อุบลราชธานี (สำนักงานใหญ่)",
                            code: "EMS_2208271337624",
                            color: "buttgrey",
                            color_text: "เวลารับแจ้งเหตุ",
                            date: "27 ส.ค. 2565",
                            location: "302 ถนนสุริยาตร์ ตำบล ในเมือง อำเภอเมืองอุบลราชธานี อุบลราชธานี 34000",
                            mobile: "0909878859",
                            id: "624",
                        },
                        {
                            position: new google.maps.LatLng(13.8343742,
                                100.6027464),
                            event: "ศูนย์อุบลราชธานี (สำนักงานใหญ่)",
                            code: "EMS_2208231452623",
                            color: "buttgreen",
                            color_text: "เข้าถึงผู้ป่วย",
                            date: "23 ส.ค. 2565",
                            location: "302 ถนนสุริยาตร์ ตำบล ในเมือง อำเภอเมืองอุบลราชธานี อุบลราชธานี 34000",
                            mobile: "0985399523",
                            id: "623",
                        },
                        {
                            position: new google.maps.LatLng(13.7495373,
                                100.4706546),
                            event: "ศูนย์อุบลราชธานี (สำนักงานใหญ่)",
                            code: "EMS_2208231113620",
                            color: "buttyellow",
                            color_text: "ออกจากที่นำส่ง",
                            date: "23 ส.ค. 2565",
                            location: "302 ถนนสุริยาตร์ ตำบล ในเมือง อำเภอเมืองอุบลราชธานี อุบลราชธานี 34000",
                            mobile: "0630281155",
                            id: "620",
                        },
                ];


        // Create markers.
        for (let i = 0; i < features.length; i++) {

            const contentString =
                '<table width="100%" border="0">' +
                '<tbody>' +
                '<tr valign="top">' +
                '<td align="center" width="10px;">' +
                    '<div class="card-img">' +
                        '<img src="../../public/assets/app/images/content/06.jpg" class="card-img">' +
                    '</div>' +
                '</td>' +
                '<td style="width:50%">' +
                    '<div class="ss-stat" style="padding-left:5px;">' +
                        '<div class="stat" style="width:100%;padding-top:10px;">' +
                            '<em class="far fa-calendar-alt icon-round mr-1"></em>วันทำการ: วันจันทร์ - วันเสาร์' +
                        '</div>' +
                        '<div class="stat" style="width:100%;padding-top:10px;">' +
                            '<em class="far fa-clock icon-round mr-1"></em>เวลาทำการ: 8.00-17.30 น.' +
                        '</div>' +
                        '<div class="stat" style="width:100%;padding-top:10px;">' +
                            '<em class="fas fa-map-marker-alt icon-round mr-1"></em> 13.9641878,100.5516681' +
                        '</div>' +
                        '<div class="stat" style="width:100%;padding-top:10px;">' +
                            '<em class="fas fa-tty icon-round mr-1"></em>เบอร์โทร: 045-241116, 086-4600759,081-4938821' +
                        '</div>' +
                        '<div class="stat" style="width:100%;padding-top:10px;">' +
                            '<em class="fas fa-address-card icon-round mr-1"></em>ติดต่อ: นางสาวอภิษฎา รุ่งโรจน์' +
                        '</div>' +
                    '</div>' +
                '</td>' +
               
                '</tr>' +
                '</tbody>' +
                '</table>' +
                '<h6 class="red mt-1" style="padding-left: 20px;">' + features[i].event + '</h6>' +
                '<table border="0" width="100%" style="padding-top: 10px; padding-left: 20px;">' +
                '<tbody>' +
                '<tr valign="top">' +
                '<td style="padding-left: 20px" width="20"><img src="public/assets/app/images/icon/locate2.svg" width="12" alt="" /></td>' +
                '<td class="date grey pt-1">สถานที่ : ' + features[i].location +
                '</td>' +
                '</tr>' +
                '</tbody>' +
                '</table>' +
                '<a href="">' +
                '<div class="more" style="width: 100%;">การนำทาง <i class="fas fa-chevron-right"' +
                'style="float: right; margin-right: 20px;"></i></div>' +
                '</a>';


            const infowindow = new google.maps.InfoWindow({
                content: contentString,
            });

            const marker = new google.maps.Marker({
                position: features[i].position,
                map: map,
            });

            marker.addListener("click", () => {
                infowindow.open({
                    anchor: marker,
                    map,
                    shouldFocus: false,
                });
            });
        }
        if(features.length == 0){
            Swal.fire({
            title: 'ไม่พบข้อมูลที่ค้นหา',
            });
        }
    }
    </script>


</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>

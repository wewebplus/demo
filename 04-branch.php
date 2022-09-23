<!DOCTYPE html>
<html lang="th">
<head>
    <?php include_once('include/header.php'); ?>
    <?php include_once('include/style.php'); ?>
</head>
<body class="loading">
<?php include_once('include/topnav.php'); ?>

<div class="ss-page" data-page="3">
        <section class="about-03 section-padding" style="background-image:url('public/assets/app/images/bg/home-03.jpg');">
            <div class="container position-relative">
                <h6 class="h3 fw-600 color-white text-right" data-aos="fade-up" data-aos-delay="0">
                    สาขา BS Express
                </h6>
                <?php $categories = ['แสดงแบบรายการ', 'แสดง Google Map']; ?>
                <div class="tab-container">
                    <div class="tabs tabs-04 right mt-2 mb-2" data-aos="fade-up" data-aos-delay="150">
                        <?php foreach($categories as $j=>$k){?>
                            <a class="tab <?php if($j==0)echo 'active'; ?>" data-tab="<?= $j ?>" href="#">
                                <?= $k ?>
                            </a>
                        <?php }?>
                    </div>
                    <div class="tab-contents" data-aos="fade-up" data-aos-delay="300">
                       
                            <div class="tab-content active" data-tab="0">
                                <div class="list-header jc-end fw-wrap">
                                    <div class="block bcolor-white mb-2">
                                        <span class="p sm fw-400 color-white mr-1">ภูมิภาค</span>
                                        <div class="select-wrapper">
                                            <select class="sm round">
                                                <option value="">ทั้งหมด</option>
                                                <option value="">ภาคกลาง</option>
                                                <option value="">ภาคเหนือ</option>
                                                <option value="">ภาคตะวันออก</option>
                                                <option value="">ภาคตะวันตก</option>
                                            </select>
                                        </div>
                                        <div class="select-wrapper">
                                            <select class="sm round">
                                                <option value="">ทั้งหมด</option>
                                                <option value="">กรุงเทพมหานคร</option>
                                                <option value="">ปทุมธานี</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="width-full"></div>
                                    <div class="block bcolor-white mb-2">
                                        <span class="p sm fw-400 color-white mr-1">ค้นหาข้อมูลตามศูนย์</span>
                                        <div class="select-wrapper">
                                            <input type="text" name="name" class="form-control round" required title="General Text Input" />
                                        </div>
                                    </div>
                                    <div class="width-full"></div>
                                </div>
                                <div class="grids">
                                    <?php for($i=0; $i<16; $i++){?>
                                        <div class="grid xl-25 lg-1-3 sm-50">
                                            <div class="ss-card ss-card-02">
                                                <div class="text-container">
                                                    <div class="card-tag">
                                                    ศูนย์อุบลราชธานี (สำนักงานใหญ่)
                                                    </div>
                                                    
                                                    <div class="card-img">
                                                       <img src="public/assets/app/images/content/06.jpg" class="card-img">
                                                    </div>
                                                    <div class="ss-stat">
                                                        <div class="stat">
                                                            <em class="far fa-calendar-alt icon-round mr-1"></em> วันจันทร์ - วันเสาร์
                                                        </div>
                                                        <div class="stat">
                                                            <em class="far fa-clock icon-round mr-1"></em> 8.00-17.30 น.
                                                        </div>
                                                        <div class="stat">
                                                            <em class="fas fa-map-marker-alt icon-round mr-1"></em> 13.9641878,100.5516681
                                                        </div>
                                                    </div>
                                                    
                                                    <p class="xs desc">
                                                        302 ถนนสุริยาตร์ ตำบล ในเมือง อำเภอเมืองอุบลราชธานี อุบลราชธานี 34000
                                                    </p>
                                                    <div class="ss-stat">
                                                        <div class="stat">
                                                            <em class="fas fa-tty icon-round mr-1"></em> 045-241116, 086-4600759,<br>081-4938821
                                                        </div>
                                                        <div class="stat">
                                                            <em class="fas fa-address-card icon-round mr-1"></em> นางสาวอภิษฎา รุ่งโรจน์
                                                        </div>
                                                    </div>
                                                    <div class="arrow">
                                                        <em class="far fa-arrow-alt-circle-right"></em>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                               
                            </div>

                            <div class="tab-content" data-tab="1">
                                <div class="list-header jc-end fw-wrap">
                                    <div class="block bcolor-white mb-2">
                                        <span class="p sm fw-400 color-white mr-1">ภูมิภาค</span>
                                        <div class="select-wrapper">
                                            <select class="sm round">
                                                <option value="">ทั้งหมด</option>
                                                <option value="">ภาคกลาง</option>
                                                <option value="">ภาคเหนือ</option>
                                                <option value="">ภาคตะวันออก</option>
                                                <option value="">ภาคตะวันตก</option>
                                            </select>
                                        </div>
                                        <div class="select-wrapper">
                                            <select class="sm round">
                                                <option value="">ทั้งหมด</option>
                                                <option value="">กรุงเทพมหานคร</option>
                                                <option value="">ปทุมธานี</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="width-full"></div>
                                    <div class="block bcolor-white mb-2">
                                        <span class="p sm fw-400 color-white mr-1">ค้นหาข้อมูลตามศูนย์</span>
                                        <div class="select-wrapper">
                                            <input type="text" name="name" class="form-control round" required title="General Text Input" />
                                        </div>
                                    </div>
                                    <div class="width-full"></div>
                                </div>
                                <div class="gmap">
                                    <!-- /.container-fluid -->
                                    <div style="position: relative; margin-top: 20px;">
                                        <div id="map" style="width:100%; height:650px"></div>
                                    </div>
                                </div>
                               
                            </div>




             
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <?php include_once('include/footer.php'); ?>
    <?php include_once('include/script.php'); ?>
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
                        '<img src="public/assets/app/images/content/06.jpg" class="card-img">' +
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

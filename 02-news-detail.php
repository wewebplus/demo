<!DOCTYPE html>
<html lang="th">
<head>
    <?php include_once('include/header.php'); ?>
    <?php include_once('include/style.php'); ?>
</head>
<body class="loading">
<?php include_once('include/topnav.php'); ?>
<?php
        $breadcrumb = [
            [ 'url' => '#', 'display' => 'ข่าว/ประกาศ' ],
            [ 'url' => '#', 'display' => 'ข่าวประชาสัมพันธ์' ],
        ];
        $breadcrumbTitle = 'ข่าวประชาสัมพันธ์';
        $breadcrumbBg = 'public/assets/app/images/bg/04.jpg';
    ?>
<!-- Page 5 -->
<div class="ss-page" data-page="5">
        <section class="intro-04 section-padding" style="background-image:url('public/assets/app/images/bg/pattern-02.png');">
            <div class="container">
            <div class="tab-container">
                    <div class="blocks" data-aos="fade-up" data-aos-delay="0">
                        <div class="block">
                            <h6 class="h3 fw-600 color-black">
                                ข่าวประชาสัมพันธ์
                            </h6>
                        </div>
                    </div>
                    <div class="tab-contents" data-aos="fade-up" data-aos-delay="150">
                    <section class="section-padding" data-aos="fade-up" data-aos-delay="300">
        <div class="container">
            <h6 class="h4 fw-500 lh-sm color-black">
                สำนักงานปลัดกระทรวงพลังงานได้รับรางวัลเลิศรัฐ สาขาการบริหารราชการแบบมีส่วนร่วม 
                ประจำปี พ.ศ. 2562
            </h6>
            <img class="img" src="public/assets/app/images/content/weblink-08.jpg" alt="Post Content Image" />
            <div class="post-content">
                <h6 class="fw-500">
                    “ทูตพลังงานรวมพลังพัฒนาและอนุรักษ์พลังงานสู่ความยั่งยืน รุ่นที่ 1” 
                    จากสำนักงานพลังงานจังหวัดสมุทรปราการ สำนักงานปลัดกระทรวงพลังงาน
                </h6>
                <p class="mt-3 pt-1 lh-lg">
                    เมื่อวันที่ 13 กันยายน 2562 สำนักงาน ก.พ.ร. จัดพิธีมอบรางวัลเลิศรัฐ ประจำปี พ.ศ. 2562 
                    เพื่อเชิดชูหน่วยงานภาครัฐที่มีผลงานโดดเด่นกว่า 200 ผลงาน  โดยมี นายวิษณุ เครืองาม รองนายกรัฐมนตรี 
                    เป็นประธานในพิธีมอบรางวัลเลิศรัฐ ประจำปี 2562 ในปีนี้มีหน่วยงานภาครัฐที่ได้รับรางวัลกว่า 219 ผลงาน 
                    จากทั้งหมดที่ส่งเข้าประกวด 1,043 ผลงาน
                </p>
                <p class="mt-3 pt-1 lh-lg">
                    โดยสำนักงานปลัดกระทรวงพลังงาน ส่งผลงาน “ทูตพลังงานรวมพลังพัฒนาและอนุรักษ์พลังงานสู่ความยั่งยืน 
                    รุ่นที่ 1” จากสำนักงานพลังงานจังหวัดสมุทรปราการ และได้รับรางวัลเลิศรัฐ สาขาการบริหารราชการแบบมีส่วนร่วม 
                    ประเภทรางวัล สัมฤทธิผลประชาชนมีส่วนร่วม (Effective Change) ระดับดี
                </p>
                <p class="mt-3 pt-1 lh-lg">
                    สำหรับผลงานที่ได้รับรางวัลเลิศรัฐในปีนี้ แบ่งเป็น 3 สาขาได้แก่ 
                    สาขาบริการภาครัฐมอบให้แก่หน่วยงานรัฐที่มีผลการพัฒนาคุณภาพการให้บริการประชาชนด้วยบริการที่สะดวกรวดเร็ว 
                    โปร่งใส เป็นธรรม และเป็นที่พึงพอใจ จำนวน 123 รางวัล 
                    สาขาคุณภาพการบริหารจัดการภาครัฐมอบให้แก่หน่วยงานรัฐที่มีการพัฒนาคุณภาพการบริหารจัดการได้ทัดเทียมมาตรฐานสากลจำนวน 
                    24 รางวัล และสาขาการบริหารราชการแบบมีส่วนร่วมมอบให้แก่หน่วยงานรัฐที่มีความมุ่งมั่นตั้งใจในการพัฒนาประสิทธิภาพการบริหารราชการบนพื้นฐานความรับผิดชอบ 
                    และการมีส่วนร่วมของประชาชน จำนวน 66 รางวัล
                </p>
            </div>
            <div class="mt-2 mb-3">
                <?php
                    $postFooter = ['icon-social'];
                    include('component/post-footer.php');
                ?>
            </div>
        </div>
    </section>
                    </div>
                </div>
            </div>
        </section>
</div>
    
    <?php include_once('include/footer.php'); ?>
    <?php include_once('include/script.php'); ?>

</body>
</html>

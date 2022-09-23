<!DOCTYPE html>
<html lang="th">
<head>
    <?php include_once('include/header.php'); ?>
    <?php include_once('include/style.php'); ?>
</head>
<body class="loading">
<?php include_once('include/topnav.php'); ?>

<!-- Page 5 -->
<div class="ss-page" data-page="5">
        <section class="intro-04 section-padding" style="background-image:url('public/assets/app/images/bg/home-05.jpg');">
            <div class="container">
                <?php $categories = ['Energy Channel', 'สื่อประชาสัมพันธ์', 'แบบสอบถาม', 'คำถามที่พบบ่อย']; ?>
                <div class="tab-container">
                    <div class="blocks" data-aos="fade-up" data-aos-delay="0">
                        <div class="block">
                            <h6 class="h3 fw-600 color-black">
                                ข่าวสารประชาสัมพันธ์
                            </h6>
                        </div>
                    </div>
                    <div class="tab-contents" data-aos="fade-up" data-aos-delay="150">
                        <?php foreach($categories as $j=>$k){?>
                            <div class="tab-content <?php if($j==0)echo 'active'; ?>" data-tab="<?= $j ?>">
                                <div class="ss-box md mt-3">
                                    <div class="px-2 py-2 bg-white border bcolor-white">
                                        <a class="ss-img" href="#p">
                                            <div class="img-bg" style="background-image:url('public/assets/app/images/content/0<?= $i%5+1 ?>.jpg');"></div>
                                            <div class="hover-container">
                                                <div class="icon">
                                                    <img src="public/assets/app/images/icon/play.png" alt="Hover Icon" />
                                                </div>
                                            </div>
                                            <div class="short-desc bg-white">
                                                <p class="sm fw-600 color-black lh-xs">
                                                    ข่าวดี! เปิดรับสมัครงานจำนวนมาก หลายอัตรา
                                                </p>
                                                <p class="xs fw-600 color-01 lh-xs">
                                                    16 เมษายน 2020
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="gallery-grids mt-4">
                                    <?php for($i=0; $i<6; $i++){?>
                                        <div class="grid lg-1-3 md-50 sm-100 mt-0">
                                            <div class="ss-card ss-card-12 style-main clip-path-01">
                                                <div class="video-container">
                                                    <a class="ss-img square" href="#">
                                                        <div class="img-bg" style="background-image:url('public/assets/app/images/content/0<?= $i%5+1 ?>.jpg');"></div>
                                                        <div class="hover-container op-100">
                                                            <div class="icon">
                                                                <img src="public/assets/app/images/icon/play.png" alt="Hover Icon" />
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="text-container">
                                                    <a class="title p xs fw-600" href="#">
                                                        B.S. Express กำจัดจุดอ่อนส่งด่วน  “อีคอมเมิร์ซ” ที่เติบโตขึ้นอย่างต่อเนื่อง
                                                    </a>
                                                    <p class="date fw-600">
                                                        8 เมษายน 2020
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <?php include_once('include/footer.php'); ?>
    <?php include_once('include/script.php'); ?>

</body>
</html>

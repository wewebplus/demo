<!DOCTYPE html>
<html lang="th">
<head>
    <?php include_once('include/header.php'); ?>
    <?php include_once('include/style.php'); ?>
</head>
<body class="loading">
<?php include_once('include/topnav.php'); ?>

<div class="ss-page" data-page="3">
<?php
        $breadcrumb = [
            [ 'url' => '#', 'display' => 'การให้บริการ' ],
            [ 'url' => '#', 'display' => 'คำถามที่พบบ่อย' ],
        ];
        $breadcrumbTitle = 'คำถามที่พบบ่อย';
        $breadcrumbBg = 'public/assets/app/images/bg/11.jpg';
    ?>
    <div class="ss-page" data-page="3">
        <section class="about-03 section-padding" style="background-image:url('public/assets/app/images/bg/pattern-02.png');">
    <section class="section-padding">
        <div class="container">
            <div class="blocks" data-aos="fade-up" data-aos-delay="0">
                <div class="block">
                    <h6 class="h3 fw-600 color-black">
                    คำถามที่พบบ่อย
                    </h6>
                </div>
            </div>
            <div class="faq-01 mt-3 pt-2 pb-1" data-aos="fade-up" data-aos-delay="450">
                <?php for($i=0; $i<10; $i++){?>
                    <div class="faq <?php if($i==0)echo 'active'; ?>">
                        <div class="question">
                            <div class="ftag">Q</div>
                            <h6 class="p lg fw-500">
                            งื่อนไขการซื้อประกันเพิ่มของบีเอสมีอะไรบ้าง 
                            </h6>
                            <div class="arrow"></div>
                        </div>
                        <div class="answer" <?php if($i==0)echo 'style="display:block;"'; ?>>
                            <div class="wrapper">
                                <div class="ftag">A</div>
                                <div class="content">
                                    <p>
                                    กรณีส่งสินค้าที่ร้าน ลูกค้าสามารถซื้อประกันเพิ่มได้โดยคิดค่าบริการ 1% จากมูลค่าของพัสดุที่ระบุให้กับบีเอส 
                                    ซึ่งจะมีวงเงินรับประกันสูงสุดไม่เกิน500,000 บาทสำหรับรถกระบะ/ ไม่เกิน 1,000,000 บาท สำหรับรถ 6 ล้อ/ 
                                    และไม่เกิน 2,000,000 บาท สำหรับรถ 10 ล้อ โดยสินค้าต้องอยู่ในเงื่อนไขการรับประกัน
                                    </p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
            
        </div>
    </section>
</section>
</div>
        
</div>
    
    <?php include_once('include/footer.php'); ?>
    <?php include_once('include/script.php'); ?>
</body>
</html>

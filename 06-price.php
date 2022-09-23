<!DOCTYPE html>
<html lang="th">
<head>
    <?php include_once('include/header.php'); ?>
    <?php include_once('include/style.php'); ?>
</head>
<body class="loading">
<?php include_once('include/topnav.php'); ?>

<div class="ss-page" data-page="5">
        <section class="intro-04 section-padding" style="background-image:url('public/assets/app/images/bg/pattern-02.png');">
            <div class="container">
                <?php $categories = ['ค่าบริการต่อชิ้น', 'ค่าบริการแบบเหมาคัน']; ?>
                <div class="tab-container">
                    <div class="blocks" data-aos="fade-up" data-aos-delay="0">
                        <div class="block">
                            <h6 class="h3 fw-600 color-black">
                            คำนวณค่าบริการ
                            </h6>
                        </div>
                        <div class="block">
                            <div class="tabs tabs-01">
                                <?php foreach($categories as $j=>$k){?>
                                    <a class="tab <?php if($j==0)echo 'active'; ?>" data-tab="<?= $j ?>" href="#">
                                        <?= $k ?>
                                    </a>
                                <?php }?>
                            </div>
                        </div>
                        <div class="block">
                            <a class="btn btn-action btn-color-01 btn-round btn-sm" href="#">
                                ดูราคาทั้งหมด <em class="far fa-arrow-alt-circle-right ml-1"></em>
                            </a>
                        </div>
                    </div>
                    <div class="tab-contents" data-aos="fade-up" data-aos-delay="150">
                            <div class="tab-content active" data-tab="0">
                                
                                <div class="gallery-grids" data-aos="fade-up" data-aos-delay="150">
                                    <div class="grid lg-100 md-2-3 sm-100 mt-0">
                                        <div class="gallery-grids">
                                            <div class="grid sm-100">

                                                <div class="about-box clip-path-01 ">
                                                    <div class="mt-4" data-aos="fade-up" data-aos-delay="300">
                                                        <form action="/" method="POST">
                                                            <div class="grids">
                                                                <div class="grid sm-25 mt-50">
                                                                    <div class="form-group">
                                                                        <label class="p color-gray">จังหวัดปลายทาง </label>                                                                       
                                                                        <select name="department" class="form-control round"  style="padding: 0.4375rem 0.875rem;height: 42px;">
                                                                            <option value="">จังหวัดปลายทาง</option>
                                                                            <option value="">กรุงเทพ</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="grid sm-60 mt-50">
                                                                    <div class="form-group">
                                                                        <label class="p color-gray">ขนาดกล่อง (ซ.ม.) </label>
                                                                        <div class="row">
                                                                            <div class="grid sm-35 mt-0">
                                                                                <input type="text" name="name" class="form-control round" required title="General Text Input"  placeholder="กว้าง"/>
                                                                            </div>
                                                                            <div class="grid sm-35 mt-0">
                                                                                <input type="text" name="name" class="form-control round" required title="General Text Input" placeholder="ยาว"/>
                                                                            </div>
                                                                            <div class="grid sm-30 mt-0">
                                                                                <input type="text" name="name" class="form-control round" required title="General Text Input" placeholder="สูง"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid sm-15 mt-50">
                                                                    <div class="form-group">
                                                                        <label class="p color-gray">น้ำหนัก (ก.ก.)</label>
                                                                        <input type="text" name="phone" class="form-control round" required title="General Text Input" />
                                                                    </div>
                                                                </div>
                                                                 
                                                            </div>
                                                            
                                                        </form>
                                                        <div class="gallery-grids mt-3">
                                                            
                                                            <div class="grid lg-100 md-1-3">
                                                                <div class="contact-card-01">
                                                                    <div class="contact-tag">
                                                                        <img src="public/assets/app/images/icon/fax.png" alt="Contact Card Icon">
                                                                    </div>
                                                                    <p class="fw-500">ราคาคำนวณ</p>		
                                                                    <div class="p lg fw-600 color-01">
                                                                    <h2 class="h2 lg fw-600 color-black text-center">
                                                                        150 บาท
                                                                    </h2>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>

                            <div class="tab-content  data-tab="1">
                                
                                <div class="gallery-grids" data-aos="fade-up" data-aos-delay="150">
                                    <div class="grid lg-100 md-2-3 sm-100 mt-0">
                                        <div class="gallery-grids">
                                            <div class="grid sm-100">

                                            <div class="about-box clip-path-01 ">
                                                    <div class="mt-4" data-aos="fade-up" data-aos-delay="300">
                                                        <form action="/" method="POST">
                                                            <div class="grids">
                                                                <div class="grid sm-25 mt-50">
                                                                    <div class="form-group">
                                                                        <label class="p color-gray">จังหวัดปลายทาง </label>                                                                       
                                                                        <select name="department" class="form-control round"  style="padding: 0.4375rem 0.875rem;height: 42px;">
                                                                            <option value="">จังหวัดปลายทาง</option>
                                                                            <option value="">กรุงเทพ</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="grid sm-60 mt-50">
                                                                    <div class="form-group">
                                                                        <label class="p color-gray">ขนาดกล่อง (ซ.ม.) </label>
                                                                        <div class="row">
                                                                            <div class="grid sm-35 mt-0">
                                                                                <input type="text" name="name" class="form-control round" required title="General Text Input"  placeholder="กว้าง"/>
                                                                            </div>
                                                                            <div class="grid sm-35 mt-0">
                                                                                <input type="text" name="name" class="form-control round" required title="General Text Input" placeholder="ยาว"/>
                                                                            </div>
                                                                            <div class="grid sm-30 mt-0">
                                                                                <input type="text" name="name" class="form-control round" required title="General Text Input" placeholder="สูง"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid sm-15 mt-50">
                                                                    <div class="form-group">
                                                                        <label class="p color-gray">น้ำหนัก (ก.ก.)</label>
                                                                        <input type="text" name="phone" class="form-control round" required title="General Text Input" />
                                                                    </div>
                                                                </div>
                                                                 
                                                            </div>
                                                            
                                                        </form>
                                                        <div class="gallery-grids mt-3">
                                                            
                                                            <div class="grid lg-100 md-1-3">
                                                                <div class="contact-card-01">
                                                                    <div class="contact-tag">
                                                                        <img src="public/assets/app/images/icon/fax.png" alt="Contact Card Icon">
                                                                    </div>
                                                                    <p class="fw-500">ราคาคำนวณ</p>		
                                                                    <div class="p lg fw-600 color-01">
                                                                    <h2 class="h2 lg fw-600 color-black text-center">
                                                                        150 บาท
                                                                    </h2>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>

                    </div>

                    <div class="container" style="padding-top:50px">
                        <div class="row">
                                <div class="col-md-5">
                                    <img class="img-responsive" src="https://pronto-core-cdn.prontomarketing.com/2/wp-content/uploads/sites/2859/2018/11/sg04-boxsize.jpg" alt="sg04-boxsize">
                                </div>
                                <div class="col-md-7">
                                    <h2 class="font-40 margin-bottom-10"><strong>วิธีวัดขนาดกล่อง</strong></h2>
                                    <p class="font-26 font-kanit">Size (cm.)</p>
                                    <img class="img-responsive" src="public/assets/app/images/content/content-1.png" alt="sg04-boxsize">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-contents" data-aos="fade-up" data-aos-delay="150">
                    <section class="section-padding" data-aos="fade-up" data-aos-delay="300">
                        <div class="container">
                            <h6 class="h4 fw-500 lh-sm color-black">
                            บริการเสริมและเงื่อนไขบริการ
                            </h6>
                            <div class="post-content">   
                                <p class="mt-3 pt-1 lh-lg">
                                บริการเก็บเงินปลายทาง (COD)<br>
                                บริการจัดส่งพื้นที่ห่างไกล<br>
                                ประกันครอบคลุมสูงสุดถึง 2,000 บาท (เงื่อนไขตามที่บริษัทฯกําหนด)<br>
                                </p>
                                <p class="mt-3 pt-1 lh-lg">
                                <b>หมายเหตุ:</b> จุดรับพัสดุกรุงเทพฯและต่างจังหวัด อัตราค่าบริการคํานวณจากขนาดหรือนํ้าหนักของพัสดุโดยอย่างใดอย่างหนึ่ง
                                มีค่ามากกว่า
                                </p>
                                
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

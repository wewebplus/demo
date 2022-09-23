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
        <section class="intro-04 section-padding" style="background-image:url('public/assets/app/images/bg/pattern-02.png');">
        <section class="section-padding">
        <div class="container">
            <div class="grids">
                <div class="grid lg-50 sm-100 mt-0" data-aos="fade-up" data-aos-delay="300">
                    <h6 class="h4 lg fw-600 color-black">
                    บีเอส เอ็กเพรช ขนส่ง
                    </h6>
                    <p class="color-black mt-2">
                    ห้างหุ้นส่วนจำกัด บี.เอส.ขนส่ง <br>
                    302 ถนนสุริยาตร์ อำเภอเมือง จังหวัดอุบลราชธานี 34000
                    </p>
                    <div class="btns mt-3">
                        <a class="btn btn-social btn-color-01" href="#">
                            <em class="fab fa-facebook-f"></em>
                        </a>
                        <a class="btn btn-social btn-color-01" href="#">
                            <em class="fab fa-youtube"></em>
                        </a>
                        <a class="btn btn-social btn-color-01" href="#">
                            <em class="fas fa-sitemap"></em>
                        </a>
                    </div>
                    <div class="gallery-grids mt-3">
                        <div class="grid lg-50 md-1-3">
                            <div class="contact-card-01">
                                <div class="contact-tag">
                                    <img src="public/assets/app/images/icon/phone.png" alt="Contact Card Icon" />
                                </div>
                                <p class="fw-500">โทรศัพท์</p>		
                                <a class="p lg fw-600 color-01" href="#">
                                    02-140-6000
                                </a>
                            </div>
                        </div>
                        <div class="grid lg-50 md-1-3">
                            <div class="contact-card-01">
                                <div class="contact-tag">
                                    <img src="public/assets/app/images/icon/fax.png" alt="Contact Card Icon" />
                                </div>
                                <p class="fw-500">โทรสาร</p>		
                                <a class="p lg fw-600 color-01" href="#">
                                    02-140-6228
                                </a>
                            </div>
                        </div>
                        <div class="grid lg-50 md-1-3">
                            <div class="contact-card-01">
                                <div class="contact-tag">
                                    <img src="public/assets/app/images/icon/mail.png" alt="Contact Card Icon" />
                                </div>
                                <p class="fw-500">อีเมล</p>	
                                <a class="p lg fw-600 color-01" href="#">
                                    servicelink@energy.go.th
                                </a>
                            </div>
                        </div>
                        <div class="grid lg-50 md-1-3">
                            <div class="contact-card-01">
                                <div class="contact-tag">
                                    <img src="public/assets/app/images/icon/headphone.png" alt="Contact Card Icon" />
                                </div>
                                <p class="fw-500">ศูนย์บริการร่วม</p>	
                                <a class="p lg fw-600 color-01" href="#">
                                    02-140-7000
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid lg-50 sm-100 lg-mt-0" data-aos="fade-up" data-aos-delay="450">
                    <div class="map-container">
                        <div class="fit img-fill" style="background-image:url('public/assets/app/images/misc/map.jpg');"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="section-padding">
        <div class="container">
            <div class="ss-box lg">
                <div data-aos="fade-up" data-aos-delay="0">
                    <h6 class="h4 lg fw-600 color-black text-center">
                        แบบฟอร์มติดต่อเรา
                    </h6>
                    <p class="lg text-center sm-no-br mt-1">
                        หากมีคำถาม คำติชม คำแนะนำ หรือพบปัญหากรุณากรอกแบบฟอร์มด้านล่างนี้ <br>
                        ทางเจ้าหน้าที่จะคำเนินการตามคำขอโดยเร็วที่สุด 
                    </p>
                </div>
                <p class="color-gray text-center mt-2 pt-1" data-aos="fade-up" data-aos-delay="150">
                    กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน โดยช่องเฉพาะที่มีเครื่องหมาย 
                    <span class="text-danger">*</span> 
                </p>
                <div class="mt-4" data-aos="fade-up" data-aos-delay="300">
                    <form action="/" method="POST">
                        <div class="grids">
                            <div class="grid sm-50 mt-0">
                                <div class="form-group">
                                    <label class="p color-gray">เลือกหน่วยงาน <span class="text-danger">*</span></label>
                                    <div class="select-wrapper">
                                        <select name="department" class="form-control round" required>
                                            <option value="">เลือกหน่วยงาน</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="grid sm-50 mt-0">
                                <div class="form-group">
                                    <label class="p color-gray">ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control round" required title="General Text Input" />
                                </div>
                            </div>
                            <div class="grid sm-50 mt-0">
                                <div class="form-group">
                                    <label class="p color-gray">หมายเลขโทรศัพท์ <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control round" required title="General Text Input" />
                                </div>
                            </div>
                            <div class="grid sm-50 mt-0">
                                <div class="form-group">
                                    <label class="p color-gray">อีเมล <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control round" required title="General Text Input" />
                                </div>
                            </div>
                            <div class="grid sm-100 mt-0">
                                <div class="form-group">
                                    <label class="p color-gray">ข้อความ <span class="text-danger">*</span></label>
                                    <textarea name="message" rows="5" class="form-control round" required title="General Textarea"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex ai-center jc-space-between fw-wrap mt-1 pb-1">
                            <div class="captcha-container mt-3">
                                <img class="img" src="public/assets/app/images/misc/captcha.jpg" alt="CAPTCHA" />
                            </div>
                            <div class="btns width-auto mt-3">
                                <button type="submit" class="btn btn-action btn-color-01 btn-round">
                                    ส่งข้อความ <em class="far fa-arrow-alt-circle-right ml-1"></em>
                                </button>
                                <button type="reset" class="btn btn-action btn-color-02 btn-round">
                                    ล้างข้อมูล <em class="far fa-times-circle ml-1"></em>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
        </section>
    </div>
    
    <?php include_once('include/footer.php'); ?>
    <?php include_once('include/script.php'); ?>

</body>
</html>

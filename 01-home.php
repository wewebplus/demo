<!DOCTYPE html>
<html lang="th">

<head>
    <?php include_once('include/header.php'); ?>
    <?php include_once('include/style.php'); ?>
</head>

<body class="loading">
    <?php include_once('include/topnav.php'); ?>

    <div class="ss-page active" data-page="0">
        <section class="banner-02">
            <div class="slide-container">
                <div class="slides">
                    <?php for($i=0; $i<4; $i++){?>
                        <div class="slide" style="background-image:url('public/assets/app/images/banner/banner01-bg.jpg');">
                            <div class="container">
                                <img class="img-text animate" src="public/assets/app/images/misc/text-02.png" alt="Banner Image Text" style="--delay:.75s;" />
                            </div>
                        </div>
                    <?php }?>
                </div>
                <div class="bullet">
                    <div class="arrows">
                        <div class="arrow arrow-prev">
                            <img src="public/assets/app/images/icon/arrow-left.png" alt="Arrow Icon" />
                        </div>
                        <div class="arrow arrow-next">
                            <img src="public/assets/app/images/icon/arrow-right.png" alt="Arrow Icon" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="intro-03 pos-main">
            <div class="wrapper">
                <div class="intro-cards">
                    <div class="intro-card clip-path-01 bg-01" data-aos="fade-up" data-aos-delay="0">
                        <div class="wrapper color-black">
                            <img class="img-pattern-2" src="public/assets/app/images/icon/give.png" alt="Image Pattern" />
                            <h6 class="p sm fw-500">สมัครแฟรนไชส์</h6>
                            <p class="xs fw-600 margin-01">&nbsp</p>
                            <p class="h6 fw-600 lh-2xs">Franchise</p>
                        </div>
                    </div>
                    <div class="intro-card clip-path-01 bg-02" data-aos="fade-up" data-aos-delay="150">
                        <div class="wrapper color-white">
                            <img class="img-pattern" src="public/assets/app/images/icon/ico-trackandtrace.svg" alt="Image Pattern" />
                            <h6 class="p sm fw-500">ตรวจสอบสถานะ</h6>
                            <p class="xs fw-600 margin-01">&nbsp</p>
                            <p class="h6 fw-600 lh-2xs">TRACK & TRACE</p>
                        </div>
                    </div>
                    <a class="intro-card" href="#" data-aos="fade-up" data-aos-delay="300">
                        <div class="wrapper color-white">
                            <div class="img-bg clip-path-01" style="background:#413a3e;"></div>
                            <img class="img-content" src="public/assets/app/images/misc/rep-02.png" alt="Image Content" />
                            <div class="position-relative text-center">
                                <p class="fw-400 margin-03 lh-sm">
                                    <span class="text-xl fw-300">อัพเดทข้อมูลทันใจ</span> 
                                    <br> สมัครรับข่าวสารจากเรา
                                </p>
                            </div>
                        </div>
                    </a>
                    <a class="intro-card" href="#" data-aos="fade-up" data-aos-delay="450">
                        <div class="wrapper color-white">
                            <div class="img-bg clip-path-01" style="background-image:url('public/assets/app/images/misc/card-01.jpg');"></div>
                            <img class="img-content" src="public/assets/app/images/misc/rep-03.png" alt="Image Content" />
                            <div class="position-relative text-center">
                                <p class="fw-400 margin-02 lh-sm color-01">
                                    ลูกค้าสนใจใช้บริการ<br>คลิกได้ที่นี่
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="sep"></div>
                    <div class="intro-card lg bcolor-08 bg-08" data-aos="fade-up" data-aos-delay="300">
                        <div class="wrapper color-white">
                            <h5 class="fw-600">คำนวนราคาบริการ</h5>
                    
                            <div class="grids color-white" style="padding-top:20px">
                            <div class="grid sm-100 mt-0">
                                <div class="form-group">
                                    <p class="p">จังหวัดปลายทาง <span class="text-danger">*</span></p>
                                    <div class="select-wrapper">
                                        <select name="department" class="form-control round" required>
                                            <option value="">เลือกจังหวัด</option>
                                            <option value="">กรุงเทพมหานคร</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid sm-100">
                                <div class="form-group">
                                    <p class="p ">ผลรวมกล่อง (กว้าง + ยาว + สูง) <span class="text-danger">*</span></p>
                                    <input type="text" name="phone" class="form-control round" required title="General Text Input" />
                                </div>
                            </div>
                            <div class="grid sm-100">
                                <div class="form-group">
                                    <p class="p">น้ำหนัก (ก.ก.) <span class="text-danger">*</span></p>
                                    <input type="email" name="email" class="form-control round" required title="General Text Input" />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex ai-center jc-space-between fw-wrap mt-1 pb-1" style="width:100%;padding-top:15px;">
                            <div class="btns mt-12">
                                <button type="submit" class="btn btn-action btn-color-01 btn-round" style="width:100%"> 
                                    ตรวจสอบราคา <em class="far fa-arrow-alt-circle-right ml-1"></em>
                                </button>
                            </div>
                        </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="popup-container simple active" data-popup="subscribe">
        <div class="wrapper">
            <div class="popup-box border bcolor-white bg-white px-2 py-2">
                <div class="img-container">
                    <img src="public/assets/app/images/misc/songkran.png" alt="Popup Banner">
                </div>
                <div class="d-flex ai-center jc-center mt-2">
                    <div class="form-check sm mr-4">
                        <input type="checkbox" class="form-check-input" id="show-toggle" value="1" title="General Checkbox Input" />
                        <label for="show-toggle">ไม่ต้องแสดงอีก</label>
                    </div>
                    <a class="btn btn-action btn-color-01 btn-round btn-sm btn-popup-toggle px-5" href="#" data-popup="subscribe">
                        <i class="far fa-times-circle color-white mr-1"></i> ปิด
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('include/footer.php'); ?>
    <?php include_once('include/script.php'); ?>
</body>

</html>

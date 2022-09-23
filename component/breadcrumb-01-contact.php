<?php if(!empty($breadcrumb)){?>
    <section class="breadcrumb-01 style-contact">
        <div class="breadcrumb-container" style="background-image:url('<?= $breadcrumb['image'] ?>');">
            <div class="container">
                <div class="grids">
                    <div class="grid xl-1-3 lg-40 sm-100 mt-0" data-aos="fade-up" data-aos-delay="0">
                        <div class="ss-icon-title-01 <?php if(!empty($breadcrumb['leading_class']))echo $breadcrumb['leading_class']; ?>">
                            <div class="text-icon fw-400"><?= $breadcrumb['leading'] ?></div>
                            <div class="text-wrapper">
                                <div class="title fw-400"><?= $breadcrumb['title'] ?></div>
                                <div class="desc fw-100"><?= $breadcrumb['desc'] ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="grid xl-2-3 lg-60 sm-100 mt-0" data-aos="fade-up" data-aos-delay="150">
                        <div class="contact-container">
                            <h6 class="color-01">
                                กรมโยธาธิการและผังเมือง กระทรวงมหาดไทย
                            </h6>
                            <p class="xs color-white">
                                <span class="font-01">
                                    224 ถนนพระราม 9 แขวงห้วยขวาง เขตห้วยขวาง กรุงเทพฯ 10320
                                </span>
                            </p>
                            <table class="table-contact mt-3" style="max-width:21rem;">
                                <tbody>
                                    <tr>
                                        <td><img src="public/assets/app/images/icon/clock.png" alt="Image Icon" /></td>
                                        <td><p class="xs color-01"><span class="font-01"> เวลาทำการ</span></p></td>
                                        <td><p class="xs color-white">
                                            <span class="font-01">จันทร์ - ศุกร์ เวลา 8:30 - 16:30 น.</span>
                                        </p></td>
                                    </tr>
                                    <tr>
                                        <td><img src="public/assets/app/images/icon/footer-01.png" alt="Image Icon" /></td>
                                        <td><p class="xs color-01"><span class="font-01">โทรศัพท์</span></p></td>
                                        <td><a href="#" class="p xs color-white h-color-01">
                                            <span class="font-01">0 2207 3599</span>
                                        </a></td>
                                    </tr>
                                    <tr>
                                        <td><img src="public/assets/app/images/icon/footer-02.png" alt="Image Icon" /></td>
                                        <td><p class="xs color-01">
                                            <span class="font-01">โทรสาร</span>
                                        </p></td>
                                        <td><a href="#" class="p xs color-white h-color-01">
                                            <span class="font-01">0 2207 3506</span>
                                        </a></td>
                                    </tr>
                                    <tr>
                                        <td><img src="public/assets/app/images/icon/footer-03.png" alt="Image Icon" /></td>
                                        <td><p class="xs color-01">
                                            <span class="font-01">อีเมล</span>
                                        </p></td>
                                        <td><a href="#" class="p xs color-white h-color-01">
                                            <span class="font-01">support@erc.or.th</span>
                                        </a></td>
                                    </tr>
                                    <tr>
                                        <td><img src="public/assets/app/images/icon/footer-04.png" alt="Image Icon" /></td>
                                        <td><p class="xs color-01">
                                            <span class="font-01">หน่วยงาน<br>บริการ</span>
                                        </p></td>
                                        <td><a href="#" class="h3 fw-600 color-white h-color-01">
                                            <span class="font-01 lh-3xs">1204</span>
                                        </a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if(!empty($breadcrumb['structure'])){?>
                    <div class="breadcrumb-wrapper" data-aos="fade-up" data-aos-delay="150">
                        <a href="#">
                            <img src="public/assets/app/images/icon/home.png" alt="Image Icon" />
                        </a>
                        <?php foreach($breadcrumb['structure'] as $b){?>
                            <em class="fas fa-chevron-right"></em>
                            <a href="<?= $b['url'] ?>">
                                <?= $b['name'] ?>
                            </a>
                        <?php }?>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="pattern-container">
            <div class="pattern" style="background-image:url('public/assets/app/images/misc/pattern-03.png');"></div>
        </div>
    </section>
<?php }?>

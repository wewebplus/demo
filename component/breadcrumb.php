
<?php if(!empty($breadcrumb)){?>
    <section class="breadcrumb-01 img-fill <?php if(!empty($breadcrumbClass))echo $breadcrumbClass; ?>" 
    <?php if(!empty($breadcrumbBg))echo 'style="background-image:url(\''.$breadcrumbBg.'\');"'; ?> >
        <div class="container">
            <div class="wrapper" data-aos="fade-up" data-aos-delay="0">
                <a class="p sm" href="#">
                    หน้าหลัก
                </a>
                <?php foreach($breadcrumb as $b){?>
                    <em class="zmdi zmdi-chevron-right p sm"></em>
                    <a class="p sm" href="<?= $b['url'] ?>">
                        <?= $b['display'] ?>
                    </a>
                <?php }?>
            </div>
            <h6 class="title h2 fw-600" data-aos="fade-up" data-aos-delay="150">
                <?= $breadcrumbTitle ?>
            </h6>
        </div>
    </section>
<?php }?>

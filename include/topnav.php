<!-- Topnav -->
<nav class="topnav <?php if(!empty($topnavClass))echo $topnavClass; ?>">
    <div class="container">
        <div class="blocks">
            <div class="block ai-unset">
                <a class="logo" href="#">
                    <div class="img-container">
                        <img src="https://pronto-core-cdn.prontomarketing.com/2/wp-content/uploads/sites/2859/2018/10/logo-r1.png" alt="Website Logo" />
                    </div>
                </a>
            </div>
            <div class="menu-container hide-mobile" id="topnav-menu">
                <?php
                    foreach([
                        'เกี่ยวกับเรา', 'บริการของเรา', 'ค่าบริการ', 
                        'สาขา BS Express', 'คำถามที่พบบ่อย', 'แฟรนไชส์', 'ข่าวสาร', 'ติดต่อเรา'
                    ] as $i=>$d){
                ?>
                    <div class="menu has-children">
                        <a href="#" data-dropdown="<?= $i ?>">
                            <?= $d ?> 
                            <?php if($i == 1 || $i == 2){?>
                            <em class="fas fa-chevron-down"></em>
                            <?php } ?>
                        </a>
                        <?php if($i == 1){?>
                            <div class="submenu-dropdown <?php
                                if($i>3)echo 'anchor-right';
                                else if($i>1)echo 'anchor-middle';
                                ?>">
                                <div class="submenu-blocks">
                                    <div class="submenu-block">
                                        <h6 class="submenu-title p lg fw-600"><?= $d ?></h6>
                                        <div class="submenu">
                                            <a href="#">ข้อกำหนดและเงื่อนไขในการขนส่ง</a>
                                        </div>
                                        <div class="submenu">
                                            <a href="#">บริการส่งสินค้าไปต่างประเทศ</a>
                                        </div>
                                        <div class="submenu">
                                            <a href="#">บริการรับพัสดุถึงบ้านลูกค้า</a>
                                        </div>
                                        <div class="submenu">
                                            <a href="#">รับขนย้ายบ้าน ออฟฟิศ และโรงงาน</a>
                                        </div>
                                        <div class="submenu">
                                            <a href="#">ขายประกันรถยนต์และพรบ.</a>
                                        </div>
                                        <div class="submenu">
                                            <a href="#">รับชำระบิลสาธารณูปโภค ค่าน้ำ ไฟ โทรศัพท์</a>
                                        </div>
                                        <div class="submenu">
                                            <a href="#">รับชำระเงินค่าบริการต้นทางหรือปลายทาง</a>
                                        </div>
                                        <div class="submenu">
                                            <a href="#">ผู้บริหารเทคโนโลยีสารสนเทศระดับสูง</a>
                                        </div>
                                        <div class="submenu">
                                            <a href="#">E-Fulfillment</a>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($i == 2){?>
                            <div class="submenu-dropdown <?php
                                if($i>3)echo 'anchor-right';
                                else if($i>1)echo 'anchor-middle';
                                ?>">
                                <div class="submenu-blocks">
                                    <div class="submenu-block">
                                        <h6 class="submenu-title p lg fw-600"><?= $d ?></h6>
                                        <div class="submenu">
                                            <a href="#">ค่าบริการต่อชิ้น</a>
                                        </div>
                                        <div class="submenu">
                                            <a href="#">ค่าบริการแบบเหมาคัน</a>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                <?php }?>
            </div>
            <div class="block mobile-right">
                <a class="option sidenav-toggle" href="#">
                    <div class="hamburger">
                        <div></div><div></div><div></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</nav>
<div class="topnav-spacer"></div>

<!-- Sidenav -->
<nav class="sidenav">
    <div class="wrapper">
        <div class="sidenav-toggle">
            <div class="hamburger">
                <div></div><div></div><div></div>
            </div>
        </div>
        <div class="options">
            <div class="option">
                <div class="icon">ก</div>
                <div class="dropdown">
                    <div class="icon font-size-btn" data-size="-1">-</div>
                    <div class="icon font-size-btn" data-size="0">ก</div>
                    <div class="icon font-size-btn" data-size="1">+</div>
                </div>
            </div>
            <div class="option">
                <div class="icon">C</div>
                <div class="dropdown">
                    <div class="icon theme-btn" data-theme="0">C</div>
                    <div class="icon theme-btn" data-theme="1">C</div>
                    <div class="icon theme-btn" data-theme="2">C</div>
                </div>
            </div>
            <div class="option">
                <div class="flag" style="background-image:url('public/assets/app/images/misc/th-flag.png');"></div>
                <div class="dropdown">
                    <a href="#">
                        <div class="flag" style="background-image:url('public/assets/app/images/misc/us-flag.png');"></div>
                    </a>
                </div>
            </div>
        </div>
        <div class="scroll-wrapper" data-simplebar>
            <div class="menu-container"></div>
        </div>
    </div>
</nav>
<div class="sidenav-filter"></div>

<!-- Global Search Container -->
<div class="global-search-container">
    <div class="wrapper">
        <div class="close-filter global-search-toggle"></div>
        <div class="container">
            <div class="search-panel">
                <form action="/" method="GET">
                    <div class="form-group mt-0">
                        <div class="append">
                            <input type="text" class="md sgray" placeholder="พิมพ์คำค้นหาที่ต้องการ" required />
                            <button type="submit" class="icon lg">
                                <em class="fas fa-search"></em>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="item-container">
                    <p class="fw-600 color-08">คำแนะนำค้นหา</p>
                    <div class="items" data-simplebar>
                        <?php
                            foreach([
                                'ร่างธรรมนูญว่าด้วยการผังเมือง',
                                'นโยบายการตั้งถิ่นฐานและผังเมือง',
                                'สำนักงานสภาพัฒนาการเศรษฐกิจและ',
                                'สังคมแห่งชาติ',
                                'ทิศทางการพัฒนาเชิงพื้นที่',
                                'การจัดระบบเมืองที่มีคุณภาพ',
                                'ร่างธรรมนูญว่าด้วยการผังเมือง',
                                'นโยบายการตั้งถิ่นฐานและผังเมือง',
                            ] as $d){
                        ?>
                            <a class="item p sm fw-600" href="#">
                                <div class="text-container font-01">
                                    <?= $d ?>
                                </div>
                                <div class="icon">
                                    <img src="public/assets/app/images/icon/arrow-right-black.png" alt="Image Icon" />
                                </div>
                            </a>
                        <?php }?>
                    </div>
                    <div class="btns">
                        <a class="btn btn-action btn-color-05 width-full clip-path-01" href="#">
                            ค้นหาขั้นสูง <em class="fas fa-chevron-right sm ml-2"></em>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
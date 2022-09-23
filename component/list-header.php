
<?php if(isset($listHeader)){?>
    <div class="list-header">
        <div class="block">
            <?php if(in_array('category', $listHeader)){?>
                <div class="select-wrapper">
                    <select>
                        <option value="">แบ่งตามหมวดหมู่</option>
                    </select>
                </div>
            <?php }?>
            <?php if(in_array('order', $listHeader)){?>
                <div class="select-wrapper">
                    <select>
                        <option value="">เรียงลำดับข้อมูล</option>
                    </select>
                </div>
            <?php }?>
        </div>
        <div class="block">
            <?php if(in_array('search', $listHeader)){?>
                <div class="search-wrapper">
                    <input type="text" placeholder="ค้นหา" />
                </div>
            <?php }?>
        </div>
        <?php if(in_array('crud', $listHeader)){?>
            <div class="block">
                <a class="btn-icon color-black h-color-01" href="#">
                    <em class="zmdi zmdi-plus-circle-o"></em> ตั้งกระทู้ใหม่
                </a>
                <a class="btn-icon color-black h-color-01" href="#">
                    <em class="zmdi zmdi-lock-outline"></em> เข้าสู่ระบบ
                </a>
                <a class="btn-icon color-black h-color-01" href="#">
                    <em class="zmdi zmdi-account-o"></em> สมัครสมาชิก
                </a>
            </div>
        <?php }?>
    </div>
<?php }?>

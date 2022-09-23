
<?php if(isset($listFooter)){?>
    <div class="list-footer">
        <?php if(in_array('total', $listFooter)){?>
            <div class="block">
                <p class="xs fw-500 color-02">
                    แสดงข้อมูล
                    <span class="fw-600 mx-2">1 - 100</span>
                    จาก 180
                </p>
            </div>
        <?php }?>
        <?php if(in_array('pagination', $listFooter)){?>
            <div class="block">
                <div class="pagination-02">
                    <div class="wrapper">
                        <a href="#" class="page-btn page-prev disabled">
                            <em class="fas fa-chevron-left"></em>
                        </a>
                        <a href="#" class="page-btn">01</a>
                        <div class="dots">.....</div>
                        <a href="#" class="page-btn">19</a>
                        <a href="#" class="page-btn">20</a>
                        <a href="#" class="page-btn active">21</a>
                        <a href="#" class="page-btn">22</a>
                        <a href="#" class="page-btn">23</a>
                        <div class="dots">.....</div>
                        <a href="#" class="page-btn">101</a>
                        <a href="#" class="page-btn page-next">
                            <em class="fas fa-chevron-right"></em>
                        </a>
                    </div>
                </div>
            </div>
        <?php }?>
        <?php if(in_array('pp', $listFooter)){?>
            <div class="block">
                <p class="xs fw-500 color-02 mr-2">
                    การแสดงผล
                </p>
                <div class="pagination-02">
                    <div class="wrapper">
                        <a href="#" class="page-btn active">10</a>
                        <a href="#" class="page-btn">20</a>
                        <a href="#" class="page-btn">30</a>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
<?php }?>

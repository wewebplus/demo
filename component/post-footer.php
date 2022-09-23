
<?php if(isset($postFooter)){?>
    <div class="post-footer">
        <div class="block">
            <span class="fw-900">TAGS:</span> 
            <div class="ss-tag ml-2">สำนักบริหารกลาง</div>
            <div class="ss-tag ml-1">ข่าวกิจกรรมและประชาสัมพันธ์</div>
        </div>
        <div class="block ai-start">
            <?php if(in_array('embed', $postFooter)){?>
                <div class="position-relative mr-2">
                    <a class="btn btn-action btn-color-01 btn-round btn-xs btn-toggle" 
                    data-toggle="embed" href="#">
                        Embed 
                        <em class="fas fa-code ml-1"></em>
                    </a>
                    <div class="toggle-target" data-toggle="embed">
                        <textarea name="message" rows="2" data-copy="0">Temporary code test</textarea>
                        <div class="btns text-center">
                            <a class="btn btn-action btn-color-01 btn-round btn-xs width-full" 
                            data-copy="0" href="#">
                                คัดลอกโค้ด
                            </a>
                        </div>
                    </div>
                </div>
            <?php }?>
            <?php if(in_array('icon-social', $postFooter)){?>
                <div class="text-center mr-2">
                    <a class="btn btn-social fw" href="#" tabindex="0">
                        <em class="fab fa-facebook-f"></em>
                    </a>
                    <div class="p fw-600">10</div>
                </div>
                <div class="text-center mr-2">
                    <a class="btn btn-social tw" href="#" tabindex="0">
                        <em class="fab fa-twitter"></em>
                    </a>
                    <div class="p fw-600">8</div>
                </div>
                <div class="text-center">
                    <a class="btn btn-social ln" href="#" tabindex="0">
                        <em class="fab fa-line"></em>
                    </a>
                </div>
            <?php }?>
        </div>
    </div>
<?php }?>

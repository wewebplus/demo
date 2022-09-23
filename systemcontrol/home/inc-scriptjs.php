<!-- <script type="text/javascript" src="../vendor/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../vendor/jquery-inc.js"></script> -->
<script type="text/javascript" src="../vendor/jquery/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="../vendor/jquery/jquery-inc.js"></script>
<script type="text/javascript" src="../vendor/jquery/jquery-migrate-1.1.1.js"></script>

<script type="text/javascript" src="../vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="../vendor/plugins/loading-overlay/src/loadingoverlay.min.js"></script>
<script type="text/javascript" src="<?php echo "../vendor/plugins/jquery-confirm/jquery-confirm.min.js"?>"></script>
<!-- Theme Javascript -->
<script type="text/javascript" src="../assets/js/utility/utility.js"></script>
<script type="text/javascript" src="../assets/js/main.js?ver=7.0"></script>
<script type="text/javascript" src="../assets/js/custom.js?ver=7.0"></script>
<script type="text/javascript" src="<?php echo "../dataarray/dataarray_js.php?v=6.0"?>"></script>
<script type="text/javascript" src="<?php echo "../dataarray/data".$mymenuinclude."_js.php?v=".$myrand?>"></script>
<!-- Widget Javascript -->
<script type="text/javascript" type="text/javascript">
  $(document).ready(function(){
    Core.init();
  	$('input,textarea').focus(function(){
  	   $(this).data('placeholder',$(this).attr('placeholder'))
  			  .attr('placeholder','');
  	}).blur(function(){
  	   $(this).attr('placeholder',$(this).data('placeholder'));
  	});
  });
</script>

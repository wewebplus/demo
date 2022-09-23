<!DOCTYPE>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BsExpress</title>
<link rel="icon" href="<?php echo "./assets/img/index.png"?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo "./assets/img/index.png"?>" type="image/x-icon" />
<link rel="shortcut icon" href="./assets/img/favicon.ico" title="Disaster" />
<script type="text/javascript" src="vendor/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="assets/js/alerts-1.1/jquery.alerts.js"></script>
<link rel="stylesheet" href="assets/js/alerts-1.1/jquery.alerts.css" type="text/css" />
<link rel="stylesheet" href="<?php echo 'assets/skin/frmlogin/loginfrm.css?ver='.rand();?>" type="text/css"  />
<script type="text/javascript" src="<?php echo 'loginfrm.js?ver='.rand();?>"></script>
</head>

<body>
<div class="bg"></div>
	<div class="container">

    <div class="card">
        <h1 class="title">administrator system</h1>
        <form name="frmLogin" id="frmLogin" action="?" method="post" onSubmit="return false;">
            <div class="input-container">
                <input id="inputuser" name="inputuser" type="text" required="required" onKeyDown="this.setCustomValidity('')" oninvalid="this.setCustomValidity('กรุณากรอกชื่อผู้ใช้งานระบบ!')" />
                <label for="inputuser"><i class="fa fa-user"></i> กรอกชื่อผู้ใช้งานระบบ</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input id="inputpass" name="inputpass" type="password" required="required" onKeyDown="this.setCustomValidity('')" oninvalid="this.setCustomValidity('กรุณากรอกรหัสผ่าน!')" />
                <label for="inputpass"><i class="fa fa-lock"></i> กรอกรหัสผ่าน</label>
                <div class="bar"></div>
            </div>
            <div id="resultError" class="resultError">&nbsp;</div>
            <div class="button-container">
                <button>
                    <span>เข้าสู่ระบบ</span>
                </button>
            </div>
			<div class="footmainversion">Version 1.0</div>
        </form>
    </div>
	</div>

</body>
</html>

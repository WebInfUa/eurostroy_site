<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{title}</title>
  <!-- Core CSS - Include with every page -->
  <link rel="stylesheet" href="{template}css/reset.css">
  <link rel="stylesheet" href="{template}css/base.css">
  <link rel="stylesheet" href="{template}css/admin_menu.css">

  <link rel="stylesheet" href="{template}font-awesome/css/font-awesome.css">
<!--    <link href="{template}css/bootstrap.min.css" rel="stylesheet">-->
<!--    <link href="{template}css/general.css" rel="stylesheet">-->
<!--    <link href="{template}css/sb-admin.css" rel="stylesheet">-->
<!-- Page-Level Plugin CSS - Blank -->
  {css}
<!-- SB Admin CSS - Include with every page -->
	<script src="{template}ckeditor/ckeditor.js"></script>
	<script src="{template}ckfinder/ckfinder.js"></script>
</head>
  
<body class="wrapper-main">
<div id="wrapper">
  {menu}
  {content}
</div>
    
<footer class="footer">
  <div>
    <div class="cleanslate w24tz-current-time w24tz-middle" style="display: inline-block !important; visibility: hidden !important; min-width:300px !important; min-height:145px !important;">
      <p>
        <a href="//24timezones.com/ru_time/ukraine_cherkassy_clock.php"
           id="tz24-1573641555-c215921-eyJob3VydHlwZSI6IjI0Iiwic2hvd2RhdGUiOiIxIiwic2hvd3NlY29uZHMiOiIxIiwiY29udGFpbmVyX2lkIjoiY2xvY2tfYmxvY2tfY2I1ZGNiZGQ1M2RlMWY1IiwidHlwZSI6ImRiIiwibGFuZyI6InJ1In0=" 
           style="text-decoration: none" 
           class="clock24"
           title="Черкассы" 
           target="_blank"
           rel="nofollow"></a>
      </p>
      <div id="clock_block_cb5dcbdd53de1f5"></div>
    </div>

  </div>
  
  <div class="footer__calendar">
    <iframe
            src="https://calendar.google.com/calendar/embed?height=150&amp;wkst=2&amp;bgcolor=%23616161&amp;ctz=Europe%2FKiev&amp;src=ZXZyb3N0cm95LnVrcmFpbmVAZ21haWwuY29t&amp;src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;src=cnUudWtyYWluaWFuI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;color=%2322AA99&amp;color=%23329262&amp;color=%231F753C&amp;showTitle=0&amp;showNav=1&amp;showDate=0&amp;showCalendars=0&amp;showTz=0&amp;showTabs=0&amp;showPrint=0&amp;mode=AGENDA" 
            style="border:solid 1px #777" 
            width="400" 
            height="150" 
            frameborder="0" 
            scrolling="no"></iframe>
  </div>
  
</footer>

  <!-- /#wrapper -->
	<!-- Core Scripts - Include with every page -->
  <script type="text/javascript" src="//w.24timezones.com/l.js" async></script>
	<script src="{template}js/jquery-1.10.2.js"></script>
	<script src="{template}js/bootstrap.min.js"></script>
	<script src="{template}js/plugins/metisMenu/jquery.metisMenu.js"></script>
	
	<!-- Page-Level Plugin Scripts - Blank -->
	{js}
	<!-- SB Admin Scripts - Include with every page -->
	<script src="{template}js/sb-admin.js"></script>
	<!-- Page-Level Demo Scripts - Blank - Use for reference -->
</body>

</html>

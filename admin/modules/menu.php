<?
// Menu addon

// Check errors for ALERTS block
$db=new db();
$alertser=$db->count('SELECT * FROM `rce_logs_errors` WHERE `date`>NOW()-INTERVAL 24 HOUR');
if($alerts>0){
	$alerts_show='';
	$alerts='
		<a class="header__alert '.$alerts_show.'" href="'.RCE_ADMIN.'?module=logs_errors">'.$alerts.' ошибок. За 24 часа</span></a>
	';
} else {
	$alerts_show='display:none;';
}

// Genereting menu, single first
$r=mysql_query("
	SELECT * FROM `rce_modules` 
	WHERE `group`='single' 
	AND `core`='0'
	AND `active`='1'
	ORDER BY `title` ASC
");
for($i=0;$i<mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
		if(rce_access($f['codename'],'open')){
			$menu_single.='<li class="menu__nav--item" '.rce_menu_active_single($f['codename']).'>
					<a class="menu__nav--link" href="'.RCE_ADMIN.'?module='.$f['codename'].'"><i class="fa-'.$f['icon'].'"></i> '.$f['title'].'</a>
				</li>';
		} else {$menu_single.='';}
}
// Generating menu groups
$rg=mysql_query("SELECT * FROM `rce_modules_menu` ORDER BY `order` ASC");
for($i=0;$i<mysql_num_rows($rg);$i++){
	$fg=mysql_fetch_array($rg);
		// Head
		if(rce_access($fg['module'],'open')){
			$menu_active=rce_menu_active_multi($fg['module']);
			$menu_groups.='
				<li class="menu__nav--item" '.$menu_active['li'].'>
                  <a class="menu__nav--link" href="#"><i class="fa fa-'.$fg['groupIcon'].'"></i> '.$fg['groupTitle'].'</a>
					<ul class="menu__nav--slider '.$menu_active['ul'].'">';
		} else {$menu_groups.='';}
		// Fetching module list
		$rg2=mysql_query("
			SELECT * FROM `rce_modules` 
			WHERE `group`='".$fg['module']."' 
			AND `active`='1'
			ORDER BY `ID` ASC
		");
		for($j=0;$j<mysql_num_rows($rg2);$j++){
			$fg2=mysql_fetch_array($rg2);
				if(rce_access($fg2['codename'],'open')){
					$menu_groups.='
						<li class="menu__nav--submenu" '.rce_menu_active_single($fg2['codename']).'>
                          <a class="menu__nav--link" href="'.RCE_ADMIN.'?module='.$fg2['codename'].'">'.$fg2['title'].'</a>
                        </li>';
				} else {$menu_groups.='';}
		}
		// Foot
		$menu_groups.='</ul>
        </li>';
}

$menu='
<header class="header wrapper-main">
<div class="header__logo">
  <a class="menu__nav--link" href="//bud-komplekt.com.ua/admin/" aria-label="Back to main" title="На главную">
    <img class="header__logo--img" src="/template/images/design/logo_slogan.png" alt="Eurostroy admin">
  </a>
  <p class="header__alert">
      '.$alerts.'
  </p>
</div>
<div class="menu">
  <div class="menu__config">
    <span class="menu__config--name">Добро пожаловать: <span class="header__alert">Site Administrator</span></span>
    <span class="menu__config--email">admin@bud-komplekt.com.ua</span>
    <a class="menu__nav--link" href="/" target="_blank">На сайт</a>
    <a class="menu__nav--link" href="//bud-komplekt.com.ua/admin/?do=logout">Выход</a>
  </div>

  <div class="menu__slider">
    <span class="menu__slider--burger" onclick="isOpenNav()">&#9776;</span>
  </div>

  <nav id="burgerMenu" class="menu__nav">
    <ul class="menu__nav--list">
      <li class="menu__nav--item menu__slider--clbtn">
        <a class="menu__nav--link" href="#" onclick="isCloseNav()"><span class="menu__slider--close">&times;</span> Закрыть</a>
      </li>
        '.$menu_single.'
        '.$menu_groups.'
    </ul>
  </nav>
 </div>
</header>

<!--Scripts dropDown menu-->
<script src="'.RCE_ADMIN.'template/js/menuDropDown.js"></script>
<script src="'.RCE_ADMIN.'template/js/menuSlider.js"></script>

';

?>
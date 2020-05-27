<?
// Template Renderer

// Config
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];

// Header file
$file=$DOCUMENT_ROOT.'/template/header.tpl';
$r=fopen($file,'r');
$tpl=fread($r,filesize($file));
fclose($r);

// Main file
$file=$DOCUMENT_ROOT.'/template/'.$tpl_file.'.tpl';
$r=fopen($file,'r');
$tpl.=fread($r,filesize($file));
fclose($r);

// Footer file
$file=$DOCUMENT_ROOT.'/template/footer.tpl';
$r=fopen($file,'r');
$tpl.=fread($r,filesize($file));
fclose($r);

// Tag set
$tag='{site_root}';$tpl=str_replace($tag,$site_root,$tpl);
$tag='{template}';$tpl=str_replace($tag,$TEMPLATE,$tpl);
$tag='{css}';$tpl=str_replace($tag,$css,$tpl);
$tag='{js}';$tpl=str_replace($tag,$js,$tpl);
$tag='{jquery}';$tpl=str_replace($tag,$jquery,$tpl);
$tag='{title}';$tpl=str_replace($tag,$title,$tpl);
$tag='{pageDescr}';$tpl=str_replace($tag,$pageDescr,$tpl);
$tag='{breadcrumbs}';$tpl=str_replace($tag,$breadcrumb,$tpl);
$tag='{speedbar}';$tpl=str_replace($tag,$speedbar,$tpl);
$tag='{content}';$tpl=str_replace($tag,$content,$tpl);
$tag='{menu}';$tpl=str_replace($tag,$menu,$tpl);
$tag='{about}';$tpl=str_replace($tag,$about,$tpl);
$tag='{actions}';$tpl=str_replace($tag,$actions,$tpl);
$tag='{sliderMain}';$tpl=str_replace($tag,$sliderMain,$tpl);
$tag='{sliderMain2}';$tpl=str_replace($tag,$sliderMain2,$tpl);
$tag='{sliderMain3}';$tpl=str_replace($tag,$sliderMain3,$tpl);
$tag='{banner_top}';$tpl=str_replace($tag,$banner_top,$tpl);
$tag='{banner_med}';$tpl=str_replace($tag,$banner_med,$tpl);
$tag='{banner_down}';$tpl=str_replace($tag,$banner_down,$tpl);
$tag='{calcWall}';$tpl=str_replace($tag,$calcWall,$tpl);
$tag='{calcCeiling}';$tpl=str_replace($tag,$calcCeiling,$tpl);
$tag='{calcTerm}';$tpl=str_replace($tag,$calcTerm,$tpl);
$tag='{calcRoof}';$tpl=str_replace($tag,$calcRoof,$tpl);
$tag='{reviews}';$tpl=str_replace($tag,$reviews,$tpl);
$tag='{news}';$tpl=str_replace($tag,$news,$tpl);
$tag='{tours}';$tpl=str_replace($tag,$tours,$tpl);
$tag='{dateD}';$tpl=str_replace($tag,$dateD,$tpl);
$tag='{servis}';$tpl=str_replace($tag,$servis,$tpl);
$tag='{captcha}';$tpl=str_replace($tag,$captcha,$tpl);
$tag='{objects}';$tpl=str_replace($tag,$objects,$tpl);
$tag='{stock}';$tpl=str_replace($tag,$stock,$tpl);
$tag='{spec}';$tpl=str_replace($tag,$spec,$tpl);
$tag='{top_sell}';$tpl=str_replace($tag,$top_sell,$tpl);
$tag='{out_sell}';$tpl=str_replace($tag,$out_sell,$tpl);
$tag='{qty_prod_cart}';$tpl=str_replace($tag,$qty_prod_cart,$tpl);
$tag='{cart_icon}';$tpl=str_replace($tag,$cart_icon,$tpl);
$tag='{cart_list}';$tpl=str_replace($tag,$cart_list,$tpl);
$tag='{cartTopItem}';$tpl=str_replace($tag,$cartTopItem,$tpl);
$tag='{sum2}';$tpl=str_replace($tag,$sum2,$tpl);
$tag='{count}';$tpl=str_replace($tag,$count,$tpl);
$tag='{topMenu}';$tpl=str_replace($tag,$topMenu,$tpl);
$tag='{calcMenu}';$tpl=str_replace($tag,$calcMenu,$tpl);
$tag='{logo}';$tpl=str_replace($tag,$logo,$tpl);
$tag='{cats}';$tpl=str_replace($tag,$cats,$tpl);
$tag='{catList}';$tpl=str_replace($tag,$catList,$tpl);
$tag='{home_news}';$tpl=str_replace($tag,$homeNews,$tpl);
$tag='{last_news}';$tpl=str_replace($tag,$lastNews,$tpl);
$tag='{news_tags}';$tpl=str_replace($tag,$newsTags,$tpl);
$tag='{randProd}';$tpl=str_replace($tag,$randProd,$tpl);



// Meta tags
$r=mysql_query("
	SELECT * FROM `rce_config_lang` WHERE `lang`='ru'
");
$f=mysql_fetch_array($r);
$meta_data.='
  <title>'.$meta_title.'</title>
	<meta name="keywords" content="'.$meta_keys.'"/>
	<meta name="description" content="'.$meta_desc.'"/>
  <meta property="og:title" content="'.$title.'"/>
  <meta property="og:type" content="Интерент магазин"/>
  <meta property="og:url" content="https://bud-komplekt.com.ua/"/>
  <meta property="og:image" content="https://bud-komplekt.com.ua/template/images/logo/logo.png"/>
  <meta property="og:site_name" content="bud-komplekt.com.ua"/>
  <meta property="og:description" content="'.$meta_desc.'"/>';

// If special meta tags == ON
if($meta_special=='1'){
    $meta_data.=$meta_spec;
}
$tag='{meta_data}';$tpl=str_replace($tag,$meta_data,$tpl);


// ВЫВОД ДАННЫХ
echo $tpl;

?>
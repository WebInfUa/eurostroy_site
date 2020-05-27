<?
// Pages

function filterBlock($prodID){
  
}

$ur = substr($_SERVER['REQUEST_URI'], 1);
$ch = substr($ur, -1);
if($ch == '/'){
    $ur = substr($ur, 0, -1);
}

$r=mysql_query("
    SELECT * FROM `rce_pages`
    WHERE `trans`='".$ur."'
    LIMIT 1
");

if(mysql_num_rows($r)>'0'){
    $f=mysql_fetch_array($r);
    $meta_title=$f['meta_title'];
    $meta_keys=$f['meta_keys'];
    $meta_desc=$f['meta_desc'];

    if($URL[1] == ''){
      $title=$f['title'];
      $breadcrumb='
      <a class="breadcrumb-item" href="/">Главная</a>
      <span class="brd-separetor">/</span>
      <span class="breadcrumb-item active">'.$f['title'].'</span>';
    } else {
        $rp=mysql_query("
            SELECT * FROM `rce_pages`
            WHERE `trans`='".$URL[0]."'
            LIMIT 1
        ");
        $fp = mysql_fetch_array($rp);
        $title='<a href="/">Главная</a> <b>/</b> <a href="/'.$URL[0].'/">'.$fp['title'].'</a> <b>/</b> '.$f['title'];
    }

    $content.=$f['text'];

    // ADD-ON

    if($ur=='calc-gk_potolok1'){

      
//Product List
//  NAME                        Size z   1C-ID       Size x
//  1. Knauf GKL                9mm      ID 542      1.2/2.5m (S = 3m2); 
//  2. Profile CD-60            0.4mm    ID 32       3m
//  3. Profile UD-27            0.4mm    ID 30       3m
//  4. Connector Line CD-60     0.55mm   ID 52       0.2m
//  5. Connector Crab CD-60     0.55mm   ID 53       0.4m
//  6. Podves +zazim CD-60      0.6mm    ID 49       0.4m
//  7. Tyaga podvesa            0.6mm    ID 1589     0.25m
//  8. Samorez                  3.5mm    ID ---      0,025m
//  9. Dubel 6*40               6 mm     ID 46150    0.04m
// 10. Lenta 45*45mm                     ID 848
// 11. Shpakel Fugenfuller               ID 539 
// 12. Shpakel Multifinish               ID 538
// 13. Grunt Ceresit CT-17               ID 48762
// 14. Podves es60/250M                  ID 45377
// 15. SamorezBloha                      ID 493

      
    $content.='
<table>       
<thead>
        <tr>
					<th>Наименование</th>
					<th>Ед.<br />изм.</th>
					<th>Норма расхода<p>на 1 м2</p></th>
				</tr>
           </thead>
         <tbody>
				<tr>
					<td>
					<h4>1. Лист гипсокартонный КНАУФ-ГКЛ 
					(ГКЛВ)</h4>
					</td>
					<td>
					<h4>м2</h4>
					</td>
					<td align="center">
					<h4>1,05</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>2. Профиль потолочный CD 60/27</h4>
					</td>
					<td>
					<h4>пог.м</h4>
					</td>
					<td align="center">
					<h4>2.9</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>3. Профиль направляющий UD 28/27
					</h4>
					</td>
					<td>
					<h4>пог.м</h4>
					</td>
					<td align="center">
					<h4>периметр</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>4. Удлинитель профилей 60/110
					</h4>
					</td>
					<td>
					<h4>шт.</h4>
					</td>
					<td align="center">
					<h4>0.2</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>5. Соединитель профилей одноуровневый 
					двухсторонний (краб)</h4>
					</td>
					<td>
					<h4>шт.</h4>
					</td>
					<td align="center">
					<h4>1.7</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>6a Подвес с зажимом</h4>
					</td>
					<td>
					<h4>шт.</h4>
					</td>
					<td align="center">
					<h4>0.7</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>6б Тяга подвеса</h4>
					</td>
					<td>
					<h4>шт.</h4>
					</td>
					<td align="center">
					<h4>0.7</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>7. Шуруп самонарезающий ТN25</h4>
					</td>
					<td>
					<h4>шт.</h4>
					</td>
					<td align="center">
					<h4>23</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>8. Потолочный дюбель (Анкерный Bierbach)</h4>
					</td>
					<td>
					<h4>шт.</h4>
					</td>
					<td align="center">
					<h4>0.7</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>9. Дюбель "К" 6/40</h4>
					</td>
					<td>
					<h4>шт.</h4>
					</td>
					<td align="center">
					<h4>периметр*2</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>10. Лента армирующая</h4>
					</td>
					<td>
					<h4>м</h4>
					</td>
					<td align="center">
					<h4>1.2</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>11. Шпаклевка "Фугенфюллер".</h4>
					</td>
					<td>
					<h4>кг</h4>
					</td>
					<td align="center">
					<h4>0.35</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>Шпаклевка поверхности листов Мульти-финиш</h4>
					</td>
					<td>
					<h4>кг</h4>
					</td>
					<td align="center">
					<h4>1.2</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>Грунтовка "Тифенгрунд</h4>
					</td>
					<td>
					<h4>л</h4>
					</td>
					<td align="center">
					<h4>0.1</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>Возможная замена материала. 
					Вместо подвеса с зажимом и тяги подвеса используется: *</h4>
					</td>
				</tr>
				<tr>
					<td>
					<h4>5в Подвес прямой для СD- профиля 60/27</h4>
					</td>
					<td align="center">
					<h4>шт.</h4>
					</td>
					<td align="center">
					<h4>0,7</h4>
					</td>
				</tr>
				<tr>
					<td>5г. Шуруп самонарезающий LN 9</td>
					<td align="center">шт.</td>
					<td align="center">1,4</td>
				</tr>
				<tr>
					<td colspan="3"><i>* При опуске подвесного потолка 
					от базового перекрытия не более 125 мм</i></td>
				</tr>
			</tbody>
</table>


            <style>
                .row {line-height:1.8em;}
                .table thead tr th {text-align:center;}
                .table tbody tr td {text-align:center;}
                .table tbody tr td:nth-child(2) {text-align:left;}
                .table tbody tr td:nth-child(5) {font-weight:bold;}
            </style>
            <div class="row">
                <div class="span3">Введите Площадь потолка :</div>
                <div class="span1"><input type="text" id="plos" class="input-mini" /></div>
                <div class="span1">м.кв.</div>
            </div>
            <div class="row">
                <div class="span5"><button id="plos_id" type="button" class="btn btn-success">Рассчитать</button></div>
            </div>

            <hr />
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>№ п\п</th>
                        <th>Наименование</th>
                        <th>ед. изм.</th>
                        <th>норма расхода</th>
                        <th>кол-во</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Гипсокартон</td>
                        <td>м2</td>
                        <td id="v1">1.05</td>
                        <td id="r1">0</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Профиль направляющий UD-27</td>
                        <td>м.п.</td>
                        <td id="v2"></td>
                        <td id="r2">0</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Профиль CD 60/27</td>
                        <td>м.п.</td>
                        <td id="v3">2.9</td>
                        <td id="r3">0</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Удлиннитель профилей 60/110</td>
                        <td>шт</td>
                        <td id="v4">0.2</td>
                        <td id="r4">0</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Соединитель профилей одноуровневый "Краб"</td>
                        <td>шт</td>
                        <td id="v5">1.7</td>
                        <td id="r5">0</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Подвес с разжимным элементом, поворотный для CD 60/27</td>
                        <td>шт</td>
                        <td id="v6">0.7</td>
                        <td id="r6">0</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Подвес Кольцо 250мм</td>
                        <td>шт</td>
                        <td id="v7">0.7</td>
                        <td id="r7">0</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Подвес прямой для CD 60/27 (скоба универсальная)</td>
                        <td>шт</td>
                        <td id="v8">0.7</td>
                        <td id="r8">0</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Саморез 3,5х9,5мм (блоха, семечка)</td>
                        <td>шт</td>
                        <td id="v9">30</td>
                        <td id="r9">0</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Саморез 3,5х25мм</td>
                        <td>шт</td>
                        <td id="v10">34</td>
                        <td id="r10">0</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>Дюбель 6х40 ДБМ</td>
                        <td>шт</td>
                        <td id="v11">0</td>
                        <td id="r11">0</td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td>Анкер клин 6х40</td>
                        <td>шт</td>
                        <td id="v12">0.7</td>
                        <td id="r12">0</td>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td>Лента для швов серпянка 45мм</td>
                        <td>м.п.</td>
                        <td id="v13">1.2</td>
                        <td id="r13">0</td>
                    </tr>
                    <tr>
                        <td>14</td>
                        <td>Шпаклёвка Фюгенфюллер (для швов)</td>
                        <td>кг</td>
                        <td id="v14">0.4</td>
                        <td id="r14">0</td>
                    </tr>
                    <tr>
                        <td>15</td>
                        <td>Грунтовка глубокого проникновения</td>
                        <td>литр</td>
                        <td id="v15">0.1</td>
                        <td id="r15">0</td>
                    </tr>
                    <tr>
                        <td>16</td>
                        <td>Шпаклёвка НР Finish, Satengips, Мультифиниш (для плоскости)</td>
                        <td>кг</td>
                        <td id="v16">1.2</td>
                        <td id="r16">0</td>
                    </tr>
                </tbody>
            </table>
            
            
            <script>
                document.getElementById("plos_id").addEventListener("click", function(){
                    // Get params
                    plos=$("#plos").val();
                    // Calc
                    // 1
                    v=$("#v1").html();
                    result=plos*v;
                    $("#r1").html(result.toFixed(2));
                    // 3
                    v=$("#v3").html();
                    result=plos*v;
                    $("#r3").html(result.toFixed(2));
                    // 4
                    v=$("#v4").html();
                    result=plos*v;
                    $("#r4").html(result.toFixed(2));
                    // 5
                    v=$("#v5").html();
                    result=plos*v;
                    $("#r5").html(result.toFixed(2));
                    // 6
                    v=$("#v6").html();
                    result=plos*v;
                    $("#r6").html(result.toFixed(2));
                    // 7
                    v=$("#v7").html();
                    result=plos*v;
                    $("#r7").html(result.toFixed(2));
                    // 8
                    v=$("#v8").html();
                    result=plos*v;
                    $("#r8").html(result.toFixed(2));
                    // 9
                    v=$("#v9").html();
                    result=plos*v;
                    $("#r9").html(result.toFixed(0));
                    // 10
                    v=$("#v10").html();
                    result=plos*v;
                    $("#r10").html(result.toFixed(0));
                    // 12
                    v=$("#v12").html();
                    result=plos*v;
                    $("#r12").html(result.toFixed(2));
                    // 13
                    v=$("#v13").html();
                    result=plos*v;
                    $("#r13").html(result.toFixed(2));
                    // 14
                    v=$("#v14").html();
                    result=plos*v;
                    $("#r14").html(result.toFixed(2));
                    // 15
                    v=$("#v15").html();
                    result=plos*v;
                    $("#r15").html(result.toFixed(2));
                    // 16
                    v=$("#v16").html();
                    result=plos*v;
                    $("#r16").html(result.toFixed(2));
                });
            </script>
        ';
        $content.=$f['text'];

    } elseif($ur=='calc-gk_stena'){
        $content.='
            <style>
                .row {line-height:1.8em;}
                .table thead tr th {text-align:center;}
                .table tbody tr td {text-align:center;}
                .table tbody tr td:nth-child(2) {text-align:left;}
                .table tbody tr td:nth-child(5) {font-weight:bold;}
            </style>
            <div class="row">
                <div class="span3">Введите Площадь стены :</div>
                <div class="span1"><input type="text" id="plos" class="input-mini" /></div>
                <div class="span1">м.кв.</div>
            </div>
            <div class="row">
                <div class="span5"><button id="action_id" type="button" class="btn btn-success">Рассчитать</button></div>
            </div>

            <hr />
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>№ п\п</th>
                        <th>Наименование</th>
                        <th>ед. изм.</th>
                        <th>норма расхода</th>
                        <th>кол-во</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Гипсокартон</td>
                        <td>м2</td>
                        <td id="v1">1.05</td>
                        <td id="r1">0</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Лента для швов серпянка 45мм</td>
                        <td>м.п.</td>
                        <td id="v2">1.2</td>
                        <td id="r2">0</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Шпаклёвка Фюгенфюллер (для швов)</td>
                        <td>кг</td>
                        <td id="v3">0.4</td>
                        <td id="r3">0</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Клей гипсовый, монтажный "Перфликс"</td>
                        <td>кг</td>
                        <td id="v4">3.5</td>
                        <td id="r4">0</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Грунтовка глубокого проникновения</td>
                        <td>литр</td>
                        <td id="v5">0.3</td>
                        <td id="r5">0</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Шпаклёвка НР Finish, Satengips, Мультифиниш (для плоскости)</td>
                        <td>кг</td>
                        <td id="v6">1.2</td>
                        <td id="r6">0</td>
                    </tr>
                </tbody>
            </table>
            <br />
            
              <script>
                document.getElementById("action_id").addEventListener("click", function(){
                    // Get params
                    plos=$("#plos").val();
                    // Calc
                    // 1
                    v=$("#v1").html();
                    result=plos*v;
                    $("#r1").html(result.toFixed(2));
                    // 2
                    v=$("#v2").html();
                    result=plos*v;
                    $("#r2").html(result.toFixed(2));
                    // 3
                    v=$("#v3").html();
                    result=plos*v;
                    $("#r3").html(result.toFixed(2));
                    // 4
                    v=$("#v4").html();
                    result=plos*v;
                    $("#r4").html(result.toFixed(2));
                    // 5
                    v=$("#v5").html();
                    result=plos*v;
                    $("#r5").html(result.toFixed(2));
                    // 6
                    v=$("#v6").html();
                    result=plos*v;
                    $("#r6").html(result.toFixed(2));
                });
            </script>
        ';
        $content.=$f['text'];

    } elseif($ur=='calc-gk_peregorodka'){
        $content.='
            <style>
                .row {line-height:1.8em;}
                .table thead tr th {text-align:center;}
                .table tbody tr td {text-align:center;}
                .table tbody tr td:nth-child(2) {text-align:left;}
                .table tbody tr td:nth-child(5) {font-weight:bold;}
            </style>
            <div class="row">
                <div class="span3">Введите Площадь стены :</div>
                <div class="span1"><input type="text" id="plos" class="input-mini" /></div>
                <div class="span1">м.кв.</div>
            </div>
            <div class="row">
                <div class="span5"><button id="action_id" type="button" class="btn btn-success">Рассчитать</button></div>
            </div>

            <hr />
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>№ п\п</th>
                        <th>Наименование</th>
                        <th>ед. изм.</th>
                        <th>норма расхода</th>
                        <th>кол-во</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Гипсокартон</td>
                        <td>м2</td>
                        <td id="v1">2.1</td>
                        <td id="r1">0</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Профиль направляющий UW-50, 75, 100мм</td>
                        <td>м.п.</td>
                        <td id="v2">0.7</td>
                        <td id="r2">0</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Профиль стоечный СW-50, 75, 100мм</td>
                        <td>м.п.</td>
                        <td id="v3">2</td>
                        <td id="r3">0</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Саморез 3,5х9,5мм (блоха, семечка)</td>
                        <td>шт</td>
                        <td id="v4">30</td>
                        <td id="r4">0</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Шпаклёвка Фюгенфюллер (для швов)</td>
                        <td>кг</td>
                        <td id="v5">0.9</td>
                        <td id="r5">0</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Лента для швов серпянка 45мм</td>
                        <td>шт</td>
                        <td id="v6">2.2</td>
                        <td id="r6">0</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Дюбель 6х40 ДБМ</td>
                        <td>шт</td>
                        <td id="v7">1.5</td>
                        <td id="r7">0</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Грунтовка глубокого проникновения</td>
                        <td>литр</td>
                        <td id="v8">0.2</td>
                        <td id="r8">0</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Плита минеральная (Базальтовая вата)</td>
                        <td>шт</td>
                        <td id="v9">1</td>
                        <td id="r9">0</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Шпаклёвка НР Finish, Satengips, Мультифиниш (для плоскости)</td>
                        <td>кг</td>
                        <td id="v10">1.2</td>
                        <td id="r10">0</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>Саморез 3,5х25мм</td>
                        <td>шт</td>
                        <td id="v11">34</td>
                        <td id="r11">0</td>
                    </tr>
                </tbody>
            </table>
            <br />
            
                <script>
                  document.getElementById("action_id").addEventListener("click", function(){
                    // Get params
                    plos=$("#plos").val();
                    // Calc
                    // 1
                    v=$("#v1").html();
                    result=plos*v;
                    $("#r1").html(result.toFixed(2));
                    // 2
                    v=$("#v2").html();
                    result=plos*v;
                    $("#r2").html(result.toFixed(2));
                    // 3
                    v=$("#v3").html();
                    result=plos*v;
                    $("#r3").html(result.toFixed(2));
                    // 4
                    v=$("#v4").html();
                    result=plos*v;
                    $("#r4").html(result.toFixed(2));
                    // 5
                    v=$("#v5").html();
                    result=plos*v;
                    $("#r5").html(result.toFixed(2));
                    // 6
                    v=$("#v6").html();
                    result=plos*v;
                    $("#r6").html(result.toFixed(2));
                    // 7
                    v=$("#v7").html();
                    result=plos*v;
                    $("#r7").html(result.toFixed(2));
                    // 8
                    v=$("#v8").html();
                    result=plos*v;
                    $("#r8").html(result.toFixed(2));
                    // 9
                    v=$("#v9").html();
                    result=plos*v;
                    $("#r9").html(result.toFixed(2));
                    // 10
                    v=$("#v10").html();
                    result=plos*v;
                    $("#r10").html(result.toFixed(2));
                    // 11
                    v=$("#v11").html();
                    result=plos*v;
                    $("#r11").html(result.toFixed(2));
                });
            </script>
        ';
        $content.=$f['text'];

    } elseif($ur=='calc-potolok_armstrong'){
        $content.='
            <style>
                .row {line-height:1.8em;}
                .table thead tr th {text-align:center;}
                .table tbody tr td {text-align:center;}
                .table tbody tr td:nth-child(2) {text-align:left;}
                .table tbody tr td:nth-child(5) {font-weight:bold;}
            </style>
            <div class="row">
                <div class="span3">Введите Площадь потолка :</div>
                <div class="span1"><input type="text" id="plos" class="input-mini" /></div>
                <div class="span1">м.кв.</div>
            </div>
            <div class="row">
                <div class="span3">Введите Периметр потолка:</div>
                <div class="span1"><input type="text" id="perim" class="input-mini" /></div>
                <div class="span1">м.кв.</div>
            </div>
            <div class="row">
                <div class="span5"><button id="action_id" type="button" class="btn btn-success">Рассчитать</button></div>
            </div>
      
            <hr />
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>№ п\п</th>
                        <th>Наименование</th>
                        <th>ед. изм.</th>
                        <th>норма расхода</th>
                        <th>кол-во</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Плита 600мм х 600мм (0,36м.кв.)</td>
                        <td>шт</td>
                        <td id="v1">2.78</td>
                        <td id="r1">0</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Профиль поперечный 0,6м</td>
                        <td>шт</td>
                        <td id="v2">1.5</td>
                        <td id="r2">0</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Профиль поперечный 1,2м</td>
                        <td>шт</td>
                        <td id="v3">1.5</td>
                        <td id="r3">0</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Профиль главный 3,6м</td>
                        <td>шт</td>
                        <td id="v4">0.25</td>
                        <td id="r4">0</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Профиль угловой, декоративный 3,0м</td>
                        <td>шт</td>
                        <td id="v5"></td>
                        <td id="r5">0</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Стержень с крючком (250, 500, 1000мм)</td>
                        <td>шт</td>
                        <td id="v6">0.7</td>
                        <td id="r6">0</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Стержень с кольцом (250, 500, 1000мм)</td>
                        <td>шт</td>
                        <td id="v7">0.7</td>
                        <td id="r7">0</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Подвес пружинный "Бабочка"</td>
                        <td>шт</td>
                        <td id="v8">0.7</td>
                        <td id="r8">0</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Анкер клин 6х40</td>
                        <td>шт</td>
                        <td id="v9">0.7</td>
                        <td id="r9">0</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Дюбель 6х40 (для крепления профиля углового 3м)</td>
                        <td>шт</td>
                        <td id="v10"></td>
                        <td id="r10">0</td>
                    </tr>
                </tbody>
            </table>
            <br />
            <script>
                  document.getElementById("action_id").addEventListener("click", function(){
                    // Get params
                    plos=$("#plos").val();
                    // Calc
                    // 1
                    v=$("#v1").html();
                    result=plos*v;
                    $("#r1").html(result.toFixed(2));
                    // 2
                    v=$("#v2").html();
                    result=plos*v;
                    $("#r2").html(result.toFixed(2));
                    // 3
                    v=$("#v3").html();
                    result=plos*v;
                    $("#r3").html(result.toFixed(2));
                    // 4
                    v=$("#v4").html();
                    result=plos*v;
                    $("#r4").html(result.toFixed(2));
                    // 6
                    v=$("#v6").html();
                    result=plos*v;
                    $("#r6").html(result.toFixed(2));
                    // 7
                    v=$("#v7").html();
                    result=plos*v;
                    $("#r7").html(result.toFixed(2));
                    // 8
                    v=$("#v8").html();
                    result=plos*v;
                    $("#r8").html(result.toFixed(2));
                    // 9
                    v=$("#v9").html();
                    result=plos*v;
                    $("#r9").html(result.toFixed(2));
                });
                $("#perim").change(function(){
                    // Get params
                    perim=$("#perim").val();
                    // Calc
                    // 5
                    v=$("#v5").html();
                    result=perim;
                    $("#r5").html(result.toFixed(2));
                    // 10
                    result=perim*2.5;
                    $("#r10").html(result.toFixed(2));
                });
            </script>
        ';
        $content.=$f['text'];

    } elseif($ur=='calc-uteplenie_sten'){
        $content.='
            <style>
                .row {line-height:1.8em;}
                .table thead tr th {text-align:center;}
                .table tbody tr td {text-align:center;}
                .table tbody tr td:nth-child(2) {text-align:left;}
                .table tbody tr td:nth-child(5) {font-weight:bold;}
            </style>
            <div class="row">
                <div class="span3">Введите Площадь стены :</div>
                <div class="span1"><input type="text" id="plos" class="input-mini" /></div>
                <div class="span1">м.кв.</div>
            </div>
            <div class="row">
                <div class="span3">Введите Периметр потолка:</div>
                <div class="span1"><input type="text" id="perim" class="input-mini" /></div>
                <div class="span1">м.кв.</div>
            </div>
            <div class="row">
                <div class="span5"><button id="action_id" type="button" class="btn btn-success">Рассчитать</button></div>
            </div>
 
            <hr />
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>№ п\п</th>
                        <th>Наименование</th>
                        <th>ед. изм.</th>
                        <th>норма расхода</th>
                        <th>кол-во</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Пенопласт, минеральная вата</td>
                        <td>м2</td>
                        <td id="v1">1</td>
                        <td id="r1">0</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Клей для систем теплоизоляции</td>
                        <td>кг</td>
                        <td id="v2">6</td>
                        <td id="r2">0</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Клей армирующий для систем теплоизоляции</td>
                        <td>кг</td>
                        <td id="v3">3</td>
                        <td id="r3">0</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Дюбель для СТИ</td>
                        <td>шт</td>
                        <td id="v4">5</td>
                        <td id="r4">0</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Сетка армирующая, фасадная, щёлочеустойчивая</td>
                        <td>м2</td>
                        <td id="v5">1</td>
                        <td id="r5">0</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Грунтовка глубокого проникновения (двойное нанесение)</td>
                        <td>литр</td>
                        <td id="v6">0.3</td>
                        <td id="r6">0</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Краска-грунт для декоративных штукатурок</td>
                        <td>литр</td>
                        <td id="v7">0.35</td>
                        <td id="r7">0</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Штукатурка декоративная "Барашек", "Короед" (сухая)</td>
                        <td>кг</td>
                        <td id="v8">7</td>
                        <td id="r8">0</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Краска в/э фасадная</td>
                        <td>литр</td>
                        <td id="v9">0.5</td>
                        <td id="r9">0</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Штукатурка декоративная "Барашек", "Короед" (готовая)</td>
                        <td>шт</td>
                        <td id="v10">3</td>
                        <td id="r10">0</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>Профиль цокольный, алюминевый</td>
                        <td>м.п.</td>
                        <td id="v11"></td>
                        <td id="r11">0</td>
                    </tr>
                </tbody>
            </table>
            <br />
            
                       <script>
                  document.getElementById("action_id").addEventListener("click", function(){
                    // Get params
                    plos=$("#plos").val();
                    // Calc
                    // 1
                    v=$("#v1").html();
                    result=plos*v;
                    $("#r1").html(result.toFixed(2));
                    // 2
                    v=$("#v2").html();
                    result=plos*v;
                    $("#r2").html(result.toFixed(2));
                    // 3
                    v=$("#v3").html();
                    result=plos*v;
                    $("#r3").html(result.toFixed(2));
                    // 4
                    v=$("#v4").html();
                    result=plos*v;
                    $("#r4").html(result.toFixed(2));
                    // 5
                    v=$("#v5").html();
                    result=plos*v;
                    $("#r5").html(result.toFixed(2));
                    // 6
                    v=$("#v6").html();
                    result=plos*v;
                    $("#r6").html(result.toFixed(2));
                    // 7
                    v=$("#v7").html();
                    result=plos*v;
                    $("#r7").html(result.toFixed(2));
                    // 10
                    v=$("#v10").html();
                    result=plos*v;
                    $("#r10").html(result.toFixed(2));
                });
                $("#perim").change(function(){
                    // Get params
                    perim=$("#perim").val();
                    // Calc
                    /* DISABLED
                    // 2
                    v=$("#v2").html();
                    result=perim;
                    $("#r2").html(result.toFixed(2));
                    // 11
                    result=perim*2;
                    $("#r11").html(result.toFixed(2));
                    */
                });
            </script>
        ';
        $content.=$f['text'];

    } elseif ($ur=='calc-gasbeton-stena'){
        $content.='
        <h3>Калькулятор газобетона</h3>
<div class="col-md-12 col-xs-12 col-sm-12">
  <div class="col-md-12 col-xs-12 col-sm-12">
    <fieldset>
    <p><label for="lengthallwalls">Размер газобетона:</label></p>
    <select id="razmer-bloka-gb" class="form-control" name="razmer-bloka-gb">
      <option value="3" data-p1="0.1" data-p2="0.2" data-p3="0.6">100х200х600</option>
      <option value="4" data-p1="0.1" data-p2="0.3" data-p3="0.6">100*300*600</option>
      <option value="7" data-p1="0.15" data-p2="0.2" data-p3="0.6">150х200х600</option>
      <option value="8" data-p1="0.15" data-p2="0.3" data-p3="0.6">150*300*600</option>
      <option value="9" data-p1="0.2" data-p2="0.2" data-p3="0.6">200х200х600</option>
      <option value="11" data-p1="0.2" data-p2="0.3" data-p3="0.6">200*300*600</option>
      <option value="11" data-p1="0.25" data-p2="0.3" data-p3="0.6">250*300*600</option>
      <option value="14" data-p1="0.3" data-p2="0.2" data-p3="0.6">300х200х600</option>
      <option value="16" data-p1="0.3" data-p2="0.3" data-p3="0.6">300*300*600</option>
      <option value="20" data-p1="0.4" data-p2="0.2" data-p3="0.6">400х200х600</option>
      <option value="22" data-p1="0.4" data-p2="0.3" data-p3="0.6">400*300*600</option>
      <option value="23" data-p1="0.5" data-p2="0.2" data-p3="0.6">500х200х600</option>
      <option value="23" data-p1="0.5" data-p2="0.3" data-p3="0.6">500х300х600</option>
    </select>
    </fieldset>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12">
    <fieldset class="field">
      <p><label for="lengthallwalls_gb">Длина стен, м:</label></p>
      <input type="text" class="form-control" max="99999" id="lengthallwalls_gb" name="lengthallwalls_gb">
    </fieldset>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12">
    <fieldset class="field">
      <p><label for="heightwall_gb">Высота стен, м:</label></p>
      <input type="text" class="form-control" max="99999" id="heightwall_gb" name="heightwall_gb">
    </fieldset>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12">
    <fieldset class="field">
      <p><label for="summwall_gb">Проемы (окна, двери), м<sup>2</sup>:</label></p>
      <input type="text" class="form-control" max="99999" id="summwall_gb" name="summwall_gb">
    </fieldset>
  </div>

  <div class="col-md-12 col-xs-12 col-sm-12">
    <span class="sprite-side btn-link g-buy-submit-light">
      <a href="javascript:void(0)" onclick="calculate_gazobeton();"><span class="g-buy-submit-link">Рассчитать</span></a>
    </span>
  </div>
    <div id="calc_result_gb"></div>
</div>
  
  <script>
    function calculate_gazobeton()
    {
      let razmer_bloka = $(`#razmer-bloka-gb`).val();
      let wall_length = parseFloat($(`#lengthallwalls_gb`).val().replace(/[^0-9.,]/g,``).replace(/,/g,`.`)) || 0;
      let wall_height = parseFloat($(`#heightwall_gb`).val().replace(/[^0-9.,]/g,``).replace(/,/g,`.`)) || 0;
      let square_windows_doors = parseFloat($(`#summwall_gb`).val().replace(/[^0-9.,]/g,``).replace(/,/g,`.`)) || 0; 
      let summ_square = ( wall_length * wall_height ) - square_windows_doors;
      let summ_volume = parseFloat(summ_square)*parseFloat($(`#razmer-bloka-gb option:selected`).data(`p1`)) ;
      let gazoblock_volume = parseFloat($(`#razmer-bloka-gb option:selected`).data(`p1`))*parseFloat($(`#razmer-bloka-gb option:selected`).data(`p2`))*parseFloat($(`#razmer-bloka-gb option:selected`).data(`p3`));
      let summ_quantity = summ_volume/gazoblock_volume;
      let result = ``;
      result += `Площадь стен: `+summ_square+` м2<br>`;
      result += `Обьем газобетона: `+summ_volume+` м3<br>`;
      result += `Количество газобетона: `+summ_quantity.toFixed(2)+` шт.`;
      $(`#calc_result_gb`).html(result);
    }
  </script>
        ';
    }

} else {
    $content=rce_404();
}
?>
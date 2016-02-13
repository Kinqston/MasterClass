<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/dropdown.js"></script>
<!--
<script type="text/javascript" src="js/funcybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="js/funcybox/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="js/funcybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="js/funcybox/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
-->
<link rel="stylesheet" href="js/datepicker/jquery-ui.css">
<script src="js/datepicker/jquery.js"></script>
<script src="js/datepicker/jquery-ui.js"></script>
<script src="js/datepicker/jquery.ui.datepicker-ru.js"></script>
<!--<link rel="stylesheet" href="/resources/demos/style.css">-->


<!--<span id="spantabs"><a href="#" onClick="setSom2();">�������� 1</a></span>
<span id="test_value">���</></span>
<button id="but1">Ajax</button>-->

<script type="text/javascript">

  var groupAj;
  var dateAj;
  function selChange(who) {
    //alert("who!!!  "+who);
    if(selGroup.options[selGroup.selectedIndex].value != "") {
      groupAj = "group="+selGroup.options[selGroup.selectedIndex].value;
    }
    else {
      groupAj = "group=*";
    }
    $r = groupAj;
    SendAj('http://WofT/book/groupTable',$r, "allReiTable");
  };

  function SendAj($adr, $tAj, $cont) {
    if (window.XMLHttpRequest) req = new XMLHttpRequest();
    else if (window.ActiveXObject) {
      try {
        req = new ActiveXObject('Msxml2.XMLHTTP');
      } catch (e) {
      }
      try {
        req = new ActiveXObject('Microsoft.XMLHTTP');
      } catch (e) {
      }
    }
    if (req) {
      req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
          //alert(req.responseText);
          document.getElementById($cont).innerHTML = req.responseText;
        }
      };
      req.open("POST", $adr, true);
      req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      req.send($tAj);
    }
    else alert("Не работает AJAX");
  };

</script>

  <!--построение группы-->
  <select id="selGroup" onChange="selChange('filter')">
    <option value="">Все группы</option>;
        <?php
          for($i=0; $i<count($data["groups"]); $i++) {
            echo '<option value="'.$data["groups"][$i]["group_name"].'">'.$data["groups"][$i]["group_name"].'</option>';
          };
        ?>
  </select>
<!--  <select id="selDate" onChange="selChange.cal()">
    <option value="">Любая дата</option>;
    <?/*php
      for($i=0;$i<count($data["dates"]); $i++) {
        echo '<option value='.$data["dates"][$i]["ev_date"].'>'.$data["dates"][$i]["ev_date"].'</option>';
      }*/
    ?>
  </select>
-->

<div id="allReiTable"> <h3> Укажите группу! </h3> </div>
</body>

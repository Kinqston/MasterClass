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
  var dateFilter = "*";
  $(function() {
    $( "#datepicker" ).datepicker({
      onClose: function(dateText, inst) {
        dateFilter = dateText;
        selChange("filter");
        //alert("Календарь закрыт с датой: "+dateText);
      }
    });
  });


  function start() {
    var quer = "group=*&date=*&who=filter";
    SendAj('http://WofT/book/dat', quer, "mainContent");
  }


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
    if(dateFilter != "") {
      dateAj = "date="+dateFilter;
    }
    else {
        dateAj = "date=*"
    }
    if(who == "filter") {
      $r = groupAj+"&"+dateAj+"&"+"who=filter";
    }
    else {
      $r = groupAj+"&"+dateAj+"&"+"who="+who;
    }
    //alert($r);
    SendAj('http://WofT/book/dat',$r, "mainContent");
  };

  function saveMarks(id, i) {
    //alert("OnChange"+document.getElementById('beOrNot'+i).options[document.getElementById('beOrNot'+i).selectedIndex].value);
    var be = "be="+document.getElementById('beOrNot'+i).options[document.getElementById('beOrNot'+i).selectedIndex].value;
    var mark = "mark="+document.getElementById('marks'+i).options[document.getElementById('marks'+i).selectedIndex].value;
    var group_id = "group_id="+document.getElementById('group_id').value;
    var event_id = "event_id="+document.getElementById('event_id').value;
    var aj = "student_id="+id+"&"+group_id+"&"+event_id+"&"+be+"&"+mark;
    //alert("inp "+ aj);
    SendAj('http://WofT/book/beMarks', aj, "vsContent");
  }

  function Trying() {
    SendAj('http://WofT/book/fromCalendar', "event=250", "mainContent");
  }

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

  function saveStudent() {
    //alert("save?");
    var group_active;
    if(document.getElementById("group").value == "") {
      group_active = "notchanged";
    }
    else if (document.getElementById("group").value == "Не распределен") {
      group_active = "notgroup";
    }
    else {
      group_active = document.getElementById("group").value;
    }
    var s = "id="+document.getElementById("sys").value+"&user_info="+document.getElementById("user_info").value+
              "&group="+group_active+"&contacts="+document.getElementById("contacts").value;
    //alert(s);
    //процедура отправки на сервер
    SendAj('http://WofT/book/savestudent', s, "mainContent");
  }

</script>

  <!--построение группы-->

  <div>
  <div style="float: left">
    <select id="selGroup" onChange="selChange('filter')">
      <option value="">Все группы</option>;
          <?php
            for($i=0; $i<count($data["groups"]); $i++) {
              echo '<option value="'.$data["groups"][$i]["group_name"].'">'.$data["groups"][$i]["group_name"].'</option>';
            };
          ?>
    </select>
  </div>
  <div style="text-align: center">
    <a href="http://WofT/rei"> Подробный рейтинг </a>
  </div>

<!--  <div style="float: right">
    <a href="http://WofT/book"> Сброс </a>
  </div>
  </div>
-->

<!--
  <a class="modalbox" href="#newstud">Добавить ученика</a>


  <style type=”text/css”>
    #newstud { display: none; }
  </style>

  <div id="newstud" style="display:none">
    <h2>Отправка сообщения</h2>

    <form id="contact" name="contact" action="#" method="post">
      <label for="email">Ваш E-mail</label>
      <input type="email" id="email" name="email" class="txt">
      <br>
      <label for="msg">Введите сообщение</label>
      <textarea id="msg" name="msg" class="txtarea"></textarea>

      <button id="send">Отправить E-mail</button>
    </form>
  </div>
  -->
<body onload="start()">

<!-- <input type="button" value="Проверка" onClick="Trying()"> </input> -->

<div id="mainContent"></div>
<div id="vsContent"></div>
</body>

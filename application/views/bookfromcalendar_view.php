<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<script type="text/javascript">
  function saveMarks(id, i) {
    //alert("OnChange"+document.getElementById('beOrNot'+i).options[document.getElementById('beOrNot'+i).selectedIndex].value);
    var be = "be="+document.getElementById('beOrNot'+i).options[document.getElementById('beOrNot'+i).selectedIndex].value;
    var mark = "mark="+document.getElementById('marks'+i).options[document.getElementById('marks'+i).selectedIndex].value;
    var group_id = "group_id="+document.getElementById('group_id').value;
    var event_id = "event_id="+document.getElementById('event_id').value;
    var aj = "student_id="+id+"&"+group_id+"&"+event_id+"&"+be+"&"+mark;
    //alert("inp "+ aj);
    SendAj('http://WofT/book/beMarks', aj, "mainContent");
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

</script>
<!--
<div id="mainContent"></div>

<div id="vsContent"></div>

-->
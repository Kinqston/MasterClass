<?php
//iconv("UTF-8", "windows-1251",..)
class Controller_Book extends Controller
{
    public $bK;
    function __construct() {
        $this->view = new View();
        $this->model = new Model_Book();
    }

    function changeStudent($n_dat)
    {
        //var_dump($n_dat);
        $re = '<h2>Изменение личных данных студента</h2><br>';
        $re .= '<div class="row">';
        //<form role="form" method="POST"   >
        $re .= '<div class="form-group">';
        $re .= '<label for="user_info">ФИО</label>';
        $re .= '<input type="text" class="form-control" id="user_info" name="user_info" value="'.$n_dat["user_info"].'"> </div>';
        $re .= '<div class="form-group">';
        $re .= '<label for="group">Выберите группу</label>';
        $re .= '<select class="form-control" name="group" id="group">';
 /*       $re .= '<option>Не распределен</option>';*/
        $groups = $this->model->prepareHeader();
        foreach($groups["groups"] as $group) {
            if($group["group_name"] == $n_dat["group_name"]) {
                $re .= '<option selected value>' . $group["group_name"] . '</option>';
            }
            else {
                $re .= '<option>' . $group["group_name"] . '</option>';
            }
        }
        $re .= '</select></div>';
        $re .= '<div class="form-group">';
        $re .= '<label for="contacts">Контактная информация</label>';
        $re .= '<input type="text" class="form-control" id="contacts" name="contacts" value="'.$n_dat["contacts"].'"></div>';
        $re .= '<input name="OK" type="submit" class="btn btn-default" value="Сохранить" onclick="saveStudent();">';
        $re .= '<a href="book"> Отмена </a></form>';
        $re .= '<input type="hidden" class="form-control" id="sys" name="sys" value="'.$n_dat["id"].'"></div>';
        $re .= '</div></div>';

        echo $re;
    }

    function action_beMarks() {
        $this->model->updateMarks($_POST["student_id"], $_POST["group_id"], $_POST["event_id"], $_POST["be"], $_POST["mark"]);
    }

    function action_savestudent()   {
        echo "<h4>Изменения сохранены!</h4>";
        $this->model->saveStudentInBase($_POST["id"], $_POST["user_info"], $_POST["group"], $_POST["contacts"]);
    }

    function action_fromCalendar($event_id) {
        //$event_id = $_POST["event"];
        $dat = $this->model->aboutEvent($event_id[0]);
        $this->view->generate('bookfromcalendar_view.php','template_view.php', $this->model->prepareHeader());
        $this->dataSveden($dat["group_name"], $dat["date"]);
    }

    function dataSveden($group_name, $event_date) {
        $res = $this->model->getWithGroupAndDate($group_name, $event_date);
        //далее оформить вывод
        if($res != 0) {
            //шапка после фильтров
            $ind = $res[0]["ind_func"];
            if($res[$ind]["professor"]["user_info"] != "") {
                $re = '<h5><b>Преподаватель: </b>' . $res[$ind]["professor"]["user_info"] . '</h5>';
            }
            else {
                $re = '<h5><b>Преподаватель:</b> <i>не указан</i></h5>';
            }
            $re .= '<h5><b>Группа: </b> <i>'.$res[$ind]["group"]["name"].'</i><input id="group_id" type="hidden" value="'.$res[$ind]["group"]["id"].'"></h5>';
            $re .= '<h5><b>Занятие: </b> <i>'.$res[$ind]["event"]["date"].'</i><input id="event_id" type="hidden" value="'.$res[$ind]["event"]["id"].'"></h5>';
            //
            $re .= ('<table class="table"> <thead> <tr> <th>ФИО</th> <th>Посещение</th> <th>Оценка</th> <th>Рейтинг</th> </tr> </thead>');
            //$res[0]["COUNT(*)"];
            $re .= ('<tbody>');
            if(!$this->model->right()) {
                //здесь пишем для админа
                for ($i = 0; $i < count($res); $i++) {
                    $re .= '<tr><td>' . $res[$i]["user_info"] . '</td><td>';
                    $re .= '<select id="beOrNot'.$i.'" onChange="saveMarks('.$res[$i]["id"].','.$i.')">';
                    for($j=0; $j<2; $j++) {
                        if($j == 0) {$op = "Нет";} else {$op = "Да";}
                        if($res[$i]["visit"] == $j) {
                            $re .= '<option selected value="'.$op.'">'.$op.'</option>';
                        }
                        else {
                            $re .= '<option value="'.$op.'">'. $op . '</option>';
                        }
                    }
                    $re .= '</select> </td><td><select id="marks'.$i.'" onChange="saveMarks('.$res[$i]["id"].','.$i.')">';
                    for($j=0; $j<11; $j++) {
                        if($res[$i]["mark"] == $j) {
                            $re .= '<option selected value="'.$j.'">'.$j.'</option>';
                        }
                        else {
                            $re .= '<option value="'.$j.'">'.$j.'</option>';
                        }
                    }
                    $re .= '</select></td><td id="rei'.$i.'">';
                    $re .=  $res[$i]["rei"] . ' из ' . $res[$i]["allRei"] . '</td></tr>';
                }
            }
            else {
                for ($i = 0; $i < count($res); $i++) {
                    if($res[$i]["visit"] == 0) {
                        $res[$i]["visit"] = "Нет";
                    } else {
                        $res[$i]["visit"] = "Да";
                    }
                    $re .= '<tr><td>' . $res[$i]["user_info"] . '</td><td>' . $res[$i]["visit"] . '</td><td>' . $res[$i]["mark"] . '</td><td>' .
                        $res[$i]["rei"] . ' из ' . $res[$i]["allRei"] . '</td></tr>';
                }
            }
            $re .= ('</tbody>');
            echo $re;
            //echo "         res:    ". var_dump($res). "         ";
        }
        else {
            echo "<h3>Нет событий для выбранной группы на заданное число!</h3>";
        }
    }

    function action_dat()
    {
        //header('Content-Type: application/json ');
        //echo $this->model->getDat();
 /*       header('Content-type: text/html; charset=windows-1251');*/
//права        echo $this->model->right();
        //echo var_dump($_POST);
        if($_POST["who"] == "filter") {
            //echo $_POST["group"]. "   " . $_POST["date"];
            if(isset($_POST['group']) && ($_POST['date'] == "*")) {
                //echo "ajax!  " + $_POST['group'];
                //$re = ('<table class="table"> <thead> <tr> <th>���</th> <th>�������</th> </tr> </thead>');

                if (isset($_POST['group'])) {
                    $res = $this->model->getOnlyGroup($_POST['group']);
                    //echo var_dump($res);
                }
                //$re = $_POST['group'];
                if($_POST['group'] == '*') {
                    $re = ('<table class="table"> <thead> <tr> <th>ФИО</th> <th>Контакты</th> <th>Группа</th> </tr> </thead>');
                } else {
                    $re = ('<table class="table"> <thead> <tr> <th>ФИО</th> <th>Контакты</th> <th>Группа</th> <th>Посещения</th> <th>Рейтинг</th> </tr> </thead>');
                }

                $re .= ('<tbody>');
                for ($i = 0; $i < count($res[1]); $i++) {
                    $re .= '<tr><td>' . $res[1][$i]["user_info"] . '</td><td>' . $res[1][$i]["contacts"] .
                        '</td><td>' . $res[1][$i]["group_name"] . '</td>';
                    if($_POST['group'] != '*') {
                        //выводим рейтинг
                        $re .= '<td>'.$res[1][$i]["visit"].' из '.$res[0].'</td><td>'.$res[1][$i]["rei"].' из '.($res[0]*10).'</td>';
                        if (!$this->model->right()) {
                            $idI = "num" . $i;
                            $onCl = 'onclick=selChange('.$i.')';
                            $re .= '<td>' . '<img src="/images/img_ch.jpg" id=' . $idI .' '.$onCl. '></td>';
                        }
                    }
                    $re .= '</tr>';
                }
                $re .= '</tbody>';
                /*    echo iconv("windows-1251", "UTF-8", $re);*/
                echo $re;
            }
            if(($_POST['date'] != "*") && ($_POST['group'] == "*")) {
                echo "<h3>Выберите группу!</h3>";
            }
            if(($_POST['date'] != "*") && ($_POST['group'] != "*")) {

                $this->dataSveden($_POST['group'], $_POST['date']);

            }
        }
        else {
            $res = $this->model->getOnlyGroup($_POST['group']);
            //echo $res[$_POST["who"]]["user_info"];
            //var_dump($res);
            //var_dump($res[1][$_POST["who"]]);
            $this->changeStudent($res[1][$_POST["who"]]);
        }
    }

    function action_index()
    {
        //$res["dat"] = $this->model->BaseOut();
        //$this->view->generate('book_view.php','template_view.php', $this->model->prepareHeader());
        $this->view->generate('book_view.php', 'Template_view.php', $this->model->prepareHeader());
    }

    function action_rei()
    {
        $this->view->generate('book_allRei.php', 'Template_view.php', $this->model->prepareHeader());
    }

    function action_groupTable()
    {
        //echo $_POST["group"];
        //запросить список группы
        //запросить список событий для группы
        //найти пересечения и оценки
        $r = $this->model->reiTable($_POST["group"]);

        $t = '<table class="table"><tbody>';
        $t .= '<tr><td>            </td>';
        for($i=0; $i<count($r["event"]); $i++) {
            $t .= '<td align="center"><b>'.$r["event"][$i]["ev_date"].'</b></td>';
        }
        $t .= '</tr>';

        for($i=0; $i<count($r["stud"]); $i++) {
            $t .= '<tr><td><b>'.$r["stud"][$i]["user_info"].'</b></td>';
            for($j=0; $j<count($r["event"]); $j++) {
                $t .= '<td align="center">'.$this->model->markTable($r["event"][$j]["id"], $r["stud"][$i]["id"], $r["gr"]).'</td>';

            }
            $t .= '</tr>';
        }
        $t .= '</tbody></table>';
        echo $t;
    }
}

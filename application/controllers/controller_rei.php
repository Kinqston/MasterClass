<?php
//iconv("UTF-8", "windows-1251",..)
class Controller_rei extends Controller
{
    public $bK;
    function __construct() {
        $this->view = new View();
        $this->model = new Model_Book();
    }

    function action_index()
    {
        $this->view->generate('book_allRei.php', 'Template_view.php', $this->model->prepareHeader());
    }

    function action_groupTable()
    {
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

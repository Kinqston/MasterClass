<?php
Class Model_Book extends Authorization {

    function prepareHeader() {
        $qrGr = "SELECT group_name FROM groups";
        $this->prepare($qrGr);
        $data["groups"] = $this->execute_all();
        $qrD = "SELECT ev_date FROM events";
        $this->prepare($qrD);
        $data["dates"] = $this->execute_all();
        //$data = $this->executeQuery_All();
        //$data["groups"]["rows"] = count($data["droups"]);
        $data['login'] = $this->get_login();
        return $data;
    }

    function right() {
        if($this->get_rights() & U_EDIT) {
            return 0;
        }
        else {
            return 1;
        }
    }

    public function reiTable($group) {
        $quer = 'SELECT id FROM groups WHERE group_name=:gr';
        $this->prepare($quer);
        $this->query->bindParam(":gr", $group, PDO::PARAM_STR);
        $gr = $this->execute_all();
        //return $gr[0]["id"];

        $quer = 'SELECT id, user_info FROM users WHERE group_id=:id_group';
        $this->prepare($quer);
        $this->query->bindParam(":id_group", $gr[0]["id"], PDO::PARAM_STR);
        $students = $this->execute_all();

        $quer = 'SELECT id, ev_date FROM events WHERE ev_group=:id_group';
        $this->prepare($quer);
        $this->query->bindParam(":id_group", $gr[0]["id"], PDO::PARAM_STR);
        $events = $this->execute_all();

        $rs["gr"] = $gr[0]["id"];
        $rs["stud"] = $students;
        $rs["event"] = $events;

        return $rs;
    }

    public function markTable($event, $stud, $gr) {
        $quer = 'SELECT mark FROM marks WHERE id_event=:ev AND id_student=:st AND id_group=:gr';
        $this->prepare($quer);
        $this->query->bindParam(":ev", $event, PDO::PARAM_STR);
        $this->query->bindParam(":st", $stud, PDO::PARAM_STR);
        $this->query->bindParam(":gr", $gr, PDO::PARAM_STR);
        $mark = $this->execute_all();
        //return var_dump($mark);
        if($mark == NULL) {
            return 0;
        }
        else {
            return $mark[0]["mark"];
        }
    }
}
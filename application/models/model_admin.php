<?php
Class Model_Admin extends Authorization {
    function get_professors() {
        $this->prepare("SELECT id,user_info FROM users WHERE rights >= ".U_PROFESSOR." AND if_stuff = 1");
        return $this->execute_all();
    }
    function get_groups() {
        $this->prepare("SELECT id,group_name FROM groups");
        return $this->execute_all();
    }
    function check_date() { //TODO
    }
    function get_id($array,$find_str,$column_name) {
        return (int) $array[ array_search($find_str,array_column($array, $column_name) ) ]["id"];
    }
    function get_date($date) {
        if(!empty($date)) {
            $date_arr = explode("-", $date[0]);
            if (strlen($date[0]) >= 8 && substr_count($date[0], "-") == 2) // TODO  написать нормальную проверку даты
                return $date_arr[2] . "-" . $date_arr[0] . "-" . $date_arr[1];
        }
        return false;
    }
    function delete_event($id) {
        $this->prepare("DELETE FROM events WHERE id=:id");
        $this->query->bindParam(":id",$id,PDO::PARAM_INT);
        $this->execute_simple();
    }
    function create_event($event) {
        $this->prepare("INSERT INTO events(id,professor,ev_group,ev_date,ev_text)
VALUES (NULL,:professor_id,:group_id,:ev_date,:ev_text)");
        $this->query->bindParam(":professor_id",$event->professor_id,PDO::PARAM_INT);
        $this->query->bindParam(":group_id",$event->group_id,PDO::PARAM_INT);
        $this->query->bindParam(":ev_date",$event->ev_date,PDO::PARAM_STR);
        $this->query->bindParam(":ev_text",$event->ev_text,PDO::PARAM_STR);
        $this->execute_simple();
    }
    function get_event($id) {
        $this->prepare("SELECT events.id,events.ev_date,events.ev_text,users.user_info,groups.group_name
FROM events,users,groups WHERE events.id=:id AND events.ev_group = groups.id AND events.professor=users.id");
        $this->query->bindParam(":id",$id,PDO::PARAM_INT);
        return $this->execute_row();
    }
    function update_event($event,$id) {
        $this->prepare("UPDATE `events` SET
`professor`=:professor_id,`ev_group`=:group_id,`ev_date`=:ev_date,`ev_text`=:ev_text WHERE id=:id");
        $this->query->bindParam(":professor_id",$event->professor_id,PDO::PARAM_INT);
        $this->query->bindParam(":group_id",$event->group_id,PDO::PARAM_INT);
        $this->query->bindParam(":ev_date",$event->ev_date,PDO::PARAM_STR);
        $this->query->bindParam(":ev_text",$event->ev_text,PDO::PARAM_STR);
        $this->query->bindParam(":id",$id,PDO::PARAM_INT);
        return $this->execute_simple();
    }
    function upgrade_rights($id) {
        $rights = U_PROFESSOR;
        $this->prepare("UPDATE `users` SET `rights`=:rights WHERE `id`=:id");
        $this->query->bindParam(":rights",$rights,PDO::PARAM_INT);
        $this->query->bindParam(":id",$id,PDO::PARAM_INT);
        return $this->execute_simple();

    }
    function add_group($group_name) {
        $this->prepare("INSERT INTO groups(group_name) VALUES (:group_name)");
        $this->query->bindParam(":group_name",$group_name,PDO::PARAM_STR);
        return $this->execute_simple();
    }
    function delete_group($group_name) {
        $this->prepare("DELETE FROM groups WHERE group_name=:group_name");
        $this->query->bindParam(":group_name",$group_name,PDO::PARAM_STR);
        return $this->execute_simple();
    }
    function get_professors_list(){
        $this->prepare("SELECT user_info,login FROM users WHERE rights < :u_edit AND if_stuff = '1'");
        $this->query->bindValue(":u_edit",U_EDIT,PDO::PARAM_INT);
        return $this->execute_all();
    }
}
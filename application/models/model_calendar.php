<?php
Class Model_Calendar extends Authorization {
    public function get_events() {
        $this->prepare("SELECT events.*,groups.group_name,users.user_info FROM events,groups,users WHERE users.id=professor AND groups.id=ev_group");
        $events_array = $this->execute_all();
        $json_encoded_array = [];


        foreach($events_array as $element_event) {
            $date_event = (new DateTime($element_event["ev_date"]))->format('m-d-Y');
            $event_text =
            "<span class='event' data-id='{$element_event["id"]}'>
                <span class='ev_group'>Группа: <span id='group'>{$element_event["group_name"]}</span></span>
                <span class='ev_professor'>Профессор: <span id='professor'>{$element_event["user_info"]}</span></span>
                <span class='ev_text'>{$element_event["ev_text"]}</span>
            </span>";

            if(array_key_exists($date_event,$json_encoded_array)) {
                if(!is_array($json_encoded_array[$date_event])) {
                    $buffer = $json_encoded_array[$date_event];
                    $json_encoded_array[$date_event] = [];
                    array_push($json_encoded_array[$date_event],$buffer);
                }
                array_push($json_encoded_array[$date_event],$event_text);
            }
            else
                $json_encoded_array[$date_event] = $event_text;
        }
        return json_encode($json_encoded_array);

    }
}
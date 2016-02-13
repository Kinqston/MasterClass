all_events = $("div.custom-content-reveal > span.event").clone();
function show_hide() {
    current = $(this).children(":selected").data()["relation"];
    all_events.each(function(i,e) {
        if(i == current) {
            $(".custom-content-reveal > .event").remove();
            $("div.custom-content-reveal").append(e);
        }
    });
}
if(all_events.length > 1) {
    $(".ca_container").append("<div class='col-md-6 select_container'><select class='form-control select'></select></div>");
    all_events.each(function(i) {
        $(".select").append("<option class='option' data-relation='"+i+"'>"+$(this).find("#group").text()+" | "+$(this).find("#professor").text()+"</option>");
    });
    $(".select").change(show_hide);
    $("div.custom-content-reveal > span.event:not(:first)").remove();
}
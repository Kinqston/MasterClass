<style>
    .calendar_li {
        background-color: #87d2c7;
        border-radius: 5px;
    }
</style>
<style>
    .ca_container {
        margin-top: -29px;
        height: 25px;
        /*background-color: red;*/
    }
    .select_container {
        margin-right: 2px;
        padding: 0;
    }
    .event_button {
        cursor: pointer;
        background-color: white;
        height: 25px;
        text-align: center;
        border: 1px solid;
        margin-right: 2px;
        border-radius: 4px;
    }
    .event_button:hover {
        overflow: hidden;
        border-color: dodgerblue;
    }
    .select {
        border: 1px solid;
        padding: 0;
        height: 25px;
        font-size: 14px;
        border-radius: 4px;
    }
    .select:focus {
        box-shadow: none;
    }
    #link {
        color: black;
        padding: 0;
        font-size: 14px;
    }
    #link:hover {
        text-decoration: none;
    }
    .event > .ev_professor,.event > .ev_group,#group,#professor {
        padding: 0;
        text-align: left;
        font-size: 16px;
    }
    #group,#professor {
        display: inline;
    }
    .menu {
        position: absolute;
        border: 1px solid grey;
        background-color: white;
        padding: 5px 0 5px 0;
    }
    .menu > span {
        font-size: 12px;
        cursor: context-menu;
        padding: 0 10px 0 10px;
        display: block;
    }
    .menu > span:hover {
        color: white;
        background-color: #2a6496;
    }
</style>
<div class="container">
        <section class="main">
            <?php if($data["rights"] & U_EDIT): ?>
            <p class="bg-info">Нажимай правую кнопку мыши на определенной дате, чтобы редактировать события</p>
            <?php endif; ?>
                <div class="custom-calendar-wrap">
                        <div id="custom-inner" class="custom-inner">
                                <div class="custom-header clearfix"> <!-- шапка -->
                                        <nav> <!-- стрелочки влево вправо -->
                                                <span id="custom-prev" class="custom-prev"></span>
                                                <span id="custom-next" class="custom-next"></span>
                                        </nav>
                                        <h2 id="custom-month" class="custom-month"></h2> <!-- месяц в шапке -->
                                        <h3 id="custom-year" class="custom-year"></h3> <!-- год в шапке -->
                                </div>
                                <div id="calendar" class="fc-calendar-container"></div> <!-- тело календаря -->
                        </div>
                </div>
        </section>
</div>
<script type="text/javascript" src="js/jquery.calendario.js"></script>
<script type="text/javascript">


    function Menu() {
        this.init = function(menu_class) {
            this.element = $("<div class='" + menu_class + " menu" + "' oncontextmenu='return false'></div>");
        };
        this.get = function() {
            return this.element || $("<div class='menu' oncontextmenu='return false'></div>");;
        };
        this.draw = function(x,y) {
            this.x = x;
            this.y = y;

            this.element.css({
                "left": x + "px",
                "top": y + "px",
                "display": "block"
            });
            $("body").append(this.element);
        };
        this.hide = function() {
            this.element.css({
                "display": "none"
            });
        };
        this.count = function() {
            return this.element.find("span").length;
        };
        this.width = function() {
            return this.element.width() + 1;
        };
        this.span_height = function() {
            return this.element.find("span:first").height();
        };
        this.delete_span = function() {
            this.element.find("span").remove();
        }

    }

    main_menu = new Menu();
    main_menu.init('main_menu');

    child_menu = new Menu();
    child_menu.init('child_menu');


    $("body").bind("click",function(){
        main_menu.hide();
        child_menu.hide();
    });
    /// RIGHTS
    const U_EDIT = 1 << 1;
    /// RIGHTS
        $.ajax({
                url: "/calendar/date",
                success: function(codropsEvents){
                         $(function() {
                                var transEndEventNames = {
                                            'WebkitTransition' : 'webkitTransitionEnd',
                                            'MozTransition' : 'transitionend',
                                            'OTransition' : 'oTransitionEnd',
                                            'msTransition' : 'MSTransitionEnd',
                                            'transition' : 'transitionend'
                                    },
                                    transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
                                    $wrapper = $( '#custom-inner' ),
                                    $calendar = $( '#calendar' ),
                                    cal = $calendar.calendario( {
                                            onDayClick : function( $el, $contentEl, dateProperties, rights, event ) {
                                                events = $contentEl.find(".event");
                                                if(event.button == 2) {

                                                    child_menu.hide();
                                                    main_menu.delete_span();

                                                    if (rights & U_EDIT) {
                                                        url = "/admin/create_event/" + dateProperties.month + "-" + dateProperties.day + "-" + dateProperties.year;
                                                        if (main_menu.count() < 1)
                                                            main_menu.element = main_menu.get().append("<span onclick='(function(){ window.location.replace(url); }())'>Добавить новое</span>");
                                                        main_menu.draw(event.pageX, event.pageY);
                                                        if (events.length > 0) {
                                                            if (main_menu.count() < 2) {

                                                                span = $("<span>Удалить</span>").bind("mouseover", function () {
                                                                    child_menu.delete_span();

                                                                    child_menu.draw(main_menu.x + main_menu.width(), main_menu.y + main_menu.span_height() + 6);
                                                                    events.each(function (item, element) {
                                                                        if (child_menu.count() < events.length) {
                                                                            span = $("<span>" + $(element).find("#group").text() + " | " + $(element).find("#professor").text() + "</span>")
                                                                                .bind("click", function () {
                                                                                    $.ajax({
                                                                                        url: "/admin/delete_event/" + $(element).data()["id"],
                                                                                        success: function () {
                                                                                            window.location.replace("/calendar");
                                                                                        }
                                                                                    });
                                                                                });
                                                                            child_menu.element = child_menu.get().append(span);
                                                                        }
                                                                    });


                                                                });
                                                                main_menu.element = main_menu.get().append(span);
                                                            }

                                                            if (main_menu.count() < 3) {

                                                                span = $("<span>Обновить</span>").bind("mouseover", function () {
                                                                    child_menu.delete_span();

                                                                    child_menu.draw(main_menu.x + main_menu.width(), main_menu.y + (main_menu.span_height() * 2) + 6);
                                                                    events.each(function (item, element) {
                                                                        if (child_menu.count() < events.length) {
                                                                            span = $("<span>" + $(element).find("#group").text() + " | " + $(element).find("#professor").text() + "</span>")
                                                                                .bind("click", function () {
                                                                                    window.location.replace("/admin/update_event/" + $(element).data()['id']);
                                                                                });
                                                                            child_menu.element = child_menu.get().append(span);
                                                                        }
                                                                    });


                                                                });
                                                                main_menu.element = main_menu.get().append(span);
                                                            }
                                                        }
                                                    }
                                                    }
                                                    else
                                                        if( $contentEl.length > 0 ) {
                                                                showEvents( $contentEl, dateProperties );
                                                        }
                                            },
                                            caldata : codropsEvents,
                                            displayWeekAbbr : true
                                    } ),
                                    $month = $( '#custom-month' ).html( cal.getMonthName() ),
                                    $year = $( '#custom-year' ).html( cal.getYear() );

                                $( '#custom-next' ).on( 'click', function() {
                                        cal.gotoNextMonth( updateMonthYear );
                                } );
                                $( '#custom-prev' ).on( 'click', function() {
                                        cal.gotoPreviousMonth( updateMonthYear );
                                } );

                                function updateMonthYear() {
                                        $month.html( cal.getMonthName() );
                                        $year.html( cal.getYear() );
                                }

                                function showEvents( $contentEl, dateProperties ) {
                                    hideEvents();

                                        var $events = $( '<div id="custom-content-reveal" class="custom-content-reveal"><h4>Событие на ' + dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year + '</h4>' +
                                                '<div class="ca_container"></div></div>' ),
                                            $close = $( '<span class="custom-content-close"></span>' ).on( 'click', hideEvents );

                                        $events.append( $contentEl.html() , $close ).insertAfter( $wrapper );

                                        setTimeout( function() {
                                                $events.css( 'top', '0%' );
                                        }, 25 );

                                    $.getScript("js/several_events.js");

                                    var journal_button = $("<div class='col-md-3 event_button'><a id='link' >Журнал</a></div>");
                                    journal_button.bind("click",function() {
                                        window.location.replace("/book/fromCalendar/" + $(".custom-content-reveal").find("span.event").data()['id']);
                                    });
                                    $(".ca_container").append(journal_button);
                                }
                                function hideEvents() {


                                        var $events = $( '#custom-content-reveal' );
                                        if( $events.length > 0 ) {

                                                $events.css( 'top', '100%' );
                                            $events.animate({'height':0},500,function() {
                                                $events.remove();
                                            });

                                        }

                                }

                        });
                }
        });

</script>

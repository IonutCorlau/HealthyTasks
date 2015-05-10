

function formatTime(i) {
    if (i < 10) {
        i = '0' + i
    }
    ;
    return i;
}

function startTime() {
    var date = new Date();

    var day = date.getUTCDate();
    var dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var year = date.getFullYear();

    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = date.getSeconds();

    hour = formatTime(hour);
    minute = formatTime(minute);
    second = formatTime(second);

    document.getElementById('date').innerHTML = dayNames[date.getDay()] + ', ' + day + ' ' + monthNames[date.getMonth()] + ' ' + year;
    document.getElementById('time').innerHTML = hour + ' : ' + minute + ' : ' + second;
    var t = setTimeout(function () {
        startTime()
    }, 500);
}
function ajaxSearch() {
    $(document).ready(function () {
        $("#taskNameSearch").keyup(function () {
            $.ajax({
                type: "POST",
                url: "php_functions/ajax/read_tasks.php",
                data: 'taskName=' + $("#taskNameSearch").val(),
                success: function (data) {

                    $("#suggestionName").show();
                    $("#suggestionName").html(data);

                }
            });
        });
    });

    function selectTaskName(val) {
        $("#taskNameSearch").val(val);
        $("#suggestionName").hide();
    }

    $(document).ready(function () {
        $("#taskDescriptionSearch").keyup(function () {
            $.ajax({
                type: "POST",
                url: "php_functions/ajax/read_tasks.php",
                data: 'taskDescrition=' + $("#taskDescriptionSearch").val(),
                success: function (data) {

                    $("#suggestionDescrition").show();
                    $("#suggestionDescrition").html(data);

                }
            });
        });
    });

    function selectTaskDescrition(val) {
        $("#taskDescriptionSearch").val(val);
        $("#suggestionDescrition").hide();
    }

    $(document).ready(function () {
        $("#taskLocationSearch").keyup(function () {
            $.ajax({
                type: "POST",
                url: "php_functions/ajax/read_tasks.php",
                data: 'taskLocation=' + $("#taskLocationSearch").val(),
                success: function (data) {

                    $("#suggestionLocation").show();
                    $("#suggestionLocation").html(data);

                }
            });
        });
    });

    function selectTaskLocation(val) {
        $("#taskLocationSearch").val(val);
        $("#suggestionLocation").hide();
    }

    $(document).ready(function () {
        //var timeFromJs = document.getElementById("datetimepickerWhenSearchFrom").value;

        var dateVar = $("#datetimepickerWhenSearchFrom").datetimepicker("getDate").getTime() / 1000;
        var dateVar = $("#datetimepickerWhenSearchFrom").val();

        $(" #datetimepickerWhenSearchTo").blur(function () {

            $.ajax({
                type: "POST",
                url: "php_functions/ajax/read_tasks.php",
                data: {timeFrom: "$('#datetimepickerWhenSearchFrom').val()", timeTo: bla},
                success: function (data) {
                    //alert($("#datetimepickerWhenSearchFrom").datetimepicker("getDate").getTime() / 1000);
                    $("#suggestionTime").show();
                    $("#suggestionTime").html(data);

                }
            });
        });
    });

    function selectTaskTime(val) {

        $("#taskTimeSearch").val(val);
        $("#suggestionName").hide();
    }
}

$(":file").filestyle({buttonName: "btn-primary"});

$(document).ready(function () {
    nice = $("html").niceScroll();
});






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
        startTime();
    }, 500);
}
function ajaxSearch() {

}

$(":file").filestyle({buttonName: "btn-primary"});

$(document).ready(function () {
    nice = $("html").niceScroll();
    
$('.bigCellTd.bigValue').each(function () {
    $(this).attr('data-fullvalue', $(this).text());
    $(this).text($(this).text().slice(0, 32) + "...");
    $(this).append('<label>more</label>');
    $(this).find('label').on('click', function () {
        toggleBigValue(this);
    });
});

});




function toggleBigValue(label) {
    var parent = $(label).parents('td');
    if (parent.text().length > 39) {
        parent.html(parent.attr('data-fullvalue').slice(0, 32) + "...<label>more</label>")
    } else {
        parent.html(parent.attr('data-fullvalue') + "<label>less</label>");
    }
    parent.find('label').on('click', function () {
        toggleBigValue(this);
    });
}




$(window).load(function () {
    setTimeout(function () {
        $('[data-id=taskActivity]').addClass('disabled');
    }, 500);

    $('#taskCategory').change(function () {
        if ($(this).val() !== "Health")
            $('[data-id=taskActivity]').addClass('disabled');

        else
            $('[data-id=taskActivity]').removeClass('disabled');

    });
});

$(window).load(function () {
    setTimeout(function () {
        $('[data-id=taskActivityEdit]').addClass('disabled');
    }, 500);

    $('#taskCategoryEdit').change(function () {
        if ($(this).val() !== "Health")
            $('[data-id=taskActivityEdit]').addClass('disabled');

        else
            $('[data-id=taskActivityEdit]').removeClass('disabled');

    });
});







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

$(":file").filestyle({buttonName: "btn-primary"});

$(document).ready(function() {
    nice = $("html").niceScroll();
});


<script>
$(function() {
    var $year = $('#InputYear');
    var $month = $('#InputMonth');
    var $day = $('#InputDay');
    $year.change(dateCheck);
    $month.change(dateCheck);

    var $start_hour = $('#InputStartHour');
    var $start_minute = $('#InputStartMinute');
    var $end_hour = $('#InputEndHour');
    var $end_minute = $('#InputEndMinute');
    $start_hour.change(timeCheck);
    $start_minute.change(timeCheck);
    $end_hour.change(timeCheck);

    function dateCheck() {
        var y = $year[0].value;
        var m = $month[0].value;
        var d = $day[0].value;
        var ds = new Date(y, m, 0); //get last day of the month
        var dl = ds.getDate();

        var options = "";
        for (var i = 1; i <= dl; i++) {
          if (i == d) {
            options += "<option value='" + i + "' selected>" + i + "</option>";
          } else {
            options += "<option value='" + i + "'>" + i + "</option>";
          }
        }
        $day.html(options);
    }

    function timeCheck() {
        var sh = Number($start_hour[0].value);
        var sm = Number($start_minute[0].value);
        var eh = Number($end_hour[0].value);
        var em = Number($end_minute[0].value);
        //console.log(typeof sh,sm,eh,em);
        var options = "";
        for (var i = sh; i < 24; i++) {
          if (i == eh) {
            options += "<option value='" + i + "' selected>" + ("0"+i).slice(-2) + "</option>";
          } else {
            options += "<option value='" + i + "'>" + ("0"+i).slice(-2) + "</option>";
          }
        }
        $end_hour.html(options);

        if (sh == eh) {
            var options = "";
            for (var i = sm; i < 60; i += 10) {
              if (i == em) {
                options += "<option value='" + i + "' selected>" + ("0"+i).slice(-2) + "</option>";
              } else {
                options += "<option value='" + i + "'>" + ("0"+i).slice(-2) + "</option>";
              }
            }
            $end_minute.html(options);
        } else if (sh < eh) {
            var options = "";
            for (var i = 0; i < 60; i += 10) {
              if (i == em) {
                options += "<option value='" + i + "' selected>" + ("0"+i).slice(-2) + "</option>";
              } else {
                options += "<option value='" + i + "'>" + ("0"+i).slice(-2) + "</option>";
              }
            }
            $end_minute.html(options);
        }
    }
});
</script>

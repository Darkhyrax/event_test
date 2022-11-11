<div class="chart-overflow" id="column-chart1"></div>

<script>
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.load('current', {'packages':['line']});
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {
if ($("#column-chart1").length > 0) {
      var a = google.visualization.arrayToDataTable([
        ["Day", "Participants"],
        @foreach($events as $event)
        	['{{date("m-d-Y",strtotime($event["day"]))}}',{{$event['participants']}}],
        @endforeach
      ]),
      b = {
        chart: {
          title: "Participants graphic",
          subtitle: "{{$from}} - {{$to}}"
        },
        bars: "vertical",
        vAxis: {
          format: "decimal"
        },
        height: 400,
        width:'100%',
          colors: ["#e2c636"]
      },
    c = new google.charts.Bar(document.getElementById("column-chart1"));
    c.draw(a, google.charts.Bar.convertOptions(b))
  }

}
</script>
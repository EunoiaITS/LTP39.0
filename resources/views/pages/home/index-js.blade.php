<script>

    // pie chart
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 50);
    };
    Chart.defaults.global.defaultFontColor = 'white';
    Chart.defaults.global.defaultFontFamily = '"Lato", sans-serif';
    @foreach($all_clients as $ac)
    var config{{ $ac->id }} = {
        type: 'pie',
        data: {
            labels: ["Free", "Occupied"],
            datasets: [{
                data: [{{ $ac->total_parking - $ac->occupied_parking }}, {{ $ac->occupied_parking }} ],
                backgroundColor: [
                    '#f85f7d',
                    '#d5d5d5'
                ],
                borderWidth: [1,1],
                borderColor: ['#f85f7d', '#d5d5d5']
            }],
        },
        options: {
            responsive: true,
            legend: {
                display: true,
                position: 'bottom'
            },
        }
    };
    @endforeach



    window.onload = function() {
        @foreach($all_clients as $ac)
        var ctx{{ $ac->id }} = document.getElementById("chart-area{{ $ac->id }}").getContext("2d");
        window.myPie = new Chart(ctx{{ $ac->id }}, config{{ $ac->id }});
        @endforeach
    };
</script>
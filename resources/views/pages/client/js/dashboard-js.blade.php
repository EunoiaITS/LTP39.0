<script>
    // pie chart
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 50);
    };
    var config = {
        type: 'pie',
        data: {
            labels: ["Free", "Occupied"],
            datasets: [{
                data: [{{ $client->total - $client->occupied }},{{ $client->occupied }} ],
                backgroundColor: [
                    '#A049A7',
                    '#229ED2'
                ],
                borderWidth: [1,1],
                borderColor: ['#A049A7', '#229ED2']
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

    window.onload = function() {
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myPie = new Chart(ctx, config);
    };


</script>
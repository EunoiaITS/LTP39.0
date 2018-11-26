
<script>
    $(document).ready(function () {
        $('#generate').on('click',function (e) {
           e.preventDefault();
           var sel = $('#client-select').val();
           var url = '{{ url('/') }}';
           window.location.href = url+'?clients='+sel;
        });
    });
    var occupied = '<?php echo $count;?>';
    var free = '<?php echo ($total - $count);?>';
    @foreach($users as $u)

    // pie chart
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 50);
    };
    var config{{$u->id}} = {
        type: 'pie',
        data: {
            labels: ["Free", "Occupied"],
            datasets: [{
                data: [free, occupied ],
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
    @endforeach
    window.onload = function() {
        @foreach($users as $u)
            var ctx{{$u->id}} = document.getElementById("chart-area{{ $u->id }}").getContext("2d");
            window.myPie{{$u->id}} = new Chart(ctx{{ $u->id }}, config{{ $u->id }});
        @endforeach
    };
</script>

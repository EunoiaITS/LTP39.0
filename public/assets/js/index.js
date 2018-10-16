
// pie chart
var randomScalingFactor = function() {
    return Math.round(Math.random() * 50);
};

var config = {
    type: 'pie',
    data: {
        labels: ["Free", "Occupied"],
        datasets: [{
            data: [300, 600 ],
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


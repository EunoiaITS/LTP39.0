
// pie chart
var randomScalingFactor = function() {
    return Math.round(Math.random() * 50);
};
Chart.defaults.global.defaultFontColor = 'white';
Chart.defaults.global.defaultFontFamily = '"Lato", sans-serif';
var config = {
    type: 'pie',
    data: {
        labels: ["Free", "Occupied"],
        datasets: [{
            data: [300, 600 ],
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



window.onload = function() {
    var ctx = document.getElementById("chart-area").getContext("2d");
    window.myPie = new Chart(ctx, config);

    var ctx = document.getElementById("chart-area-2").getContext("2d");
    window.myPie = new Chart(ctx, config);

    var ctx = document.getElementById("chart-area-3").getContext("2d");
    window.myPie = new Chart(ctx, config);

    var ctx = document.getElementById("chart-area-4").getContext("2d");
    window.myPie = new Chart(ctx, config);

    var ctx = document.getElementById("chart-area-5").getContext("2d");
    window.myPie = new Chart(ctx, config);

    var ctx = document.getElementById("chart-area-6").getContext("2d");
    window.myPie = new Chart(ctx, config);
};
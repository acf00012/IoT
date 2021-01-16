function init(){
    generarhoras();
    graficoTemperatura();
    graficoHumedad();
}

var horas;
function generarhoras() {
    $.post("../ajax/aAmbiente.php?op=horas", function (data, status) {
        horas = JSON.parse(data);
    } );
}

function graficoTemperatura() {
    $.post("../ajax/aAmbiente.php?op=temperatura", function (data, status) {
        var as = JSON.parse(data);
        new Chart(document.getElementById("line-chart-temperatura"), {
            type: 'line',
            data: {
                labels: horas,
                datasets: [{
                    data: as,
                    label: "temperatura",
                    borderColor: "#3e95cd",
                    fill: true,
                }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Temperaturas del dia'
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    } );
}
function graficoHumedad() {
    $.post("../ajax/aAmbiente.php?op=humedad", function (data, status) {
        var as = JSON.parse(data);
        new Chart(document.getElementById("line-chart-humedad"), {
            type: 'line',
            data: {
                labels: horas,
                datasets: [{
                    data: as,
                    label: "humedad",
                    borderColor: "#3e95cd",
                    fill: true
                }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Humedad del dia'
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    } );
}
init();

setInterval(init, 60000);





function init(){
    generarhoras();
    graficoTemperatura();
    graficoHumedad();
    cabecera();
}

var horas;
function generarhoras() {
    $.post("../ajax/aAmbiente.php?op=horasMonitor", function (data, status) {
        horas = JSON.parse(data);
    } );
}

function graficoTemperatura() {
    $.post("../ajax/aAmbiente.php?op=temperaturaMonitor", function (data, status) {
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
    $.post("../ajax/aAmbiente.php?op=humedadMonitor", function (data, status) {
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
function cabecera() {
    $.post("../ajax/aAmbiente.php?op=consultarValores", function (data, status) {
        data = JSON.parse(data);
        $("#txtHoraActualización").html(data.fecha);
        $("#txtHumedad").html(data.humedad);
        $("#txtTemperatura").html(data.temperatura);
    });
}
init();

setInterval(init, 15000);
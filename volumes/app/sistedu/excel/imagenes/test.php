
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.9/metisMenu.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="/control/vistas/assets/js/moment-duration-format.js"></script>
    
<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>
    
                                            <div style="width:75%;">
                                            <canvas id="canvas_9"></canvas>
                                        </div>
                                        <form method="POST" action="excel/imagenes/reporte_guardar_grafico.php" name="form" id="form_9">
                                            <input type="hidden" name="base64" id="base64"/>
                                            <input type="hidden" name="prueba" value="9">
                                            <input type="hidden" name="nadador" value="90">
                                            <input type="hidden" name="reporte" value="5cd5cba7d11de">
                                            
                                            <button type="button" id="submit__9">
                                              Agregar Grafica
                                            </button>
                                            <div id="response_9"></div>
                                        </form>
                                                                                <div style="width:75%;">
                                            <canvas id="canvas_13"></canvas>
                                        </div>
                                        <form method="POST" action="excel/imagenes/reporte_guardar_grafico.php" name="form" id="form_13">
                                            <input type="hidden" name="base64" id="base64"/>
                                            <input type="hidden" name="prueba" value="13">
                                            <input type="hidden" name="nadador" value="90">
                                            <input type="hidden" name="reporte" value="5cd5cba7d11de">
                                            
                                            <button type="button" id="submit__13">
                                              Agregar Grafica
                                            </button>
                                            <div id="response_13"></div>
                                        </form>
                                                                                <div style="width:75%;">
                                            <canvas id="canvas_17"></canvas>
                                        </div>
                                        <form method="POST" action="excel/imagenes/reporte_guardar_grafico.php" name="form" id="form_17">
                                            <input type="hidden" name="base64" id="base64"/>
                                            <input type="hidden" name="prueba" value="17">
                                            <input type="hidden" name="nadador" value="90">
                                            <input type="hidden" name="reporte" value="5cd5cba7d11de">
                                            
                                            <button type="button" id="submit__17">
                                              Agregar Grafica
                                            </button>
                                            <div id="response_17"></div>
                                        </form>
                                                                                <div style="width:75%;">
                                            <canvas id="canvas_18"></canvas>
                                        </div>
                                        <form method="POST" action="excel/imagenes/reporte_guardar_grafico.php" name="form" id="form_18">
                                            <input type="hidden" name="base64" id="base64"/>
                                            <input type="hidden" name="prueba" value="18">
                                            <input type="hidden" name="nadador" value="90">
                                            <input type="hidden" name="reporte" value="5cd5cba7d11de">
                                            
                                            <button type="button" id="submit__18">
                                              Agregar Grafica
                                            </button>
                                            <div id="response_18"></div>
                                        </form>
                                                                                <div style="width:75%;">
                                            <canvas id="canvas_20"></canvas>
                                        </div>
                                        <form method="POST" action="excel/imagenes/reporte_guardar_grafico.php" name="form" id="form_20">
                                            <input type="hidden" name="base64" id="base64"/>
                                            <input type="hidden" name="prueba" value="20">
                                            <input type="hidden" name="nadador" value="90">
                                            <input type="hidden" name="reporte" value="5cd5cba7d11de">
                                            
                                            <button type="button" id="submit__20">
                                              Agregar Grafica
                                            </button>
                                            <div id="response_20"></div>
                                        </form>
                                                                                <div style="width:75%;">
                                            <canvas id="canvas_21"></canvas>
                                        </div>
                                        <form method="POST" action="excel/imagenes/reporte_guardar_grafico.php" name="form" id="form_21">
                                            <input type="hidden" name="base64" id="base64"/>
                                            <input type="hidden" name="prueba" value="21">
                                            <input type="hidden" name="nadador" value="90">
                                            <input type="hidden" name="reporte" value="5cd5cba7d11de">
                                            
                                            <button type="button" id="submit__21">
                                              Agregar Grafica
                                            </button>
                                            <div id="response_21"></div>
                                        </form>
                                         
<script>
    window.onload = function() {
        function randomScalingFactor() {
            var var1 = Math.round(Math.random() * 100 * (Math.random() > 0.5 ? -1 : 1));
            console.log ("randomScaling"+var1);
            return var1;
        }
        function randomColorFactor() {
            return Math.round(Math.random() * 255);
        }
        function randomColor(opacity) {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
        }
        function newDate(mili) {
            
       
       // console.log(moment(mili,'mm:ss.SS')._i);
            return moment(mili,'mm:ss.SS')._i;
           
        }
        function newDateString(fecha) {
            var var3 = moment(fecha,'YYYY-MM-DD');
            return var3;
        }
        $( "#form_21" ).click(function() {
                                                                var image = ctx_21.toDataURL(); 
                                                                $("#form_21 base64").val(image);
                                                                    
                                                                    $("#form_21").submit(function(event){
                                                                    event.preventDefault();

                                                                    $.ajax({
                                                                            url:'reporte_guardar_grafico.php',
                                                                            type:'POST',
                                                                            data:$(this).serialize(),
                                                                            success:function(result){
                                                                                $("#response_21").text(result);

                                                                            }

                                                                    });
                                                                });
                                                              });
                                                                      var config_21 = {
            type: 'line',
            bezierCurve : false,
            data: {
                datasets: [{
                    label: "Martin Alexander Henriquez Cardenas",
                    lineTension: 0,
                    data: [{
                                            x: newDateString('2018-01-25'),
                                            y: newDate('05:18.89')
                                        }, {
                                            x: newDateString('2018-06-28'),
                                            y: newDate('05:18.03')
                                        }, {
                                            x: newDateString('2018-12-16'),
                                            y: newDate('05:06.38')
                                        }, {
                                            x: newDateString('2019-01-27'),
                                            y: newDate('05:12.69')
                                        }],
                    fill: false
                }]
            },
            options: {
                
                responsive: true,
                title:{
                    display:true,
                    text:"400 Combinado - Piscina 50 mts"
                },
                scales: {
                    xAxes: [{
                        type: "time",
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date'
                        }
                    }],
                    yAxes: [{
                        type: "time",
                        display: true,
                        ticks: {
                		beginAtZero: true,
                            reverse: true,
                            start: 0
                        },
                        time: {                         
                            parser: 'mm:ss.SS',
                            /*min: newDate('05:03.31.6'),
                            max: newDate('05:22.7.9'),*/
                            
                            unit: 'millisecond',
                           // unitStepSize: 1000,
                            displayFormats: {
                                millisecond: 'mm:ss.SS'
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Tiempo'
                        }
                    }]
                
                }
            }
        };
        jQuery.each(config_21.data.datasets, function(i, dataset) {
            dataset.borderColor = randomColor(0.4);
            dataset.backgroundColor = randomColor(0.5);
            dataset.pointBorderColor = randomColor(0.7);
            dataset.pointBackgroundColor = randomColor(0.5);
            dataset.pointBorderWidth = 1;
        });
        
        
      
       
      
        var ctx_21 = document.getElementById("canvas_21").getContext("2d");
        window.myLine = new Chart(ctx_21, config_21); 
                                                   
    };
</script>

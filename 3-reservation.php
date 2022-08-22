<?php
$response = '';
    // (A) PROCESS RESERVATION
if (isset($_POST["eventTime2"])) {
  require "2-reserve.php";
  if ($_RSV->save($_POST["sucursal"],
    $_POST["numpers"],
    $_POST["catgames"], 
    $_POST["asistencia"],
    $_POST["notes"], 
    $_POST["eventTime2"],
    $_POST["name"],
    $_POST["telefono"])) {
  echo '<script>
    setTimeout(function(){ window.location.href= "https://coffeeanddragons.mx";}, 5000);
    </script>';
  $response =  '<img src="reserv-done.png" id="imgpremio">' ;
} else { echo "<div class='err'>".$_RSV->error."</div>"; }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Reservas C&D</title>
  <link href="3-theme.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
</head>
<body>
  <form id="resForm" method="post" target="_self">
    <h1><img src="CDLOGO.jpg" id="imgprinc"></h1>

    <div class="steps">
      <div class="step current"></div>
      <div class="step"></div>
    </div>
    <div class="step-content current" data-step="1">
      <!-- (B) RESERVATION FORM -->

      <div class="fields">
        <label for="Sucursal">¿Dónde quieres tener tu aventura?</label>
        <select id="Sucursal" name="sucursal" required>
          <option disabled selected hidden>Selecciona una sucursal</option>
          <option value="Cholula">Cholula</option>
          <option value="16Sept">16 de Septiembre</option>
        </select>

        <label for="res_tel">Cantidad de personas (Máximo 10)</label>
        <input type="number" required name="numpers" min="1" max="10" onKeyDown="return false" value="5"/>

        <label for="catgames">¿Qué tipo de juegos quieren jugar?</label>
        <select name="catgames">
          <option disabled selected hidden>Tranquil@ podrán jugar otras cosas también</option>
          <option value="Rol">Juegos de Rol</option>
          <option value="Party">Party games o juegos familiares</option>
          <option value="Deck">Deck Builder/TCG</option>
          <option value="War">War Games o juegos de miniaturas</option>
          <option value="Long">Juegos largos y con temática</option>
          <option value="Nose">No tengo nada pensado</option>
        </select>

        <button onclick="window.open('https://w3docs.com');" >
          Conocer más sobre los tipos de juegos
        </button>

        <label for="checkasist">¿Quieren que les enseñemos a jugar?</label>
        <input type="hidden" name="asistencia" value="No">
        <input type="checkbox" name="asistencia" value="Sí">

        <label for="res_notes">Algo extra que nos quieras decir</label>
        <input type="text" name="notes" placeholder="Cuéntanos si necesitas algo más" />



        <label>¿Qué día quieres hacer tu cita?</label>
        <div class="field">
          <input type="text" id="calendar-es" onchange="availabletimes(this.value);chour();timeformat();">
        </div>

        <label>Reservation Slot</label>
        <select id="hours" name="hourslot"  onchange="chour();timeformat();">
        </select>

        <select id="minutes"  name="minuteslot" onchange="timeformat()">
          <option value="30">30</option>
        </select>


        <input type="hidden" name="eventTime" id="eventTime" required>
        <input type="text" name="eventTime2" id="eventTime2">

        <label for="res_name">Nombre</label>
        <input type="text" required name="name" placeholder="Aventurero Valiente"/>

        <label for="res_tel">Teléfono de contacto</label>
        <input type="tel" required name="telefono" placeholder="solo te llamaremos si es necesario" maxlength="10" minlength="10" />

        <input type="submit" class="btn" name="submit" value="Reservar" id="checkBtn" >

      </div>
    </div>

    <div class="step-content" data-step="2">
      <div class="result"><?=$response?></div>
    </div>



  </form>

</body>

<script>
  const setStep = step => {
    document.querySelectorAll(".step-content").forEach(element => element.style.display = "none");
    document.querySelector("[data-step='" + step + "']").style.display = "block";
    document.querySelectorAll(".steps .step").forEach((element, index) => {
      index < step-1 ? element.classList.add("complete") : element.classList.remove("complete");
      index == step-1 ? element.classList.add("current") : element.classList.remove("current");
    });
  };
  document.querySelectorAll("[data-set-step]").forEach(element => {
    element.onclick = event => {
      event.preventDefault();
      setStep(parseInt(element.dataset.setStep));
    };
  });
  <?php if (!empty($_POST)): ?>
    setStep(2);
  <?php endif; ?>
</script>



<script type="text/javascript">


  function rmydays(date) {
    return (date.getDay() === 1);
  }

  flatpickr('#calendar-es', {
    "locale": "es",
    "dateFormat": "d-m-Y",
    "disable": [rmydays],  
    "minDate": "today"
  }
  );

</script>


<script>
 function createOption(value, text) {
  var option = document.createElement('option');
  option.text = text;
  option.value = value;
  return option;
}

var hinicial;
var hourSelect = document.getElementById('hours');
var newdate;

function availabletimes(selected_day){
  var select = document.getElementById('Sucursal');
  var selected_suc = select.options[select.selectedIndex].value;

  $("#hours").empty();
  console.log(selected_suc);
  console.log(selected_suc);
  var formatdate = selected_day.split("-");
  newdate = formatdate[1] + '/' + formatdate[0] + '/' + formatdate[2];
  correct_format=new Date(newdate);

  if (selected_suc=="Cholula"){
    if (correct_format.getDay()===6 || correct_format.getDay()===0 ){
      hinicial=10; 
    }else{
      hinicial=16;  
    }
  }else{
    hinicial=13;
  }
  for(var i=hinicial; i <= 20 ;i++){
    hourSelect.add(createOption(i, i));
  }
  console.log(i);


}

var minutesSelect = document.getElementById('minutes');

function chour()  {
  $("#minutes").empty();
  if (hourSelect.value ==16 || hourSelect.value ==10  ){
   minutesSelect.add(createOption(30,30));
   minutesSelect.value=30;
   minutesSelect.text=30;
 }else{
  for(var i = 0; i < 60; i += 30) {
   if (i==0) {
    minutesSelect.add(createOption("00","00")); 
  }else{
   minutesSelect.add(createOption(i, i));}
 }
}}


function timeformat(){
  var hour = +document.getElementById('hours').value;
  var minute = document.getElementById('minutes').value;
  var timestring=  hour + ':' + minute + ':00';
  var dateobj= newdate + ' ' + timestring ;
  var dateobj2=new Date(dateobj);
  document.getElementById('eventTime').value=dateobj2.valueOf();
  console.log(eventTime);
  console.log(dateobj.valueOf());
  document.getElementById('eventTime2').value=dateobj2.valueOf();
}

</script>
</html>

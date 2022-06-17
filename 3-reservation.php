<!DOCTYPE html>
<html>
<head>
  <title>Reservas C&D</title>
  <link href="3-theme.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
  <?php
    // (A) PROCESS RESERVATION
    if (isset($_POST["eventTime"])) {
      require "2-reserve.php";
      if ($_RSV->save(
      $_POST["eventTime"], $_POST["name"],
      $_POST["email"], $_POST["tel"], $_POST["notes"])) {
        echo "<div class='ok'>Reservation saved.</div>";
      } else { echo "<div class='err'>".$_RSV->error."</div>"; }
    }
  ?>

  <!-- (B) RESERVATION FORM -->
  <h1>RESERVATION</h1>
  <form id="resForm" method="post" target="_self">
    <label for="res_name">Name</label>
    <input type="text" required name="name" value="John Doe"/>

    <label for="res_email">Email</label>
    <input type="email" required name="email" value="john@doe.com"/>

    <label for="res_tel">Telephone Number</label>
    <input type="text" required name="tel" value="123456789"/>

    <label for="res_notes">Notes (if any)</label>
    <input type="text" name="notes" value="Testing"/>

    <?php
      // @TODO - MINIMUM DATE (TODAY)
      // $mindate = date("Y-m-d", strtotime("+2 days"));
      $mindate = date("Y-m-d");
    ?>
    <label>Reservation Date</label>
    <input type="date" required id="res_date" name="date"
    min="<?=$mindate?>">

    <label>Reservation Slot</label>
    <select id="hours" name="hourslot"  onchange="chour();timeformat();">
    </select>

    <select id="minutes"  name="minuteslot" onchange="timeformat()">
      <option value="30">30</option>
    </select>

  <input type="hidden" name="eventTime" id="eventTime" required>
  <input type="text" name="eventTime2" id="eventTime2">
    <input type="submit" value="Submit"/>
  </form>
</body>


<script>
 function createOption(value, text) {
  var option = document.createElement('option');
  option.text = text;
  option.value = value;
  return option;
}

var hourSelect = document.getElementById('hours');
for(var i = 4; i <= 8 ; i++){
  hourSelect.add(createOption(i, i));
}

var minutesSelect = document.getElementById('minutes');

function chour()  {
  $("#minutes").empty();
if (hourSelect.value ==4){
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
    var day = document.getElementById('res_date').value;
    var hour = +document.getElementById('hours').value + 12;
    var minute = document.getElementById('minutes').value;
  var timestring=  hour + ':' + minute + ':00';
   var dateobj= day + ' ' + timestring ;
   document.getElementById('eventTime').value=dateobj;
   document.getElementById('eventTime2').value=dateobj;
}

</script>
</html>

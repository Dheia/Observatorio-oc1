<script type="text/javascript">
  function myFunction() {
  var x = document.getElementById("cod<?=$id?>");
  var y = document.getElementById("gjs<?=$id?>");
  var z = document.getElementById("linkcod<?=$id?>");
  
  if (x.style.display === "block") {
    x.style.display = "none";
    z.innerHTML='Builder'
  } else {
    x.style.display = "block";
    z.innerHTML='Text Editor'
  }
}
</script>
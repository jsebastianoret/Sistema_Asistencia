// MENU LATERAL RESPONSIVE
$("#btn_menu").on("click", function (e) {
  $(".sidebar").toggleClass("mostrar");
});

$(document).on("click", function (e) {
  if (
    !$(".sidebar").is(e.target) &&
    $(".sidebar").has(e.target).length === 0 &&
    !$("#btn_menu").is(e.target) &&
    $("#btn_menu").has(e.target).length === 0
  ) {
    $(".sidebar").removeClass("mostrar");
  }
});

// TIMER
function displayTime() {
  var time = new Date();
  var hours = time.getHours();
  var minutes = time.getMinutes();
  var seconds = time.getSeconds();
  var ampm = hours >= 12 ? "PM" : "AM";
  hours = hours % 12;
  hours = hours ? hours : 12;
  minutes = minutes < 10 ? "0" + minutes : minutes;
  seconds = seconds < 10 ? "0" + seconds : seconds;
  var currentTime = hours + ":" + minutes + ":" + seconds + " " + ampm;
  document.getElementById("clock").innerHTML = currentTime;
  timer = setTimeout(displayTime, 1000);
}

// CERRAR SESIÓN
function salirMiPerfil() {
  Swal.fire({
    title: "¿Estás seguro de que quieres salir de tu perfil?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonText: "Cancelar",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Salir de perfil",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "logout.php";
    }
  });
}

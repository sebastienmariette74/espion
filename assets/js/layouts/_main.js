const $ = require("jquery");

/*_______________ style arrow ________________________*/
let arrowToggle = false;
$(".mainArrow").on("click", function () {
  console.log('ok');
  if (!arrowToggle) {
    arrowToggle = true;
    $("main").css({
      width: "300px",
      height: "100vh",
    });
    $(".arrow").css("transform", "rotate(180deg)");
  } else {
    arrowToggle = false;
    $("main").css({
      width: "30px",
      height: "30px",
    });
    $(".arrow").css("transform", "rotate(360deg)");
  }
});

/*_______________ style links ________________________*/

let pathname = new URL(window.location.href).pathname;

$(".main-link").each(function(){
  if (
    $(this).attr('href') == pathname ||
    $(this).attr('href').split("/")[2] == pathname.split("/")[2]
  ) {
    $(this).addClass("active");
  }
})


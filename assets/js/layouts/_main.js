const { css } = require("jquery");
const $ = require("jquery");

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

$("[href]").each(function () {
  if (this.href == window.location.href) {
    $(this).addClass("active");
  }
});

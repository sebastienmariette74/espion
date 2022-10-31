const $ = require("jquery");

$mainToggle = false;

$navbarToggle = false;
$('.navbar-toggler').on('click', function(){
  console.log('navbar-toggle');
    if (!$navbarToggle) {
        $navbarToggle = true;
        $(".navbarSupportedContent").css({
            'display': 'block',
            'position' : 'absolute',
            'background' : '#252529',
            'color' : '#FFFFFF80',
            'right' : '0',
            'top' : '60px',
            'padding' : '10px 20px 5px',
            'width': '200px'
        });
      } else {
        $navbarToggle = false;
        $(".navbarSupportedContent").css({
          display: "none",
        });
      }
})

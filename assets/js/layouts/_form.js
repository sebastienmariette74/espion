const $ = require("jquery");

let title = $('#mission_title');

let country = $("#mission_country");
let date = $("#mission_begin_at");
console.log(country);
country.on("change", function () {
  console.log(title);
  let form = $(this).closest("form");
  let data = {};
  // data[title.attr("title")] = title.text();
  data[country.attr("name")] = country.val();
  data[date.attr("name")] = date.val();
  $.ajax({
    url: form.attr("action"),
    type: form.attr("method"),
    data: data,
    complete: function (html) {
      // $("#mission_title").replaceWith(
      //   $(html.responseText).find("#mission_title")
      // );
      $("#mission_hidingPlace").replaceWith(
        $(html.responseText).find("#mission_hidingPlace")
      );
      $("#mission_contact").replaceWith(
        $(html.responseText).find("#mission_contact")
      );
      // $("#mission_agent").replaceWith(
      //   // ... with the returned one from the AJAX response.
      //   $(html.responseText).find("#mission_agent")
      // );
      // Position field now displays the appropriate positions.
    },
  });
});

let target = $("#mission_target");
let date2 = $("#mission_begin_at");

target.on("change", function () {
  console.log("change");
  let form = $(this).closest("form");
  let data = {};
  data[target.attr("name")] = target.val();
  data[date2.attr("name")] = date2.val();
  $.ajax({
    url: form.attr("action"),
    type: form.attr("method"),
    data: data,
    complete: function (html) {
      $("#mission_agent").replaceWith(
        $(html.responseText).find("#mission_agent")
      );
    },
  });
});

// let speciality = $("#mission_speciality");
// let date3 = $("#mission_begin_at");

// console.log(speciality);

// speciality.on("change", function () {
//   console.log("change");
//   let form = $(this).closest("form");
//   let data = {};
//   data[speciality.attr("name")] = speciality.val();
//   data[date3.attr("name")] = date3.val();
//   $.ajax({
//     url: form.attr("action"),
//     type: form.attr("method"),
//     data: data,
//     complete: function (html) {
//       $("#mission_agent").replaceWith(
//         $(html.responseText).find("#mission_agent")
//       );
//     },
//   });
// });

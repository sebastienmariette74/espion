const $ = require("jquery");

let errors = $('.invalid-feedback');
errors.each(function(index){
  if(index != 0){
    $(this).css('visibility', 'hidden');
  }
  // $(this).css('color', 'green');
  // console.log($(this));
})

let title = $("#mission_title");
let target = $("#mission_target");
let agent = $("#mission_agent option");

let noTarget = $("#mission_target option:selected").text();
if (noTarget === "") {
  agent.css("display", "none");
}
console.log(noTarget);

let country = $("#mission_country");
let noCountry = $("#mission_country option:selected").text();
let date = $("#mission_begin_at");
let hidingPlace = $(".hidingPlace option");
let contact = $(".contact option");
if (noCountry === "Pays") {
  hidingPlace.css("display", "none");
  contact.css("display", "none");
}

country.on("change", function () {
  if ($(this).text() != "Pays") {
    hidingPlace.css("display", "block");
    contact.css("display", "block");
  }
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

$(".form-create").on("mouseover", "#mission_hidingPlace option", function () {
  // $('.modal').css('display', 'block');
  // $("<div class='details'></div>").prependTo($(".hidingPlace"));
  // $(this).closest().append("<div class='modal'></div>");
  let code = $(this).text();
  if (code.indexOf('(') != -1) {
    code = code.split('(')[0];
  }  
  let url = new URL(window.location);
  axios
    .get(url.origin + "/admin/hidingPlaces/hidingPlace/" + code)
    .then((response) => {
      if ($(".details").length < 1) {
        $("<div class='details'></div>").prependTo($(".hidingPlace"));
        // $("<div class='details'></div>").insertBefore($(this).parent("ul"));
        $(`.details`).html(response.data);
        // if (element != null) {
        // $(`.${element}`).html(response.data);
        // }
        let heightDetails = $(".details").height();
        let top = "-" + heightDetails + "px";
        $(`.details`).css("top", top);
      }
      // $(`.details`).html(response.data);
      // if (element != null) {
      // $(`.${element}`).html(response.data);
      // }
    })
    .catch((error) => {
      // '${.content}'.html = `Erreur: ${error.message}`;
      // '${.content}'.parent().html = `Erreur: ${error.message}`;
      console.error("Il y a une erreur dans la requête", error);
    });
});

$('.form-create').on('mouseout', '#mission_hidingPlace option', function(){
  $('.details').remove();
});

$('.form-create').on('mouseout', '.details', function(){    
  $('.details' ).remove();
});

/* _________________ selection des agents par filtre __________________*/
// let agentSpeciality = $('#mission_agentSpeciality');
// agentSpeciality.on("change", function () {
//   let form = $(this).closest("form");
//   let data = {};
//   data[agentSpeciality.attr("name")] = agentSpeciality.val();
//   data[date2.attr("name")] = date2.val();
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

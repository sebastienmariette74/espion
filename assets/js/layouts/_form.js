const { each } = require("jquery");
const $ = require("jquery");

/* L'erreur(contrainte) d'un CKEditorType s'affiche 2 fois. 
Pour résoudre le problème, j'affiche 1 erreur à la fois.
Même si cela concerne plusieurs champs.
*/
let errors = $(".invalid-feedback");
errors.each(function (index) {
  if (index != 0) {
    $(this).css("visibility", "hidden");
  }
});

/* Non affichage des champs Target, Agent et Contact au démarrage */
let target = $("#mission_target");
let agent = $("#mission_agent option");

let noTarget = $("#mission_target option:selected").text();
if (noTarget === "") {
  agent.css("display", "none");
}

let country = $("#mission_country");
let noCountry = $("#mission_country option:selected").text();
let date = $("#mission_begin_at");
let hidingPlace = $(".hidingPlace option");
let contact = $(".contact option");
if (noCountry === "Pays") {
  hidingPlace.css("display", "none");
  contact.css("display", "none");
}

/* AJAX - modification des champs hidingPlace et Contact après avoir choisi un pays */
let codeName = $("#mission_codeName");
let title = $("#mission_title");
let desc = $("#mission_description");
country.on("change", function () {
  let codeNameVal = $("#mission_codeName").val();
  if ($(this).text() != "Pays") {
    hidingPlace.css("display", "block");
    contact.css("display", "block");
  }
  let form = $(this).closest("form");
  let data = {};
  data["ajax"] = 1;
  data["codeName"] = codeName.val();
  data["title"] = title.val();
  data["description"] = desc.val();
  data[codeName.attr("name")] = codeNameVal;
  data[title.attr("name")] = title.val();
  data[desc.attr("name")] = desc.val();
  data[country.attr("name")] = country.val();
  data[date.attr("name")] = date.val();
  $.ajax({
    url: form.attr("action"),
    type: form.attr("method"),
    data: data,
    complete: function (html) {
      $("#mission_hidingPlace").replaceWith(
        $(html.responseText).find("#mission_hidingPlace")
      );
      $("#mission_contact").replaceWith(
        $(html.responseText).find("#mission_contact")
      );
    },
  });
});

// let date2 = $("#mission_begin_at");
/* AJAX - modification du champ agent après avoir choisi une ou plusieurs cibles */
target.on("change", function () {
  let codeNameVal = $("#mission_codeName").val();
  let form = $(this).closest("form");
  let data = {};
  data["ajax"] = 1;
  data["codeName"] = codeName.val();
  data["title"] = title.val();
  data["description"] = desc.val();
  data[codeName.attr("name")] = codeNameVal;
  data[title.attr("name")] = title.val();
  data[desc.attr("name")] = desc.val();
  data[target.attr("name")] = target.val();
  data[date.attr("name")] = date.val();
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

// Fonctionnalité marchant très bien en DEV en non en PROD
/* affichage d'une info-bulle au passage de la souris sur un élément de la liste des planques */
// $(".form-create").on("mouseover", "#mission_hidingPlace option", function () {
//   let code = $(this).text();
//   if (code.indexOf("(") != -1) {
//     code = code.split("(")[0];
//   }
//   let url = new URL(window.location);
//   axios
//     .get(url.origin + "/admin/hidingPlaces/hidingPlace/" + code)
//     .then((response) => {
//       if ($(".details").length < 1) {
//         $("<div class='details'></div>").prependTo($(".hidingPlace"));
//         $(`.details`).html(response.data);
//         let heightDetails = $(".details").height();
//         let top = "-" + heightDetails + "px";
//         $(`.details`).css("top", top);
//       }
//     })
//     .catch((error) => {
//       // '${.content}'.html = `Erreur: ${error.message}`;
//       // '${.content}'.parent().html = `Erreur: ${error.message}`;
//       console.error("Il y a une erreur dans la requête", error);
//     });
// });

// /* fermeture de l'infobulle */
// $(".form-create").on("mouseout", "#mission_hidingPlace option", function () {
//   $(".details").remove();
// }

// $(".details").on("mouseout", "#mission_hidingPlace option", function () {
//   $(".details").remove();
// }

// // $('body').on("mousemove", function(){
// //   $(".details").remove();
// // })

// /* affichage d'une info-bulle au passage de la souris sur un élément de la liste des planques */
// $(".form-edit").on("mouseover", "#mission_agent option", function () {
//   let code = $(this).text();
//   if (code.indexOf(" =") != -1) {
//     code = code.split(" =")[0];  }
//   let url = new URL(window.location);
//   axios
//     .get(url.origin + "/admin/agents/agent/" + code)
//     .then((response) => {
//       if ($(".details").length < 1) {
//         $("<div class='details'></div>").prependTo($(".hidingPlace"));
//         // $(".details").css("display", "block");
//         $(".details").html(response.data);
//         let heightDetails = $(".details").height();
//         let top = "-" + heightDetails + "px";
//         $(".details").css("top", top);
//       }
//     })
//     .catch((error) => {
//       // '${.content}'.html = `Erreur: ${error.message}`;
//       // '${.content}'.parent().html = `Erreur: ${error.message}`;
//       console.error("Il y a une erreur dans la requête", error);
//     });
// });

// /* fermeture de l'infobulle */
// $(".form-edit").on("mouseout", "#mission_agent option", function () {
//   $(".details").remove();
// }

// $(".details").on("mouseout", "#mission_agent option", function () {
//   $(".details").remove();
// }

// // $('body').on("mousemove", function(){
// //   $(".details").remove();
// // })
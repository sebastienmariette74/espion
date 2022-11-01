
import {updateParams, updateNewParams} from "../../functions/updateParams.js"
const $ = require("jquery");

/* _____________________FILTRE PAR MOT_____________________________*/
$(".js-query").on("keyup", function () {
  let speciality = $("#filter-speciality option:selected").val() ?? "";
  let type = $("#filter-type option:selected").val() ?? "";
  let status = $("#filter-status option:selected").val() ?? "";
  let query = $(".js-query").val() ?? "";
  let offset = $("#offset").val();

  let filters = {
    "speciality" : speciality,
    "type" : type,
    "status" : status, 
    "query" : query,
    "offset" : offset
  };

  let params = new URLSearchParams();

  updateParams(filters, params);

  let url = new URL(window.location.href);

  axios
    .get(url.pathname + "?" + params.toString() + "&ajax=1")
    .then((response) => {
      $(`.content`).html(response.data);
    })
    .catch((error) => {
      // '${.content}'.html = `Erreur: ${error.message}`;
      // '${.content}'.parent().html = `Erreur: ${error.message}`;
      console.error("Il y a une erreur dans la requête", error);
    });

    let newParams = new URLSearchParams();
    updateNewParams(filters, newParams);

    // Mise à jour de l'url
    if (newParams.toString() === "") {
      history.pushState({}, null, url.pathname);
    } else {
      history.pushState({}, null, url.pathname + "?" + newParams.toString());
    }
});

/* _____________________FILTRES_____________________________*/
$(".content").on("change", ".filter", function () {
  let speciality = $("#filter-speciality option:selected").val() ?? "";
  let type = $("#filter-type option:selected").val() ?? "";
  let status = $("#filter-status option:selected").val() ?? "";
  let query = $(".js-query").val() ?? "";
  let offset = $("#offset").val();

  let filters = {
    "speciality" : speciality,
    "type" : type,
    "status" : status, 
    "query" : query,
    "offset" : offset
  };

  let params = new URLSearchParams();

  updateParams(filters, params);

  let url = new URL(window.location.href);

  axios
    .get(url.pathname + "?" + params.toString() + "&ajax=1")
    .then((response) => {
      $(`.content`).html(response.data);
    })
    .catch((error) => {
      // '${.content}'.html = `Erreur: ${error.message}`;
      // '${.content}'.parent().html = `Erreur: ${error.message}`;
      console.error("Il y a une erreur dans la requête", error);
    });

  let newParams = new URLSearchParams();
  updateNewParams(filters, newParams);

  // Mise à jour de l'url
  if (newParams.toString() === "") {
    history.pushState({}, null, url.pathname);
  } else {
    history.pushState({}, null, url.pathname + "?" + newParams.toString());
  }
});

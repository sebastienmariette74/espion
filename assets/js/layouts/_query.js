// const axios = require('axios').default;

const $ = require("jquery");

/* _____________________FILTRE PAR MOT_____________________________*/
$(".js-query").on("keyup", function () {
  // event.preventDefault();
  // let speciality = $('.filter-speciality option:selected').val();
  // let filter = $(this).attr("name");
  // let page = $(".search input:hidden").attr("value");
  let speciality = $("#filter-speciality option:selected").val();
  let type = $("#filter-type option:selected").val();
  let status = $("#filter-status option:selected").val();
  let query = $(".js-query").val();

  let params = new URLSearchParams();
  // params.append("page", page);
  // let params = new URLSearchParams(window.location.search);
  if (query === "") {
    console.log("ok");
  } else if (params.get("query")) {
    params.set("query", query);
  } else {
    params.append("query", query);
  }
  if (speciality === "") {
    console.log("ok");
  } else if (params.get("speciality")) {
    params.set("speciality", speciality);
  } else {
    params.append("speciality", speciality);
  }

  if (type === "") {
    console.log("ok");
  } else if (params.get("type")) {
    params.set("type", type);
  } else {
    params.append("type", type);
  }

  if (status === "") {
    console.log("ok");
  } else if (params.get("status")) {
    params.set("status", status);
  } else {
    params.append("status", status);
  }

  let url = new URL(window.location.href);
  // async(url.pathname + "?" + params.toString() + "&ajax=1", "content");

  axios
    .get(url.pathname + "?" + params.toString() + "&ajax=1")
    .then((response) => {
      $(`.content`).html(response.data);
      // if (element != null) {
      // $(`.${element}`).html(response.data);
      // }
    })
    .catch((error) => {
      // '${.content}'.html = `Erreur: ${error.message}`;
      // '${.content}'.parent().html = `Erreur: ${error.message}`;
      console.error("Il y a une erreur dans la requête", error);
    });

    let newParams = new URLSearchParams();
    // let params = new URLSearchParams(window.location.search);
    if (query === "" || query === 0) {
      console.log(query);
    } else if (newParams.get("query")) {
      newParams.set("query", query);
    } else {
      newParams.append("query", query);
    }
  
    if (speciality === "" || speciality === 0) {
      console.log(speciality);
    } else if (newParams.get("speciality")) {
      newParams.set("speciality", speciality);
    } else {
      newParams.append("speciality", speciality);
    }
  
    if (type === "" || type === 0) {
      console.log("ok");
    } else if (newParams.get("type")) {
      newParams.set("type", type);
    } else {
      newParams.append("type", type);
    }
  
    if (status === "" || status === 0) {
      console.log("ok");
    } else if (newParams.get("status")) {
      newParams.set("status", status);
    } else {
      newParams.append("status", status);
    }
    // On met à jour l'url
    // history.pushState({}, null, url.pathname );
    if (newParams.toString() === "") {
      history.pushState({}, null, url.pathname);
    } else {
      history.pushState({}, null, url.pathname + "?" + newParams.toString());
    }
});

let params = new URLSearchParams(window.location.search);
if (params.get("speciality")) {
  $(".filter-speciality").val(params.get("speciality"));
}

/* _____________________FILTRES_____________________________*/
$(".content").on("change", ".filter", function () {
  // let page = $(".search input:hidden").attr("value");
  // console.log(page);
  let speciality = $("#filter-speciality option:selected").val();
  let type = $("#filter-type option:selected").val();
  let status = $("#filter-status option:selected").val();
  let query = $(".js-query").val();

  let params = new URLSearchParams();
  // params.append('page', page);
  // let params = new URLSearchParams(window.location.search);
  if (query === "") {
    console.log("ok");
  } else if (params.get("query")) {
    params.set("query", query);
  } else {
    params.append("query", query);
  }
  if (speciality === "") {
    console.log("ok");
  } else if (params.get("speciality")) {
    params.set("speciality", speciality);
  } else {
    params.append("speciality", speciality);
  }

  if (type === "") {
    console.log("ok");
  } else if (params.get("type")) {
    params.set("type", type);
  } else {
    params.append("type", type);
  }

  if (status === "") {
    console.log("ok");
  } else if (params.get("status")) {
    params.set("status", status);
  } else {
    params.append("status", status);
  }

  let url = new URL(window.location.href);
  // async(url.pathname + "?" + params.toString() + "&ajax=1", "content");

  axios
    .get(url.pathname + "?" + params.toString() + "&ajax=1")
    .then((response) => {
      $(`.content`).html(response.data);
      // if (element != null) {
      // $(`.${element}`).html(response.data);
      // }
    })
    .catch((error) => {
      // '${.content}'.html = `Erreur: ${error.message}`;
      // '${.content}'.parent().html = `Erreur: ${error.message}`;
      console.error("Il y a une erreur dans la requête", error);
    });

  // if (params.get('speciality')) {
  //   let string = $('#filter-speciality').text(params.get('speciality'));
  //   console.log(string);
  // };

  let newParams = new URLSearchParams();
  // newParams.append('page', page);
  // let params = new URLSearchParams(window.location.search);
  if (query === "" || query === 0) {
    console.log(query);
  } else if (newParams.get("query")) {
    newParams.set("query", query);
  } else {
    newParams.append("query", query);
  }

  if (speciality === "" || speciality === 0) {
    console.log(speciality);
  } else if (newParams.get("speciality")) {
    newParams.set("speciality", speciality);
  } else {
    newParams.append("speciality", speciality);
  }

  if (type === "" || type === 0) {
    console.log("ok");
  } else if (newParams.get("type")) {
    newParams.set("type", type);
  } else {
    newParams.append("type", type);
  }

  if (status === "" || status === 0) {
    console.log("ok");
  } else if (newParams.get("status")) {
    newParams.set("status", status);
  } else {
    newParams.append("status", status);
  }
  // On met à jour l'url
  // history.pushState({}, null, url.pathname );
  if (newParams.toString() === "") {
    history.pushState({}, null, url.pathname);
  } else {
    history.pushState({}, null, url.pathname + "?" + newParams.toString());
  }
});

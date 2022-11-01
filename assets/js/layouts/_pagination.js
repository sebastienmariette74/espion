const $ = require("jquery");

/*_______________ PAGINATION ________________________*/
$(".content").on("click", ".page-link", function (e) {
    e.preventDefault();
    let params = $(this).attr("href");
    let url = new URL(window.location.href);
    axios
      .get(url.pathname + params + "&ajax=1")
      .then((response) => {
        $(`.content`).html(response.data);
      })
      .catch((error) => {
        // '${.content}'.html = `Erreur: ${error.message}`;
        // '${.content}'.parent().html = `Erreur: ${error.message}`;
        console.error("Il y a une erreur dans la requête", error);
      });
});




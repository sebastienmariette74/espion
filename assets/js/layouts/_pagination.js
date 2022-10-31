const $ = require("jquery");

// let link = $('.page-link');

// link.on('click', function (event) {
//     event.preventDefault();

//     let url = this.href;
//     // let url = new URL(window.location.href);
//     // async(url.pathname + "?" + params.toString() + "&ajax=1", "content");

    
//     axios
//       .get(url + "&ajax=1")
//       .then((response) => {
//         $(`.content`).html(response.data);
//         // if (element != null) {
//         // $(`.${element}`).html(response.data);
//         // }
//       })
//       .catch((error) => {
//         // '${.content}'.html = `Erreur: ${error.message}`;
//         // '${.content}'.parent().html = `Erreur: ${error.message}`;
//         console.error("Il y a une erreur dans la requête", error);
//       });
    
// })
// // $('.page-link').each(function (event) {
// //     $item = $this;
// //     console.log($item);
// //     event.preventDefault();    
// // })


// import {async} from "../../functions/async.js"

/*_______________ PAGINATION ________________________*/
$(".content").on("click", ".page-link", function (e) {
    e.preventDefault();
    let params = $(this).attr("href");
    let url = new URL(window.location.href);
    // console.log(window.location);
    // async(url.pathname + params + "&ajax=1", "content");
    axios
      .get(url.pathname + params + "&ajax=1")
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
});




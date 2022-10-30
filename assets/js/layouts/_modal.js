const $ = require("jquery");



// $('.open-modal').on('click', function(event){
//     event.preventDefault();
//     console.log('modal');
//     $('.modal').css('display', 'block');

//     let url = new URL(window.location);
//     axios
//       .get(url.origin + '/admin/targets/creation-target' + '/?&ajax=1')
//       .then((response) => {
//         $(`.modal-body`).html(response.data);
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
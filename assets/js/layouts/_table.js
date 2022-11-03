const $ = require('jquery');

/* ouverture d'une infobulle au passage de la souris sur les éléments d'une liste */
$('.table-show').on('mouseover', 'li', function(event){
        let code = $(this).text();
        let firstUrl = $(this).data('firsturl');
        let url = new URL(window.location);
        axios
        .get(url.origin + '/' + firstUrl + '/' + code)
        .then((response) => {
            if ($('.details').length < 1){
                $("<div class='details'></div>").insertBefore($(this).parent("ul"));
            $(`.details`).html(response.data);
            let heightDetails = $('.details').height();
            let top = '-' + (heightDetails) + 'px';
            $(`.details`).css('top', top);
            }            
        })
        .catch((error) => {
            // '${.content}'.html = `Erreur: ${error.message}`;
            // '${.content}'.parent().html = `Erreur: ${error.message}`;
            console.error("Il y a une erreur dans la requête", error);
        });
    
});

/* fermeture de l'infobulle */
$('.table-show').on('mouseout', 'li', function(){    
      $('.details' ).remove();
});
$('.table-show').on('mouseout', '.details', function(){    
      $('.details' ).remove();
});


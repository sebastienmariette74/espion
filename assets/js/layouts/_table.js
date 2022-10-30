const $ = require('jquery');
console.log($('.details').length);

// console.log('table');

$('.table-mission li').css('cursor', 'pointer');

$('.table-mission').on('mouseover', 'li', function(event){
        console.log($('.details').length);
        let code = $(this).text();
        firstUrl = $(this).data('firsturl')
        secondUrl = $(this).data('secondurl')
        let url = new URL(window.location);
        axios
        .get(url.origin + '/admin/' + firstUrl + '/' + secondUrl + '/' + code)
        .then((response) => {
            // let li = $(this);
            if ($('.details').length < 1){
                $("<div class='details'></div>").insertBefore($(this).parent("ul"));
            $(`.details`).html(response.data);
            // if (element != null) {
            // $(`.${element}`).html(response.data);
            // }
            let heightDetails = $('.details').height();
            console.log(heightDetails);
            let top = '-' + (heightDetails) + 'px';
            console.log(top);
            $(`.details`).css('top', top);
            }
            
        })
        .catch((error) => {
            // '${.content}'.html = `Erreur: ${error.message}`;
            // '${.content}'.parent().html = `Erreur: ${error.message}`;
            console.error("Il y a une erreur dans la requête", error);
        });
    
});

$('.table-mission').on('mouseout', 'li', function(){    
      $('.details' ).remove();
});
$('.table-mission').on('mouseout', '.details', function(){    
      $('.details' ).remove();
});


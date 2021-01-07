// Attend le chargement du DOM
$(function() {

    // Ecouteurs d'évènements sur chaque étoile
    $(".starRating svg").each(function() 
    {
        $(this).on("mouseover", overStar);
        $(this).on("mouseout", outstar);
        $(this).on("click", clickStar);
    });
});

/* Affiche en couleur les étoiles survolées */
function overStar()
{
    // Stock l'attribut data-rating de l'étoile actuel
    let indexStar = $(this).attr("data-rating");

    // Affiche en couleur les étoiles dont l'attribut data-rating < data-rating étoile actuel
    $(".starRating svg").each(function() {
        if($(this).attr("data-rating") <= indexStar) {
            $(this).addClass("yellow");
        }
        else {
            $(this).removeClass("yellow");
        }
    });
}

/* Enlève la couleur de toutes les étoiles */
function outstar() 
{
    $(".starRating svg").each(function() {
        $(this).removeClass("yellow");
    });
}

/* Affiche en couleur les étoiles sélectionnés lors du click, 
/* arrête les autres écouteurs d'évènements et stock la note attribuée dans un input caché */
function clickStar()
{
    // Stock l'attribut data-rating de l'étoile actuel
    let indexStar = $(this).attr("data-rating");

    // Affiche en couleur les étoiles dont l'attribut data-rating < data-rating étoile actuel
    $(".starRating svg").each(function() {
        if($(this).attr("data-rating") <= indexStar) {
            $(this).addClass("yellow");
        }
        else {
            $(this).removeClass("yellow");
        }
    });

    // Arrête les autres écouteurs d'évènements
    $(".starRating svg").off("mouseover");
    $(".starRating svg").off("mouseout");

    // Stock la note attribuée
    $("#starRate").attr('value', indexStar);
}
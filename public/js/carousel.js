// Tableau des images
let images = [];

// Tableau des indicateurs
let circleArray = [];

// Index correspondant à l'image actuelle
let index = 0;

// Variable pour le setInterval
let timer;

// Attend que le DOM soit chargé
$(function() {

    // Récupération de l'id du produit dans l'attribut "data-productId" de la balise img
    let productId = $(".masthead img").attr('data-productId')

    $.ajax({
        url: '/pictures',
        type: 'POST',
        dataType : 'json',
        data : {'productId' : productId},
        success: function(response) {
            for (i=0; i<response['pictures'].length; i++) {
                images[i] = response['pictures'][i];
            }

            // Crée les indicateurs en bas des images
            createIndicators();

            // Boucle sur tous les svg contenu dans la DIV "circle"
            $("#circle svg").each(function() {
                // Ecouteur d'évènements sur chaque svg
                $(this).on("click", indicatorChangeImage);

                // Stock chaque svg dans un tableau
                circleArray.push($(this));
            });
        },
        error: function(error){
            console.log(error);
            console.log('error');
        }
    });
    
    // Crée la flèche de gauche et de droite
    createArrow();

    // Lancement du carousel
    startCarousel();

    // Écouteurs d'évènements
    // Start/stop slide
    $(".masthead").on("mouseover", stopCarousel);
    $(".masthead").on("mouseout", startCarousel);

    // Flèche de droite
    $("#avancer").on("click", avancer);

    // Flèche de gauche
    $("#reculer").on("click", reculer);
});

// Créer les flèches gauche et droite
function createArrow() 
{
    // Mets une flèche à gauche des images
    $(".masthead").prepend(
        `<div style="position: absolute;z-index: 1;left: 2%;top: 50%;cursor: pointer">`
        +`<svg id="reculer" width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-caret-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">`
        +`<path fill-rule="evenodd" d="M10 12.796L4.519 8 10 3.204v9.592zm-.659.753l-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"/>`
        +`</svg>`
        +`</div>`
    );

    // Mets une flèche à droite des images
    $(".masthead").append(
        `<div style="position: absolute;z-index: 1;right: 2%;top: 50%;cursor: pointer">`
        +`<svg id="avancer" width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-caret-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">`
        +`<path fill-rule="evenodd" d="M6 12.796L11.481 8 6 3.204v9.592zm.659.753l5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>`
        +`</svg>`
        +`</div>`
    );
}

// Créer les indicateurs en bas des images
function createIndicators() 
{
    // Crée une div "circle" en bas des images
    $(".masthead").append(`<div id="circle" class="text-center" style="color: black;position: absolute;left: 42%;bottom: 0;z-index: 1"></div>`);

    // Boucle sur sur le tableau image afin de mettre autant d'indicateurs que d'images
    for (let i = 0; i < images.length; i++) {
        // Crée des svg pour chaque image dans la div "circle"
        // Ajout d'un attribut "data-index" contenant l'index du tableau en cours
        $("#circle").append(
            `<svg style="cursor: pointer" data-index="`+ i +`" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-circle mr-3" fill="currentColor" xmlns="http://www.w3.org/2000/svg">`
            +`<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>`
            +`</svg>`
        );
    }
}

// Démarre le carousel
function startCarousel() 
{
    timer = setInterval(avancer, 4000);
}

// Stop le carousel
function stopCarousel() 
{
    clearInterval(timer);
}

// Afficher l'image et l'indicateur correspondant
function setBackground() 
{
    // Modification de l'attribut "src" en lui ajoutant le prochain url de mon tableau
    $(".masthead img").attr("src", 'images/'+images[index]);
    
    // Affiche l'indicator correspondant à l'image actuelle en noir
    $("#circle svg").css({"background-color": "", "border-radius": ""});
    circleArray[index].css({"background-color": "black", "border-radius": "50%"});
}

// Passe à l'image suivante du carousel
function avancer() 
{
    // Si l'index = dernier index du tableau, réinitialise l'index sinon l'incrémente
    index == images.length - 1 ? index = 0 : index++;

    // Affiche l'image et l'indicateur correspondant
    setBackground();
    console.log(index)
}

// "Recule" dans le carousel
function reculer() 
{
    // Si l'index = 0, initialise l'index au dernier index du tableau sinon le décrémente
    index == 0 ? index = images.length - 1 : index--;

    // Affiche l'image et l'indicateur correspondant
    setBackground();
}

// Change l'image du slide selon l'indicateur cliqué
function indicatorChangeImage() 
{
    // Récupération de la valeur contenu dans l'attribut "data-index"
    index = $(this).attr("data-index");

    // Affiche l'image et l'indicateur correspondant
    setBackground();
}
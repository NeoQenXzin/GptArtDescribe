console.log('ca fonctionne');
$(document).ready(function () {
    function updateHoriSelector() {
        var $activeNavItem = $('#navbarSupportedContent .nav-item.active');
        var activePos = $activeNavItem.position();
        var activeWidth = $activeNAVitem.outerWidth();
        var activeHeight = $activeNavItem.outerHeight();

        // Mettre à jour la position du hori-selector pour suivre l'élément actif
        $('.hori-selector').css({
            'top': (activePos.top + activeHeight) + 'px', // Ajustez ici si nécessaire
            'left': activePos.left + 'px',
            'width': activeWidth + 'px'
        });
    }

    // Gestionnaire de clic pour mettre à jour la classe 'active' et repositionner le hori-selector
    $('#navbarSupportedContent .nav-link').click(function () {
        $('#navbarSupportedContent .nav-item').removeClass('active');
        $(this).parent().addClass('active');
        updateHoriSelector(); // Mettre à jour la position du hori-selector
    });

    // Initialiser le hori-selector et mettre à jour sur le redimensionnement
    updateHoriSelector();
    $(window).resize(updateHoriSelector);

    // Gestion du collapsible navbar pour les vues mobiles
    $(".navbar-toggler").click(function () {
        $(".navbar-collapse").slideToggle(300, updateHoriSelector); // Mettre à jour après la transition
    });
});

// Si la navigation change dynamiquement (par exemple via SPA ou changements d'état internes),
// vous pouvez appeler `updateHoriSelector()` pour réajuster le sélecteur.

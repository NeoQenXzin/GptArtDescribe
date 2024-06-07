// ---------Responsive-navbar-active-animation-----------
function test() {
    var activeItem = $('#navbarSupportedContent .nav-item.active');
    var horiSelector = $(".hori-selector");

    if (activeItem.length) {
        var itemPos = activeItem.position();
        var itemWidth = activeItem.innerWidth();
        var itemHeight = activeItem.innerHeight();

        horiSelector.css({
            "top": itemPos.top + itemHeight + "px",  // Assuming you want it right below the item
            "left": itemPos.left + "px",
            "width": itemWidth + "px",
            "height": "4px"  // Adjust the height of the hori-selector if needed
        });
    }
}

$(document).ready(function () {
    // Set active class based on current URL
    var currentPath = window.location.pathname.split("/").pop();
    $('#navbarSupportedContent .nav-item a').each(function () {
        var linkPath = new URL($(this).attr('href'), window.location.origin).pathname.split("/").pop();
        if (linkPath === currentPath) {
            $(this).parent().addClass('active');
        }
    });

    test();  // Initialize hori-selector position

    $("#navbarSupportedContent").on("click", "li", function (e) {
        $('#navbarSupportedContent ul li').removeClass("active");
        $(this).addClass('active');
        test();  // Update hori-selector position
    });

    $(window).on('resize', test);  // Update on resize

    $(".navbar-toggler").click(function () {
        $(".navbar-collapse").slideToggle(300);
        setTimeout(test, 300);  // Ensure the animation completes
    });
});

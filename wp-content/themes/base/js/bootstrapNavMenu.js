(function($) {
    $(function() {
        var $body = $('body'),
            $nav = $('<header class="header"><nav class="navbar">' +
                '<div class="container-fluid">' +
                '<div class="navbar-header">' +
                '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">' +
                '<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>' +
                '</button>' +
                '<a class="go-back active navbar-brand">wpREST</a>' +
                '</div>' +
                '<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">' +
                '<ul class="main-nav nav navbar-nav">' +
                '<li class="active"><a class="go-back">HOME <span class="sr-only">(current)</span></a></li>' +
                '<li class="dropdown pages">' +
                '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PAGES <span class="caret"></span></a>' +
                '<ul class="dropdown-menu pages">' +
                '</ul>' +
                '</li>' +

                '<li class="dropdown menus">' +
                '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">MENUS <span class="caret"></span></a>' +
                '<ul class="dropdown-menu menus">' +
                '</ul>' +
                '</li>' +
                '</ul>' +
                '</div>' +
                '</div>' +
                +'</nav></header>');

        $body.prepend($nav);
        $sidebarRight = $body.find('.sidebar-right');
        //$sidebarRight.find('.page-link').append('<li><h4>PAGES</h4></li>');

        $featuredImage = $('<figure><img class="featured-image" src="http://localhost/wpREST_mohamad_rashid/wp-content/uploads/2013/03/image-alignment-1200x4002.jpg" /></figure>');
        $nav.after($featuredImage);
        $('.header').headtacular({
            scrollPoint: 100
        });

    });
})(jQuery)

(function($) {

    /**
     * API Documentation:
     * http://v2.wp-api.org/reference/
     *
     * API URLs:
     */

    var baseHref = $('head base').attr('href'),
        // api available after saving permalinks settings
        apiBase = baseHref + 'wp-json/wp/v2/',
        // the add-on menu plugin has a different base
        menuApiBase = baseHref + 'wp-json/wp-api-menus/v2/';




})(jQuery);

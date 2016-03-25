(function($) {

    /**
     * API Documentation:
     * http://v2.wp-api.org/reference/
     *
     * API URLs:
     */
    var baseHref = $('head .baseUrl').attr('href'),
        themeHref = $('head .themeUrl').attr('href'),
        // api available after saving permalinks settings
        apiBase = baseHref + 'wp-json/wp/v2/',
        // the add-on menu plugin has a different base
        menuApiBase = baseHref + 'wp-json/wp-api-menus/v2/';
        // $.getJSON(baseHref + 'uploads/upload_dir', function(data) {
        //         /*optional stuff to do after success */
        //         // $('body').append(data.content.rendered)
        //         console.log(data);
        //         // getDir();
        // });
// //console.log(dirArr);
// $.getJSON(baseHref + 'wp-content/json/static-pages.json',function(data) {
//     console.log(data);
// })

var url = themeHref + '/json/static-pages.json';

$.getJSON(url, function(data) {
    var urls = data.static_urls;
    for(var url in urls) {
        var parts = urls[url],
            result = parts.split('/');
        console.log(result[8]);
    }


})

})(jQuery);

var initApi = (function($) {

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


    // create object to hold our RESTapi routes
    var resources = [
        //{route: apiBase + "users", className: "User", list: "users"},
        {
            route: apiBase + "posts/?per_page=100",
            className: "Post",
            type: "post",
            list: "posts"
        }, {
            route: apiBase + "comments",
            className: "Comment",
            type: "comment",
            list: "comments"
        }, {
            route: apiBase + "pages",
            className: "Page",
            type: "page",
            list: "pages"
        }, {
            route: apiBase + "media",
            className: "Media",
            type: "media",
            list: "media"
        }, {
            route: apiBase + "categories",
            className: "Category",
            type: "category",
            list: "categories"
        }, {
            route: apiBase + "tags",
            className: "Tag",
            type: "tag",
            list: "tags"
        }, {
            route: menuApiBase + "menus",
            className: "Menu",
            type: "menu",
            list: "menus"
        }
    ];


    /*
     * ajax function is the main function that hold jQuery
     * ajax method. this function give us the opportunity
     * to use HTTP methods for RESTfull services like
     * POST, GET, PUT, PATCH and DELETE
     */
    function ajax(url, type, data, callBack) {
        // define the default HTTP method
        type = type || 'GET';
        var res = $.ajax({
            url: url,
            type: type,
            data: data
        });
        // if the request success will call the callback function
        res.success(function(data) {
            callBack(data);
        });
        // if failed dispaly the error details
        res.fail(function(err) {
            console.error('response err', err.status);
        });
    }

    return {
        ajax: ajax,
        resources: resources,
        homeUrl: baseHref
    }

})(jQuery);


(function($) {
    $(function() {
        // bootstrap navbar
        var $blog = $('.blog'),
            $categories = $('<ul class="categories-menu col-md-4"/>');
        $container = $('<div class="page-menu col-md-12"><ul class="page-link col-md-4"></ul></div><div class="container"><div class="row"><div class="content col-md-12"></div></div></div>');


        // append div container to body
        $container.prependTo($blog);
        $categories.appendTo('.page-menu');

        // get the data from REST routes and store it in memory object
        var memory = {},
            countLoadedResources = 0;

        // loop through resources
        initApi.resources.forEach(function(resource) {
            // call ajax method
            initApi.ajax(resource.route, null, null, function(data) {
                memory[resource.list] = data;
                countLoadedResources++;
                if (countLoadedResources == initApi.resources.length) {
                    //  call classify method
                    classify();
                    // call postTeaser method to render all post
                    postTeaser();
                    // render menus
                    renderMenus();
                    // pages menu
                    pagesMenu();
                    // render category menu
                    categoryMenu();

                }
            });
        });




        var resourceByType = {};
        var resourcesByList = {};
        for (i in initApi.resources) {
            resourceByType[initApi.resources[i].type] = initApi.resources[i];
            resourcesByList[initApi.resources[i].list] = initApi.resources[i];
        }


        function classify() {
            for (listName in memory) {
                var list = memory[listName];
                var className = resourcesByList[listName].className;

                var classObj = appBuilder.classMemory[className];


                // A map loop through the array of objects
                // and replace with "classified" objects
                // (i.e. objects that have a certain prototype)
                // Replace the old list with the new one in the
                // memory variable
                if (list.push) { // array, classify each item
                    memory[listName] = list.map(function(listItem) {

                        return classObj.extend(listItem);
                    });
                } else { // object, classify it
                    memory[listName] = classObj.extend(list);
                }
                //console.log('memory.' + listName, memory[listName]);
            }
        };

        // render menus
        function renderMenus() {

            var menus = memory.menus;
            // loop theroug all menus
            for (var i = 0; i < menus.length; i++) {
                // get all menus
                initApi.ajax(resourceByType['menu'].route + '/' + menus[i].ID, null, null, function(data) {
                    var children = data.items;

                    for (var i = 0; i < children.length; i++) {

                        if (children[i].url !== "#") {

                            // check if menu items array is not empty
                            if (data.items.length > 0) {
                                // if mene have items create dropdown menu
                                $menuName = ('<li class="dropdown dropdown-submenu"><a data-type="menu" data-id="' + data.ID + '" class="dropdown-toggle" data-toggle="dropdown">' + data.name + '</a><ul></ul><li>');
                                $('.dropdown-menu.menus').append($menuName);
                                var className = resourceByType['menu'].className;
                                data = appBuilder.classMemory[className].extend(data);
                                data.render();
                            }
                            break;
                        }
                    };

                });

            };
        }

        // dispaly post teaser version
        function postTeaser() {
            var posts = memory.posts;
            for (var i = 0; i < posts.length; i++) {
                memory.posts[i].teaser();
            }
        };

        // create menu that contain links to every page
        function pagesMenu() {
            var pages = memory.pages;
            for (var i = 0; i < pages.length; i++) {
                memory.pages[i].pageLink();
            };
        };

        function categoryMenu() {
            var categories = memory.categories;
            for (var i = 0; i < categories.length; i++) {
                memory.categories[i].renderCatMenu();
            };
        }

        function displayResource(type, id) {

            var url = resourceByType[type].route + '/' + id;
            var className = resourceByType[type].className;
            //console.log(className);

            initApi.ajax(url, null, null, function(data) {
                data = appBuilder.classMemory[className].extend(data);
                data.render();

            });
        };


        // click event
        $('body').delegate('.link', 'click', getContent);
        $blog.delegate('.go-back', 'click', homePage);

        function homePage() {
            window.location.href = initApi.homeUrl;
            //location.reload();
        };


        function getContent(event) {

            var type = $(this).attr('data-type');
            var id = $(this).attr('data-id');
            displayResource(type, id);

        };

    });
})(jQuery)

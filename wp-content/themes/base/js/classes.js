var appBuilder = (function($) {


    // The base object is our "inheritance engine"
    var Base = {
        extend: function(properties) {
            // create a new object with this object as its prototype
            var obj = Object.create(this);
            // add properties to the new object
            Object.assign(obj, properties);
            return obj;
        }
    };

    // // A memory for all "classes"
    var classMemory = {};

    // A base class for all things WordPressish
    classMemory.BaseWP = Base.extend({
        render: function() {}
    });


    classMemory.Post = classMemory.BaseWP.extend({
        // render full version page and posts
        render: function() {


            // call restyleThisPageTite method
            this.restyleThisPageTite(this.id);

            // get title
            $title = ('<h2><a class="link" data-id ="' + this.id + '" data-type="' + this.type + '">' + this.title.rendered + '</a></h2>');
            // get content
            $content = ('<article>' + this.content.rendered + '</article>');
            // go back link
            $goBackLink = ('<a class="go-back"><span class="glyphicon glyphicon-menu-left"></span> Go back</a>');
            // attach content to dom
            $('.content').html('<section data-id="' + this.id + '">' + $title + $content + $goBackLink + '</section>');
            classMemory.Tag.displayCategories(this._links["https://api.w.org/term"], this.id, this.tags, 'tags', 'tag', this.date);
            classMemory.Category.displayCategories(this._links["https://api.w.org/term"], this.id, this.categories, 'categories', 'category', this.date);
            classMemory.Media.attachment(this._links["https://api.w.org/attachment"]);
            //console.log(this._links["https://api.w.org/attachment"]);
            classMemory.Comment.getComment(this._links, this.id);
            console.log(this)
        },
        // dispaly teaser version page or post
        teaser: function() {

            // post title as a link
            $postLink = ('<a class="link" data-id="' + this.id + '" data-type="' + this.type + '">' + this.title.rendered + '</a>');
            $title = ('<h2>' + $postLink + '</h2>');

            // get post teaser version
            $content = ('<article>' + this.excerpt.rendered + '<button type="button" class="link btn btn-default btn-sm" data-id ="' + this.id + '" data-type="' + this.type + '">REMD MORE</button>' + '</article>');

            // appent post content to the container
            $('.content').append('<section data-id="' + this.id + '">' + $title + $content + '</section>');

            // call displayCategories method to display post tags
            classMemory.Tag.displayCategories(this._links["https://api.w.org/term"], this.id, this.tags, 'tags', 'tag', this.date);
            // call displayCategories method to display post categories
            classMemory.Category.displayCategories(this._links["https://api.w.org/term"], this.id, this.categories, 'categories', 'category', this.date);
        },
        // this method restyle page header which located under featured image
        restyleThisPageTite: function(pageId) {
            // get page data-id attribute
            $thisEl = $('li[data-id="' + pageId + '"]');
            $thisElIndex = $thisEl.index();

            $thisEl.detach();
            //$thisEl.attr('class', 'col-md-12');
            //$('.page-menu').css({ paddingBottom: 0 });
            $thisEl.find('a').css({
                fontSize: '2.5rem',
                paddingTop: '2rem',
                color: '#fff',
            });

            $('.page-link').append($thisEl);
            $thisEl.css({
                backgroundColor: 'gray',
                opacity: 0
            });

            $thisEl.animate({
                marginTop: '2rem',
                padding: '1rem 0 1rem 2rem',
                opacity: 1
            }, 600);
            // call thisElIndex method
            this.thisElIndex($thisElIndex, pageId);
        },
        thisElIndex: function(i, id) {
            if (storage.read('li-index') == null) {
                // save title element index and post id to localStorage
                storage.write('li-index', {
                    'index': i,
                    'dataId': id
                });
            } else {
                // call reStypePrevElem method
                this.reStylePrevElem();
                // right to localStorage localStoage
                storage.write('li-index', {
                    'index': i,
                    'dataId': id
                })
            }
        },
        reStylePrevElem: function() {
            // read from localStoage
            var getEl = storage.read('li-index');
            //storage.remove(getEl);

            var $liElm = $('li[data-id="' + getEl.dataId + '"]'),
                $link = $liElm.find('a');
            // remove style attribute
            $link.removeAttr('style');
            $liElm.removeAttr('style');
            //$liElm.addClass('col-md-3');
        },
        // format posts date
        postDate: function(date) {
            // instantiate Date object
            var date = new Date(date).toString(),
                // create empty array to hold the results
                formatedDate = [];

            for (var i = 0; i < 16; i++) {
                formatedDate.push(date[i]);
            };
            // take off commas and return the array
            return formatedDate.join("");
        }

    });

    classMemory.Page = classMemory.Post.extend({
        pageLink: function() {
            $pageLink = ('<a class="link" data-id ="' + this.id + '" data-type="' + this.type + '">' + this.title.rendered + '</a>');
            $pageList = $('<li>' + $pageLink + '</li>');
            $('.dropdown-menu.pages').append($pageList);
            $('.page-link').append('<li data-id ="' + this.id + '">' + $pageLink + '</li>')
            //console.log(this);
        }

    });

    classMemory.Comment = classMemory.BaseWP.extend({
        // lets add som specific methods here later
        getComment: function(obj, id) {
            var $postId = $('section').attr('data-id'),
                resources = initApi.resources;

            for (var i in obj) {
                var comment = obj[i];
                for (var i = 0; i < comment.length; i++) {
                    if (comment[i].href.search('comments') != -1) {
                        var url = comment[i].href;
                        initApi.ajax(url, null, null, function(data) {

                            for (var i in data) {
                                var content = data[i].content.rendered,
                                    auth_name = data[i].author_name,
                                    posted = data[i].date,
                                    avatar = data[i].author_avatar_urls[48],
                                    $commtHolder = $('<article> <div class="panel panel-default"> <div class="panel-heading"><p>' + classMemory.Post.postDate(posted) +
                                        '</p></div> <div class="panel-body"> <img src="' + avatar + '" /> <span>' + auth_name + '</span>' + content + '</div></div> </article>');
                                $('.content').find("article").after($commtHolder);

                                console.log(data[i]);
                            }
                        });

                    }
                };
            };

        }
    });

    classMemory.Media = classMemory.BaseWP.extend({
        // lets add som specific methods here later
        attachment: function(attachment) {
            // loop through media object to specific post "this"
            for (attach in attachment) {
                // get the object with ajax method
                initApi.ajax(attachment[attach].href, null, null, function(obj) {
                    for (prop in obj) {
                        // display featured image
                        var $img = $('<img src="' + obj[prop].source_url + '" alt="' + obj[prop].alt_text + '" />');
                        $('figure').html($img);
                    }
                })
            }
        }
    });

    classMemory.Category = classMemory.BaseWP.extend({
        render: function() {

            var $postTeaser = $('section'),
                $catLinks = $postTeaser.find('a[data-name="' + this.name + '"]');

            $('.content').html($catLinks.closest('section'));

        },
        displayCategories: function(links, postid, catsId, type, taxonomy, postedOn) {
            var catObj = {},
                $catHolder = $('<ul class="taxonomy ' + type + '"/>'),
                $postedOn = ('<li>Posted: ' + classMemory.Post.postDate(postedOn) + '</li>');
            $taxoHeader = $('<li>' + type + '</li>');
            $catHolder.prepend($taxoHeader);
            if (type == 'categories') {
                $catHolder.prepend($postedOn);
            }

            for (link in links) {

                if (links[link].href.search(type) !== -1) {
                    var $postHeader = $('.content').find('a[data-id="' + postid + '"]'),
                        $dataId = $postHeader.attr('data-id');

                    initApi.ajax(links[link].href, null, null, function(data) {
                        for (catId in data) {
                            catsId.forEach(function(id) {
                                if (data[catId].id == id) {
                                    catObj[postid] = data[catId].name;
                                    for (key in catObj) {

                                        if (key == $dataId) {
                                            var $taxonomey = $catHolder.append('<li><a class="link" data-type="' + taxonomy + '" data-id="' + id + '" data-name="' + catObj[key] + '">' + catObj[key] + '</a></li>');
                                            $postHeader.closest("h2").after($taxonomey);
                                        }
                                    }

                                }
                            });
                        }
                    });
                }

            }

        },
        renderCatMenu: function() {}

    });
    // Tag prototype extending Category prototype
    classMemory.Tag = classMemory.Category.extend({

    });

    classMemory.Menu = classMemory.BaseWP.extend({
        render: function() {
            var pages = this.items;
            for (var i = 0; i < pages.length; i++) {
                var $dropdownContainer = $('.dropdown-submenu a[data-id=' + this.ID + ']').next(),

                    $menuLink = ('<a class="link" data-id ="' + pages[i].object_id + '" data-type="' + pages[i].object + '">' + pages[i].title + '</a>');
                $dropdownContainer.append('<li>' + $menuLink + '</li>');

            };
        }
    });

    return {
        classMemory: classMemory
    }

})(jQuery);

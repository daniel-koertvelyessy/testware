console.log('typeahead loaded');
$('.js-typeahead-user_v1').typeahead({
    minLength: 2,
    maxItem:5,
    order: "asc",
    dynamic: true,
    hint:true,
    delay: 500,
    template: function (query, item) {

        return '<span class="pl-3 row"><span class="id">({{value}})</span>' +
            '<span class="ml.2">{{label}}</span>' +

            "</span>"
    },
    emptyTemplate: "Keine Ergebnbisse für {{query}}",
    source: {
        loc: {
            display: "name",
            href: "location/{{id}}",
            ajax: function (query) {
                return {
                    type: "GET",
                    url: "/autocomplete",
                    path: "",
                    data: {
                        term: "{{query}}"
                    },
                    callback: {
                        done: function (data) {
                            console.log(data);
                            return data.loc;
                        }
                    }
                }
            }
        },
        geb: {
            display: "name",
            href: "/building/{{id}}",
            // data: [{
            //     "id": 415849,
            //     "username": "an inserted user that is not inside the database",
            //     "avatar": "https://avatars3.githubusercontent.com/u/415849",
            //     "status": "contributor"
            // }],
            ajax: [ {

                type: "GET",
                url: "/autocomplete",
                path: "",
                data: {
                    term: "{{query}}"
                }
            },"data.project"],
            template: '<span>' +
                '<span class="project-information">' +
                '<span class="project">{{ame}} <small>{{id}}</small></span>' +
                '</span>' +
                '</span>'

        }
    }


});

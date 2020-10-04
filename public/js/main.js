console.log("main.js loaded");
/**
 * jQuery Plugin: Sticky Tabs
 *
 * @author Aidan Lister <aidan@php.net>
 * @version 1.2.0
 */
(function($) {
    $.fn.stickyTabs = function(options) {
        var context = this;

        var settings = $.extend(
            {
                getHashCallback: function(hash, btn) {
                    return hash;
                },
                selectorAttribute: "href",
                backToTop: false,
                initialTab: $("li.active > a", context)
            },
            options
        );

        // Show the tab corresponding with the hash in the URL, or the first tab.
        var showTabFromHash = function() {
            var hash =
                settings.selectorAttribute == "href"
                    ? window.location.hash
                    : window.location.hash.substring(1);
            if (hash != "") {
                var selector = hash
                    ? "a[" + settings.selectorAttribute + '="' + hash + '"]'
                    : settings.initialTab;
                $(selector, context).tab("show");
                setTimeout(backToTop, 1);
            }
        };

        // We use pushState if it's available so the page won't jump, otherwise a shim.
        var changeHash = function(hash) {
            if (history && history.pushState) {
                history.pushState(
                    null,
                    null,
                    window.location.pathname +
                        window.location.search +
                        "#" +
                        hash
                );
            } else {
                scrollV = document.body.scrollTop;
                scrollH = document.body.scrollLeft;
                window.location.hash = hash;
                document.body.scrollTop = scrollV;
                document.body.scrollLeft = scrollH;
            }
        };

        var backToTop = function() {
            if (settings.backToTop === true) {
                window.scrollTo(0, 0);
            }
        };

        // Set the correct tab when the page loads
        showTabFromHash();

        // Set the correct tab when a user uses their back/forward button
        $(window).on("hashchange", showTabFromHash);

        // Change the URL when tabs are clicked
        $("a", context).on("click", function(e) {
            var hash = this.href.split("#")[1];
            if (typeof hash != "undefined" && hash != "") {
                var adjustedhash = settings.getHashCallback(hash, this);
                changeHash(adjustedhash);
                setTimeout(backToTop, 1);
            }
        });

        return this;
    };
})(jQuery);
$(".mainNavTab").stickyTabs();
$('[data-toggle="tooltip"]').tooltip();

$('#btnLockScreen').click(function () {
    // data-toggle="modal" data-target="#lockUserView"
    $('#lockscreen').fadeIn('fast');
    $("#lockUserView").modal("show");
});

$("#userSeinPIN").on("keyup", function(e) {
    if (e.keyCode === 13) {
        var pin = $("#userSeinPIN");

        if (pin.val() === "2231") {
            pin.val("");
            $("#lockUserView").modal("hide");
            $(".modal-backdrop").remove();
            $('#lockscreen').hide();
        }
    }
});

$(".datepicker").datepicker({
    format: "yyyy-mm-dd",
    language: "de-DE",
    autoclose: true,
    weekStart: 1,
    startDate: 0,
    daysOfWeekDisabled: "0",
    todayBtn: "linked",
    daysOfWeekHighlighted: "1,2,3,4,5",
    calendarWeeks: true,
    todayHighlight: true
});

$(".toast").toast({
    delay: 3000
});

$("#btnaddNewGebtype").click(function() {
    const nd = $("#btname");
    if (nd.length >= 0)
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/createAjaxBuildingType",
            data: {
                btname: $("#newBtname").val(),
                _token: $('input[name="_token"]').val()
            },
            success: function(res) {
                $("#building_types_id").append(`
               <option value="${res.id}">${res.btname}</option>
               `);
            }
        });
    // $('#addNewGebtype').toggle();
});

$(document).on("blur", ".checkLabel", function() {
    let label = $(this)
        .val()
        .toLowerCase();
    const rex = /\s|[^a-zA-Z0-9][^_]/g;
    $(this).val(label.replace(rex, "_"));
});

/*        $('#btnUpdateBuildingType').click(function () {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ route('updateBuildingType') }}",
                data: $('#frmEditBuildingTyp').serialize()
            }).done(function (jsn) {
                console.log(jsn);
                // $('#upd_btname').val(jsn[0].btname);
                // $('#upd_btbeschreibung').val(jsn[0].btbeschreibung);
            });
        });*/

/*$('#deleteAdressTypeItem').click(function () {
    if (confirm('Soll der ausgewählte Typ gelöscht werden!')){
        const nd = $('#frmEditAddressTyp #id :selected');
       $.ajax({
           type: "POST",
           dataType: 'json',
           url: "/deleteTypeAdress",
           data: {
               id:  nd.val(),
               _token: $('input[name="_token"]').val(),
               _method: $('input[name="_method"]').val()
           },
           success: function (res) {

          }
       });
    }
});*/

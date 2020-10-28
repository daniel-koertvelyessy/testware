console.log("main.js bs loaded");
/*!
 * bsCustomFileInput v1.3.4 (https://github.com/Johann-S/bs-custom-file-input)
 * Copyright 2018 - 2020 Johann-S <johann.servoire@gmail.com>
 * Licensed under MIT (https://github.com/Johann-S/bs-custom-file-input/blob/master/LICENSE)
 */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e=e||self).bsCustomFileInput=t()}(this,function(){"use strict";var s={CUSTOMFILE:'.custom-file input[type="file"]',CUSTOMFILELABEL:".custom-file-label",FORM:"form",INPUT:"input"},l=function(e){if(0<e.childNodes.length)for(var t=[].slice.call(e.childNodes),n=0;n<t.length;n++){var l=t[n];if(3!==l.nodeType)return l}return e},u=function(e){var t=e.bsCustomFileInput.defaultText,n=e.parentNode.querySelector(s.CUSTOMFILELABEL);n&&(l(n).textContent=t)},n=!!window.File,r=function(e){if(e.hasAttribute("multiple")&&n)return[].slice.call(e.files).map(function(e){return e.name}).join(", ");if(-1===e.value.indexOf("fakepath"))return e.value;var t=e.value.split("\\");return t[t.length-1]};function d(){var e=this.parentNode.querySelector(s.CUSTOMFILELABEL);if(e){var t=l(e),n=r(this);n.length?t.textContent=n:u(this)}}function v(){for(var e=[].slice.call(this.querySelectorAll(s.INPUT)).filter(function(e){return!!e.bsCustomFileInput}),t=0,n=e.length;t<n;t++)u(e[t])}var p="bsCustomFileInput",m="reset",h="change";return{init:function(e,t){void 0===e&&(e=s.CUSTOMFILE),void 0===t&&(t=s.FORM);for(var n,l,r=[].slice.call(document.querySelectorAll(e)),i=[].slice.call(document.querySelectorAll(t)),o=0,u=r.length;o<u;o++){var c=r[o];Object.defineProperty(c,p,{value:{defaultText:(n=void 0,n="",(l=c.parentNode.querySelector(s.CUSTOMFILELABEL))&&(n=l.textContent),n)},writable:!0}),d.call(c),c.addEventListener(h,d)}for(var f=0,a=i.length;f<a;f++)i[f].addEventListener(m,v),Object.defineProperty(i[f],p,{value:!0,writable:!0})},destroy:function(){for(var e=[].slice.call(document.querySelectorAll(s.FORM)).filter(function(e){return!!e.bsCustomFileInput}),t=[].slice.call(document.querySelectorAll(s.INPUT)).filter(function(e){return!!e.bsCustomFileInput}),n=0,l=t.length;n<l;n++){var r=t[n];u(r),r[p]=void 0,r.removeEventListener(h,d)}for(var i=0,o=e.length;i<o;i++)e[i].removeEventListener(m,v),e[i][p]=void 0}}});

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
bsCustomFileInput.init();
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

$('.btnShowDataStyle').click(function () {
    const src = $(this).data('src');
    const targetid = $(this).data('targetid');
    $.ajax({
        type: "get",
        dataType: 'json',
        url: src,
        success: (res) => {
            $(targetid).html(res.html);
        }
    });
});

$(document).on('blur', '.decimal',function() {
    $(this).val($(this).val().replace(/,/, "."));
});
$(document).on('keyup', '.decimal', function() {
    $(this).val($(this).val().replace(/,/, "."));
});

$('.bentBackTab').click(function () {
    $($(this).data('showtab')).removeClass('disabled').tab('show');
});
$('.bentNextTab').click(function () {
    if($(this).data('showtab')==='#nav-cicontact-tab'){
        const aci_task = $('#aci_task');
        const aci_name = $('#aci_name');
        let flag = false;
        if (aci_task.val()===''|| aci_name.val()==='') {
            (aci_task.val()==='') ? aci_task.addClass('is-invalid') : aci_task.removeClass('is-invalid');
            (aci_name.val()==='') ? aci_name.addClass('is-invalid') : aci_name.removeClass('is-invalid');
            flag = false;
        } else {
            (aci_task.val()==='') ? aci_task.addClass('is-invalid') : aci_task.removeClass('is-invalid');
            (aci_name.val()==='') ? aci_name.addClass('is-invalid') : aci_name.removeClass('is-invalid');
            flag = true;
        }

        (aci_name.val()==='') ? aci_name.addClass('is-invalid') : aci_name.removeClass('is-invalid');
        if (flag)
            $($(this).data('showtab')).removeClass('disabled').tab('show');
    } else {
        $($(this).data('showtab')).removeClass('disabled').tab('show');
    }
});

// $('.decimal').droppable({
//     drop: function(event, ui) {
//         $(this).val($(this).val().replace(/,/, "."));
//     }
// });



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

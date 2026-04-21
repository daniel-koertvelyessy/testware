import bsCustomFileInput from 'bs-custom-file-input';

window.bsCustomFileInput = bsCustomFileInput;

    /**
     * jQuery Plugin: Sticky Tabs
     *
     * @author Aidan Lister <aidan@php.net>
     * @version 1.2.0
     */
    (function ($) {
        $.fn.stickyTabs = function (options) {
            var context = this;

            var settings = $.extend(
                {
                    getHashCallback: function (hash, btn) {
                        return hash;
                    },
                    selectorAttribute: "href",
                    backToTop: false,
                    initialTab: $("li.active > a", context)
                },
                options
            );

            // Show the tab corresponding with the hash in the URL, or the first tab.
            var showTabFromHash = function () {
                var hash =
                    settings.selectorAttribute === "href"
                        ? window.location.hash
                        : window.location.hash.substring(1);
                if (hash !== "") {
                    var selector = hash
                        ? "a[" + settings.selectorAttribute + '="' + hash + '"]'
                        : settings.initialTab;
                    $(selector, context).tab("show");
                    setTimeout(backToTop, 1);
                }
            };

            // We use pushState if it's available so the page won't jump, otherwise a shim.
            var changeHash = function (hash) {
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

            var backToTop = function () {
                if (settings.backToTop === true) {
                    window.scrollTo(0, 0);
                }
            };

            // Set the correct tab when the page loads
            showTabFromHash();

            // Set the correct tab when a user uses their back/forward button
            $(window).on("hashchange", showTabFromHash);

            // Change the URL when tabs are clicked
            $("a", context).on("click", function (e) {
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

$(document).ready(function () {

    $(".mainNavTab").stickyTabs();
    $("[data-toggle=\"tooltip\"]").tooltip();
    bsCustomFileInput.init();
    $('#btnLockScreen').click(function () {
        localStorage.setItem("testware-lockscreen", "1");
        // data-toggle="modal" data-target="#lockUserView"
        $("#lockscreen").fadeIn('fast');
        $("#lockUserView").modal("show");
    });

    if (localStorage.getItem('testware-lockscreen') !== null) {
        $('#lockscreen').fadeIn('fast');
        $("#lockUserView").modal("show");
    }


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

    $("#btnaddNewGebtype").click(function () {
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
                success: function (res) {
                    $("#building_types_id").append(`
               <option value="${res.id}">${res.btname}</option>
               `);
                }
            });
        // $('#addNewGebtype').toggle();
    });

    /*$(document).on('focus','.price',function () {
        const rex = /[^0-9]/g;
        let price =  $(this).val().trim().replace(rex, "");
        $(this).val(price/100);
    });

    $(document).on('blur','.price',function () {
        const formatter = new Intl.NumberFormat('de', {
            style: 'currency',
            currency: 'EUR'
        })
        let price = $(this).val().trim();
        $(this).val(formatter.format(price));
    });*/

    $(document).on("blur", ".checkLabel", function () {
        if ($(this).val() !== '') {
            let label = $(this)
                .val()
                // .toLowerCase()
                .trim();
            const rex = /[^a-zA-Z0-9_.-]/g;
            $(this)
                .val(label.replace(rex, "_"))
                .attr('title', 'Leer- und Sonderzeichen werden in diesem Feld automatisch entfernt!')
                .tooltip('show');
        }
    });

    $('.checkLabel').on('shown.bs.tooltip', function () {
        setTimeout(function () {
            console.log('shown.bs.tooltip   FIRERD');
            $('.checkLabel').tooltip('hide')
        }, 1000)
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

    $(document).on('blur', '.decimal', function () {
        $(this).val($(this).val().replace(/,/, "."));
    });

    $(document).on('keyup', '.decimal', function () {
        $(this).val($(this).val().replace(/,/, "."));
    });

    $('.bentBackTab').click(function () {
        $($(this).data('showtab')).removeClass('disabled').tab('show');
    });
    $('.bentNextTab').click(function () {
        let flagFieldIsEmpty = false;
        if ($(this).data('required')) {
            const requires = $(this).data('required').split(',');
            for (let require in requires) {
                let field = $(requires[require]);
                if (field.val() === '') {
                    field.addClass('is-invalid');
                    flagFieldIsEmpty = true;
                } else {
                    field.removeClass('is-invalid');
                }
            }
        }
        if (!flagFieldIsEmpty)
            $($(this).data('showtab')).removeClass('disabled').tab('show');

    });

    $(document).on('blur', 'input.is-invalid', function () {
        if ($(this).val() !== '') $(this).removeClass('is-invalid');
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

    const sidebarNode = $('#sidebar');
    const switchFixSidebarNode = $('#switchFixSidebar');

    if (localStorage.getItem('testWare_sideBar_Fixed') === '1') {
        switchFixSidebarNode.prop('checked', true);
        (localStorage.getItem('testWare_sideBar_Aktive') === '1') ? sidebarNode.addClass('active') : sidebarNode.removeClass('active');
    } else {
        switchFixSidebarNode.prop('checked', false)
    }

    $('#sidebarCollapse').on('click', function () {
        if (localStorage.getItem('testWare_sideBar_Fixed') === '1') {
            if (sidebarNode.hasClass('active')) {
                localStorage.setItem('testWare_sideBar_Aktive', '0');
                sidebarNode.removeClass('active')
            } else {
                localStorage.setItem('testWare_sideBar_Aktive', '1');
                sidebarNode.addClass('active')
            }
        } else {
            sidebarNode.toggleClass('active')
        }
    });

    switchFixSidebarNode.click(function () {
        (switchFixSidebarNode.prop('checked')) ?
            localStorage.setItem('testWare_sideBar_Fixed', '1') :
            localStorage.setItem('testWare_sideBar_Fixed', '0')
    });

    $('.getNoteData').click(function () {
        const id = $(this).data('note_id');
        $.ajax({
            type: "get",
            dataType: 'json',
            url: "/note/" + id,
            success: function (res) {
                $('#note_details').html(res.html);
            }
        });
    });
    $('#btnAddNoteTag').click(function () {
        $.ajax({
            type: "post",
            dataType: 'json',
            url: "/tag",
            data: {
                label: $('#setNewTagLabel').val(),
                name: $('#setNewTagName').val(),
                color: $('#setNewTagColor').val(),
                _token: $('input[name="_token"]').val(),
            },
            success: function (res) {
                $('#taglist').append(res.html);

            }
        });
    });

    $('#btnAddTag').click(function () {
        const setTag = $('#setTag :selected');
        const color = setTag.data('color');
        const tagid = setTag.val();
        const label = setTag.data('label');
        $('#taglist').append(`
        <div class="alert alert-${color} alert-dismissible fade show" role="alert">
          ${label}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <input type="hidden" name="tag[]" id="note_tag_${tagid}" value="${tagid}">
        </div>
            `);
    });

    $(document).on('click', '.editNote', function () {
        const id = $(this).data('id');
        $.ajax({
            type: "get",
            dataType: 'json',
            url: "/note",
            data: {id},
            success: function (res) {
                $('#model_note_id').val(id);
                $('#frmStoreNoteData').attr('action', '/note/' + id);
                $('#modal_method').val('put');
                $('#note_object_uid').val(res.data.uid);
                $('#modal_addnote_user_id').val(res.data.user_id);
                $('#note_type_id').val(res.data.note_type_id);
                $('#label').val(res.data.label);
                $('#description').val(res.data.description);
                $('#file_name').val(res.data.file_name);
                $('#modalAddNoteLabel').text(res.title);
                $('#taglist').html(res.tags);
                $('#modalAddNote').modal('show');

            }
        });
    });
});
$(document).ready(function () {

    let $btnSearch = $("button#btn-search");
    let $btnClearSearch = $("button#btn-clear-search");

    let $inputSearchField = $("input[name  = search_field]");
    let $inputSearchValue = $("input[name  = search_value]");
    let $selectChangeAttr = $("select[name = select_change_attr]");
    let $inputSearchFilter = $("input[name  = search_filter]");

    $("a.select-field").click(function (e) {
        e.preventDefault();

        let field = $(this).data("field");
        let fieldName = $(this).html();
        $("button.btn-active-field").html(
            fieldName + ' <span class="caret"></span>'
        );
        $inputSearchField.val(field);
    });

    $("a.select-filter").click(function (e) {
        e.preventDefault();

        let filter = $(this).data("filter");
        let filterName = $(this).html();
        $("button.btn-active-filter").html(
            filterName + ' <span class="caret"></span>'
        );
        $inputSearchFilter.val(filter);
        // console.log($inputSearchFilter.val(filter));
    });

    $btnSearch.click(function () {
        var pathname = window.location.pathname;
        let params = ["filter_status"];
        let searchParams = new URLSearchParams(window.location.search); // ?filter_status=active

        let link = "";
        $.each(params, function (key, param) {
            // filter_status
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&"; // filter_status=active
            }
        });

        let search_field = $inputSearchField.val();
        let search_value = $inputSearchValue.val();
        let search_filter = $inputSearchFilter.val();

        // if (search_value.replace(/\s/g, "") == "") {
        //     alert("Nhập vào giá trị cần tìm !!");
        // } else {

        window.location.href =
            pathname +
            "?" +
            link +
            "search_field=" +
            search_field +
            "&search_value=" +
            search_value +
            "&search_filter=" +
            search_filter;
        // }
    });

    $btnClearSearch.click(function () {
        var pathname = window.location.pathname;
        let searchParams = new URLSearchParams(window.location.search);

        params = ["filter_status"];

        let link = "";
        $.each(params, function (key, param) {
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&";
            }
        });

        window.location.href = pathname + "?" + link.slice(0, -1);
    });

    $(".btn-delete").on("click", function () {
        if (!confirm("Bạn có chắc muốn xóa phần tử?")) return false;
    });

    $(".status-ajax").on("click", function () {
        // let url = $(this).data("url");
        // let btn = $(this);
        // let currentClass = btn.data("class");
        // $.ajax({
        //     type: "GET",
        //     url: url,
        //     dataType: "json",
        //     success: function (response) {
        //         btn.removeClass(currentClass);
        //         btn.addClass(response.statusObj.class);
        //         btn.html(response.statusObj.name);
        //         btn.data("url", response.link);
        //         btn.data("class", response.statusObj.class);
        //         btn.notify("Cập nhật thành công", {
        //             position: "top center",
        //             className: "success",
        //         });
        //     },
        // });
    });

    $(".is-home-ajax").on("click", function () {
        let url = $(this).data("url");
        let btn = $(this);
        let currentClass = btn.data("class");
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                btn.removeClass(currentClass);
                btn.addClass(response.isHomeObj.class);
                btn.html(response.isHomeObj.name);
                btn.data("url", response.link);
                btn.data("class", response.isHomeObj.class);
                btn.notify("Cập nhật thành công", {
                    position: "top center",
                    className: "success",
                });
            },
        });
    });

    $selectChangeAttr.on("change", function () {
        let ele = $(this);
        let selectValue = $(this).val();
        let url = $(this).data("url");
        url = url.replace("value_new", selectValue);
        // console.log(url);
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                ele.notify("Cập nhật thành công", {
                    position: "top center",
                    className: "success",
                });
            },
        });
    });

    window.addEventListener('alert', event => {

        let ele = $(event.target);
        ele.notify(event.detail.message, {
            position: "top center",
            className: event.detail.type,
        });
        // $('.toast-notify').click(function () {
        //     var ele = $(this);
        //     $.ajax({
        //         type: "GET",
        //         success: function (response) {
        //             ele.notify("Cập nhật thành công", {
        //                 position: "top center",
        //                 className: "success",
        //             });
        //         },
        //     });
        // });

    });

    // let tab = 0;
    // const tabs = document.getElementsByClassName('nav-item');
    // const tabsContent = document.getElementsByClassName('tab-pane');

    // for (let i = 0; i < tabs.length; i++) {
    //     if (i === tab) {
    //         tabs[i].classList.add('active');
    //         tabsContent[i].classList.add('active', 'in');
    //     } else {
    //         tabs[i].classList.remove('active');
    //         tabsContent[i].classList.remove('active', 'in');
    //     }
    //     tabs[i].addEventListener('click', () => {
    //         tab = i;
    //     });
    // }

    let myTagify = document.querySelectorAll('.my-tagify');
    myTagify.forEach(ele => {
        new Tagify(ele);
    });
    // var input = document.querySelector('input[name=hotline]');
    // var inputBcc = document.querySelector('input[name=bcc]');
    // var inputFacebook = document.querySelector('input[name=facebook]');
    // var inputYoutube = document.querySelector('input[name=youtube]');
    // new Tagify(input)
    // new Tagify(inputBcc)
    // new Tagify(inputFacebook)
    // new Tagify(inputYoutube)

    // var input = document.querySelector('input[name="facebook"]'),
    //     // init Tagify script on the above inputs
    //     tagify = new Tagify(input, {
    //         whitelist: ["https://www.facebook.com/profile.php?id=100006215655785"],
    //         maxTags: 10,
    //         dropdown: {
    //             maxItems: 20,           // <- mixumum allowed rendered suggestions
    //             classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
    //             enabled: 0,             // <- show suggestions on focus
    //             closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
    //         }
    //     })
    // var input = document.querySelector('input[name="youtube"]'),
    //     // init Tagify script on the above inputs
    //     tagify = new Tagify(input, {
    //         whitelist: ["https://www.youtube.com"],
    //         maxTags: 10,
    //         dropdown: {
    //             maxItems: 20,           // <- mixumum allowed rendered suggestions
    //             classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
    //             enabled: 0,             // <- show suggestions on focus
    //             closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
    //         }
    //     })

});

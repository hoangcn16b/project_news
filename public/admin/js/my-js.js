$(document).ready(function () {

    let $btnSearch = $("button#btn-search");
    let $btnClearSearch = $("button#btn-clear-search");
    let $btnFilterCategory = $("a.btn-filter");

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

    $("a.select-filter").click(function () {
        // e.preventDefault();

        let filter = $(this).data("filter");
        let filterName = $(this).html();
        $("button.btn-active-filter").html(
            filterName + ' <span class="caret"></span>'
        );
        $inputSearchFilter.val(filter);
        $(this).submit();
        // console.log($inputSearchFilter.val(filter));
    });

    $btnFilterCategory.click(function () {
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
    });

    let myTagify = document.querySelectorAll('.my-tagify');
    myTagify.forEach(ele => {
        new Tagify(ele);
    });

    // const money = 123456789000;
    // const config = { style: 'currency', currency: 'VND', maximumFractionDigits: 9 }
    // const formated = new Intl.NumberFormat('vi-VN', config).format(money);
    // console.log(formated);
    // const config = { style: 'currency', currency: 'VND', maximumFractionDigits: 9 }
    $('.select-select2').select2();

    $('#price').keyup(function (e) {
        // e.preventDefault();
        // let price = $(this).val();
        // // price = price.split(".");
        // price = price.replace('.', '');
        // price = price.split("");
        // let priceNumber = '';
        // let lengthPrice = price.length;
        // // console.log(price);

        // if (price) {
        //     let j = 0;
        //     let k = lengthPrice;
        //     if (lengthPrice <= 3) {
        //         for (let i = 0; i < lengthPrice; i++) {
        //             priceNumber += price[i];
        //         }
        //     }
        //     if (lengthPrice % 3 > 0) {

        //     }
        // console.log(priceNumber);

        // for (let i = 0; i < lengthPrice; i++) {
        //     k = k - 1;
        //     if (j % 3 == 0) {
        //         priceNumber = price[k] + '.' + priceNumber;
        //     } else {
        //         priceNumber = price[k] + priceNumber;
        //     }
        //     j++;
        // }
        // }
        // price = String(price);
        // while (price % 1000 > 0) {
        //     if (Math.floor(price) > 0) {
        //         priceNumber = priceNumber + Math.floor(price);
        //         priceFormat = priceNumber + '.' + Math.floor(price);
        //     }
        //     price = price - priceNumber;
        // }
        // console.log(price[0]);
        // if (price.length > 3) {
        //     let lengthP = price.length;
        //     for (let i = 0; i < lengthP; i++) {
        //         priceNumber = priceNumber + '.' + price[lengthP] + price[lengthP - 1] + price[lengthP - 2];
        //     }
        // } else {
        //     priceNumber = price;
        // }
        // console.log(priceNumber);

        // let formated = new Intl.NumberFormat('vi-VN').format(priceNumber);
        // document.getElementById('price').value = priceNumber.slice(0, -1);
    });

    Dropzone.options.dropzone =
    {
        maxFilesize: 10,
        renameFile: function (file) {
            var dt = new Date();
            var time = dt.getTime();
            return time + file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 60000,
        success: function (file, response) {
            console.log(response);
        },
        error: function (file, response) {
            return false;
        }
    };

    $("#sortable").sortable();
    $('#btn-add-image').on('click', function () {
        let imageItem = `
        <div class="mb-3 d-flex p-2 bg-warning">
            <input class="form-control col-md-3 col-sm-3 col-xs-12" type="file" name="thumb1[]" id="formFile">
            <input class=" col-md-3 col-sm-3 col-xs-12" type="text" name="alt[]">
            <button type="button" class="btn btn-danger btn-delete-image">X</button>
        </div>
        `;
        $('.image-wrapper').append(imageItem);

        $("#sortable").sortable();
    });

    $(document).on('click', '.btn-delete-image', function (e) {
        e.preventDefault();
        $(this).parent().remove();
    });

});

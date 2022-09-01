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

    $('.select-select2').select2();

    //sortable
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

    //currency
    $("input[data-type='currency']").on({
        keyup: function () {
            formatCurrency($(this));
        },
        blur: function () {
            formatCurrency($(this), "blur");
        }
    });
    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.

        // get input value
        var input_val = input.val();

        // don't validate empty input
        if (input_val === "") { return; }

        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");

        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = "" + input_val;

        // final formatting
        if (blur === "blur") {
            input_val += "";
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    $(".btn-add-image").click(function () {
        // console.log('clicked btn-add-image')
        $('#file_upload').trigger('click');
    });

    // event delegation
    $('.list-input-hidden-upload').on('change', '#file_upload', function (event) {
        let today = new Date();
        let time = today.getTime();
        let image = event.target.files[0];
        let name = $("input[name='name']").val();
        let alt = name.replace(/\s/g, '+');
        let file_name = event.target.files[0].name;
        // console.log(alt);
        let box_image = $('<div class="box-image"></div>');
        box_image.append('<img src="' + URL.createObjectURL(image) + '" class="picture-box" width="150" height="180">');
        box_image.append('<input type="text" name="altNewImg[]" value="' + alt + '" id="alt-{{ $key }}" class="images_alt">');
        box_image.append('<div class="wrap-btn-delete"><button class="btn btn-danger btn-delete-image" type="button" data-id=' + time + '><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button></div>');
        $(".list-images").append(box_image);
        $(this).removeAttr('id');
        $(this).attr('id', time);
        let input_type_file = '<input type="file" name="filenames[]" id="file_upload" class="myfrm form-control hidden">';
        $('.list-input-hidden-upload').append(input_type_file);
    });

    $(".list-images").on('click', '.btn-delete-image', function () {
        let id = $(this).data('id');
        $('#' + id).remove();
        $(this).parents('.box-image').remove();
    });

    //----------------------------------------------------------------------------------------------------------------
    $(document).on('click', '.add-attr', function (e) {
        e.preventDefault();
        let ele = $(this);
        let url = $(this).data('url-attr');
        let productId = $("input[name=id]").val();
        url = url + '?id=' + productId;
        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                $('.add-new-attr').append(response);
                ele.notify("Đã thêm mới", {
                    position: "top center",
                    className: "success",
                });
            }
        });
    });

    $(document).on('click', '.btn-del-attr-val', function (e) {
        e.preventDefault();
        let url = $(this).data('url-delete-val');
        // let attrId = $(this).data('id-delete-val');
        let attrId = $(this).siblings("input[name=id-attr-val]").val();
        let productId = $("input[name=id]").val();
        url = url + '?product_id=' + productId + '&id=' + attrId;
        $(this).parent('.one-attr-val').remove();
        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
            }
        });
    });

    $(document).on('click', '.btn-del-attr-all', function (e) {
        e.preventDefault();
        let url = $(this).data('url-delete-attr');
        let attrId = $(this).data('id-delete-attr');
        let productId = $("input[name=id]").val();
        url = url + '?product_id=' + productId + '&id=' + attrId;
        $(this).parent('.child-attr').remove();
        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
            }
        });
    });

    $(document).on('click', '.btn-add-attr-val', function (e) {
        e.preventDefault();
        let ele = $(this);
        let url = ele.data('url-add-attr-val');
        // let attrId = $(this).data('id-add-attr-val');
        let attrId = $(this).siblings("input[name=id-attr]").val();
        let productId = $("input[name=id]").val();
        url = url + '?product_id=' + productId + '&id=' + attrId;
        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                console.log(response);
                ele.parent('.child-attr-val').append(response);
            }
        });
    });

    $(document).on('change', '.attr-name', function (e) {
        e.preventDefault();
        let ele = $(this);
        let attrName = ele.val();
        let url = ele.data('url-update-name');
        let productId = $("input[name=id]").val();
        let attrId = ele.data('id-update-name');
        $.ajax({
            type: "get",
            url: url,
            data: { productId: productId, attributeName: attrName, attributeId: attrId },
            success: function (response) {
                console.log(response);
                ele.notify("Cập nhật thành công", {
                    position: "top center",
                    className: "success",
                });
            }
        });
    });

    $(document).on('change', '.attr-value', function (e) {
        e.preventDefault();
        let ele = $(this);
        let attrValue = ele.val();
        let url = ele.data('url-update-value');
        let productId = $("input[name=id]").val();
        let attrId = $(this).siblings("input[name=id-attr-val]").val();
        $.ajax({
            type: "get",
            url: url,
            data: { productId: productId, attributeValue: attrValue, attributeId: attrId },
            success: function (response) {
                ele.notify("Cập nhật thành công", {
                    position: "top center",
                    className: "success",
                });
            }
        });
    });


    //-------------------------------------------------------------------------------------

    // $(document).on('click', '.add-attr', function () {
    //     // $('.add-variant').remove();
    //     // let addNewAttr = `
    //     //     <div class="form-group" style="margin-top: 50px">
    //     //         <label for="new_attribute"
    //     //             class="control-label col-md-3 col-sm-3 col-xs-6">Name/Value</label>
    //     //         <input name="attribute_name[]" type="text" value="" style="width:100px" class="btn btn-default">
    //     //         <input name="attribute_value[]" type="text" value="" class="my-tagify btn btn-default"
    //     //             style="width:200px">
    //     //         <button class="btn btn-danger btn-del-attr" type="button"> Delete</button>
    //     //     </div>
    //     // `;
    //     // $('.add-all-attr').append(addNewAttr);
    //     let ele = $(this);
    //     $('.attr-variant').remove();
    //     let url = $(this).data('url-attr');
    //     let id = $("input[name=id]").val();
    //     let qryString = $("#this-form-add-attr").serialize();
    //     url = url + '?' + qryString;
    //     let attributeName = $("input[name='attribute_names[]']").map(function () { return $(this).val(); }).get();
    //     let attributeValue = $("input[name='attribute_values[]']").map(function () { return $(this).val(); }).get();
    //     let attributeIds = $("input[name='attribute_ids[]']").map(function () { return $(this).val(); }).get();
    //     let jsonName = JSON.stringify(attributeName);
    //     let jsonValue = JSON.stringify(attributeValue);
    //     let jsonId = JSON.stringify(attributeIds);
    //     // console.log(jsonValue);
    //     $.ajax({
    //         type: "get",
    //         url: url,
    //         data: { jsonName: jsonName, jsonValue: jsonValue, jsonId: jsonId, id: id },
    //         success: function (response) {
    //             $('.child-attr').remove();
    //             $('.add-new-attr').append(response);
    //             // let myTagify = document.querySelectorAll('.my-tagify');
    //             // new Tagify(myTagify[myTagify.length - 1])
    //             ele.notify("Thêm mới thuộc tính thành công", {
    //                 position: "top center",
    //                 className: "success",
    //             });
    //         },
    //         error: function (response) {
    //             // alert("Nhập đẩy đủ các trường");
    //         }
    //     });

    // });

    // $(document).on('change', '.attr-name', function (e) {
    //     e.preventDefault();
    //     let ele = $(this);
    //     let url = $(this).data('url-update-name');
    //     let id = $(this).siblings(".input-id-hidden").data('id');
    //     let attributeName = $(this).val();
    //     url = url + '?id=' + id + '&attribute_name=' + attributeName;
    //     $.ajax({
    //         type: "get",
    //         url: url,
    //         success: function (response) {
    //             // console.log(response);
    //             ele.notify("Cập nhật thành công", {
    //                 position: "top center",
    //                 className: "success",
    //             });
    //         }
    //     });
    // });
    // $(document).on('change', '.attr-value', function (e) {
    //     e.preventDefault();
    //     let ele = $(this);
    //     $('.attr-variant').remove();
    //     let url = $(this).data('url-update-value');
    //     let id = $(this).siblings(".input-id-hidden").data('id');
    //     let productId = $("input[name=id]").val();
    //     let attributeValue = $(this).val();
    //     // url = url + '?id=' + id;
    //     let jsonValue = JSON.stringify(attributeValue);
    //     $.ajax({
    //         type: "get",
    //         url: url,
    //         data: { id: id, jsonValue: jsonValue, productId: productId },
    //         dataType: 'json',
    //         success: function (response) {
    //             console.log(response);
    //             ele.parent().notify("Thay đổi thành công, Hãy cập nhật lại giá", {
    //                 position: "top center",
    //                 className: "success",
    //             });
    //         }
    //     });
    // });
    // $(document).on('click', '.btn-del-attr', function (e) {
    //     e.preventDefault();
    //     $(this).parent().remove();
    //     $('.attr-variant').remove();
    //     let url = $(this).data('url-delete');
    //     let id = $(this).siblings(".input-id-hidden").data('id');
    //     url = url + '?id=' + id;
    //     // console.log(url);
    //     $.ajax({
    //         type: "get",
    //         url: url,
    //         // data: { id: id },
    //         success: function (response) {
    //             // console.log(response);
    //         }
    //     });
    // });

    // // $(document).on('click', '.save-attr', function (e) {
    // //     e.preventDefault();
    // //     $('.add-variant').remove();
    // //     let url = $(this).data('url-add-attr');
    // //     let id = $("input[name=id]").val();
    // //     let attribute_name = $("input[name='attribute_name[]']").map(function () { return $(this).val(); }).get();
    // //     let attribute_value = $("input[name='attribute_value[]']").map(function () { return $(this).val(); }).get();
    // //     let jsonName = JSON.stringify(attribute_name);
    // //     let jsonValue = JSON.stringify(attribute_value);

    // //     let urlAction = $('#this-form-add-attr').attr('action');
    // //     let qryString = $("#this-form-add-attr").serialize();
    // //     url = urlAction + '?' + qryString;
    // //     $('.attr-variant').remove();
    // //     // console.log(urlAction + '?' + qryString);
    // //     $.ajax({
    // //         type: "get",
    // //         url: url,
    // //         success: function (response) {
    // //             $('.add-all-variant').append(response);
    // //         },
    // //         error: function (response) {
    // //             // alert("Nhập đẩy đủ các trường");
    // //         }
    // //     });
    // // });
    // $(document).on('click', '.make-variant', function (e) {
    //     e.preventDefault();
    //     $('.attr-variant').remove();
    //     let ele = $(this);
    //     let url = $(this).data('url-make-variant');
    //     let productId = $("input[name=id]").val();
    //     url = url + '?id=' + productId;
    //     console.log(url);
    //     $.ajax({
    //         type: "get",
    //         url: url,
    //         success: function (response) {
    //             $('.add-all-variant').append(response);
    //             ele.notify("Đã làm mới biến thể, hãy cập nhật lại giá", {
    //                 position: "top center",
    //                 className: "success",
    //             });
    //         }
    //     });
    // })

    // $(document).on('change', '.price-variant', function (e) {
    //     e.preventDefault();
    //     let ele = $(this);
    //     price = $(this).val();
    //     url = $(this).data('url-update-price');
    //     let idVariant = $(this).siblings("input[name=id_combination]").val();
    //     $.ajax({
    //         type: "get",
    //         url: url,
    //         data: { idVariant: idVariant, price: price },

    //         success: function (response) {
    //             ele.notify("Cập nhật thành công", {
    //                 position: "right center",
    //                 className: "success",
    //             });
    //         }
    //     });
    // })
});

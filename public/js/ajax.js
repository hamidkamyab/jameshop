/***********Brand Image************* */
var deleteBrandImgTag = document.getElementById("deleteBrandImg");
if (deleteBrandImgTag) {
    deleteBrandImgTag.addEventListener('click', async() => {
        var formData = new FormData()
        formData.append("_token", _token);
        formData.append("id", $('#mediafile_id').val());
        if ($('#mediafile_id').val()) {
            var response = await fetch(removeRoute, {
                method: "POST",
                body: formData
            })
            result = await response.json();
            if (result.status == 'success') {
                $('#mediafile_id').val("");
                $('#mediaFileImg').fadeOut(0);
                $('#mediaFileImg').attr('src', "")
                $('#mediafile_path').val("")
                $('.mediaFileBox > i').fadeIn(500);
                $('#deleteBrandImg').fadeOut(250)
                $('#uploadModalBtn').removeClass('disabled')
            }
        }
    });
}

/*************************/


/*************Category Attributes***************/
const AttributeModalBtnTag = document.getElementsByClassName('AttributeModalBtn');
if (AttributeModalBtnTag) {
    for (var i = 0; i < AttributeModalBtnTag.length; i++) {
        AttributeModalBtnTag[i].addEventListener('click', async(e) => {
            clearAttrTbl();
            const Id = e.target.parentNode.id;
            const formData = new FormData();
            formData.append('_token', _token)
            formData.append('id', Id)
            const response = await fetch(url, { method: "POST", body: formData })
            const res = await response.json();
            if (res['status'] == 'success') {
                var data = res['attrGroupCategory']['attributes_group'];
                document.getElementById('AttributeModalLabel').innerText = "ویژگی های دسته بندی " + res["attrGroupCategory"]["title"];
                document.getElementById('attrTbody').innerHTML = "";
                var element = "";
                data.forEach((value, key) => {
                    element += '<tr id="rowId-' + (value.id) + '">' +
                        '<td>' + value.title + '</td>' +
                        '<td class="text-center">' +
                        '<button type="submit" class="text-danger border-0 p-0 bg-transparent" title="لغو ویژگی از دسته ' + res["attrGroupCategory"]["title"] + '" onClick="deleteAttr(' + value.id + ',' + Id + ')">' +
                        '<i class="icon-trash fs-6"></i>' +
                        '</button>' +
                        '</td>' +
                        '</tr>';
                })
                document.getElementById('attrTbody').innerHTML = element;
                $("#loading").fadeOut(250);
                $("#attrTable").fadeIn(300);
            } else {
                element = '<tr><td colspan="2" class="bg-notfund text-center"> ویژگی الحاق نشده است! </td></tr>';
                document.getElementById('attrTbody').innerHTML = element;
                $("#loading").fadeOut(250);
                $("#attrTable").fadeIn(300);
            }
        });
    }
}

/****************************/

/*************deleteAttr***************/
function deleteAttr(attrId, catId) {
    Swal.fire({
        title: 'آیا مطمئن هستید؟',
        text: "اگر از لغو این ویژگی مطمئن هستید ادامه دهید!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله!',
        cancelButtonText: 'انصراف'
    }).then(async(result) => {
        if (result.isConfirmed) {
            var newURL = urlAttrDestroy.replace("attrID/catID", attrId + "/" + catId)
            const response = await fetch(newURL, { method: "GET" });
            const res = await response.json();
            if (res['status'] == 'success') {
                Swal.fire({
                    title: 'حذف شد!',
                    text: 'ویژگی مورد نظر از دسته بندی مورد نظر حذف شد.',
                    confirmButtonText: 'بستن!',
                    icon: 'success',
                })
                var targetId = '#rowId-' + attrId;
                $(targetId).fadeOut();
            }
        }
    })

}
/****************************/



/*************Get Category Attributes***************/
async function getAttrCat(event) {
    if (event.target.value != 'choose') {
        var catId = event.target.value;
        url = getAttrUrl.replace("id", catId);
        document.getElementById('categoryAttr').innerHTML = '';
        const response = await fetch(url, { method: 'GET' });
        const result = await response.json();
        if (result['status'] == 'success') {
            result['attributes'].forEach((value, key) => {
                var newSelect = document.createElement('select');
                newSelect.id = 'selectAttr-' + key;
                $(newSelect).addClass('attrSelect');
                $(newSelect).attr('onChange', 'selectAttrValue(this)');

                var option = document.createElement('option');
                option.text = 'انتخاب کنید...';
                option.disabled = true;
                option.selected = true;
                option.value = 0;
                newSelect.appendChild(option);
                value['attributes_value'].forEach(attr => {
                    var option = document.createElement('option');
                    option.value = attr['id'];
                    option.text = attr['title'];
                    newSelect.appendChild(option);
                });

                var titleTag = document.createElement('h6');
                titleTag.textContent = value['title'] + ":";

                var container = document.getElementById('categoryAttr');
                container.appendChild(titleTag);
                container.appendChild(newSelect);
                $(newSelect).select2();
            });
        }
    }

}
/****************************/


/*************Get Category Attributes***************/
async function searchProduct() {
    let loading = false;
    if (!loading) {
        loading = true;
        isLoading(loading)
        let val = $('#searchInputAMZ').val();
        $('#searchContent').fadeOut();
        const formData = new FormData();
        formData.append('_token', _token)
        formData.append('val', val)
        const response = await fetch(url, { method: "POST", body: formData })
        const data = await response.json();
        document.getElementById('searchResult').innerHTML = '';
        if (data.status == 'success') {
            let alLen = 0;
            data.products.forEach(product => {
                if (!amzList.includes(product.id)) {
                    let price = formatPrice(product.price);
                    let imgPath;
                    if (product.media.length > 0) {
                        product.media.forEach(media => {
                            if (media.file.id == product.first_pic) {
                                imgPath = media.file.path;
                            }
                        })
                    } else {
                        imgPath = deafultProductImg;
                    }
                    var tag = '<li class="resultItem p-3 d-flex align-items-center gap-5 justify-content-between"' +
                        'onClick="addToAMZ(' + product.id + ', \'' + product.title + '\',\'' + product.sku + '\')" role="button">' +
                        '<div class="d-flex align-items-center gap-2">' +
                        '<div class="imgBox border border-1 p-1 bg-white">' +
                        '<img src="' + imgPath + '">' +
                        '</div>' +
                        '<div class="d-flex flex-column">' +
                        '<span>' + product.title + '</span>' +
                        '<small class="text-muted">' + product.sku + '</small>' +
                        '</div>' +
                        '</div>' +
                        '<div class="d-flex flex-column">' +
                        '<div class="d-flex justify-content-end align-items-center gap-1">' +
                        '<span class="text-end">' + price + '</span>' +
                        '<small class="text-muted">ریال</small>' +
                        '</div>' +
                        '<div class="d-flex justify-content-end align-items-center gap-1">' +
                        '<small class="text-muted">' + product.discount_price + '%</small>' +
                        '<small class="text-muted"> :تخفیف</small>' +
                        '</div>' +
                        '</div>' +
                        '</li>';
                    document.getElementById('searchResult').innerHTML += tag;
                    let line = '<div class="hr w-75 mx-auto my-2"></div>';
                    document.getElementById('searchResult').innerHTML += line;
                    alLen++;
                }
            })
            if (alLen == 0) {
                var tag = '<li class="fs-5 text-muted text-center p-3">مـوردی یـافت نشـد!</li>';
                document.getElementById('searchResult').innerHTML = tag;
            }
        } else {
            var tag = '<li class="fs-5 text-muted text-center p-3">مـوردی یـافت نشـد!</li>';
            document.getElementById('searchResult').innerHTML = tag;
        }

        loading = false;
        isLoading(loading)
        $('#searchContent').fadeIn();
    }
}
/****************************/

async function productsBrandSearch(event, cl = true) {
    if (event.target.value != 'choose') {
        url = TB_url.replace("+id+", event.target.value);
        document.getElementById('selectProduct').innerHTML = '';
        var tag = '<option selected disabled value="choose">انتخاب کنید...</option>';
        $('#selectProduct').append(tag);
        const response = await fetch(url, { method: 'GET' });
        const result = await response.json();
        if (result.data.length > 0) {
            $('#selectProduct').attr('disabled', false);
            result.data.forEach(item => {
                var imgPath = '';
                if (item.media.length > 0) {
                    imgPath = item.media[0].file.path;
                } else {
                    imgPath = deafultProductImg;
                }

                var tag = '<option value="' + item.id + '" data-image="' + imgPath + '" data-cat="' + item.category.title + '" data-sku="' + item.sku + '">' + item.title + '</option>';

                $('#selectProduct').append(tag);
            })

            $('#selectProduct').select2({
                templateResult: formatResult, // اضافه کردن تصاویر به نتایج
                escapeMarkup: function(m) { return m; }
            });

            function formatResult(state) {
                if (!state.id) {
                    return state.text;
                }
                var imageUrl = $(state.element).attr('data-image');
                var category = $(state.element).attr('data-cat');
                if (imageUrl) {
                    return $('<div class="d-flex align-items-center gap-2"><div class="img-flag"><img src="' + imageUrl + '" /></div> ' +
                        '<div class="d-flex flex-column"><span>' + state.text + '</span><small>دسته: ' + category + '</small></div></div>');
                }
                return state.text;
            }

        }
    }
    if (cl) {
        tbList.length = 0;
        $('#tbList tbody').empty();
        $('#topBrandList').val('');
    }
}

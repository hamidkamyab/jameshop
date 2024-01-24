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
        $('#searchContent').fadeOut(0);
        const formData = new FormData();
        formData.append('_token', _token)
        formData.append('val', val)
        const response = await fetch(url, { method: "POST", body: formData })
        const data = await response.json();
        document.getElementById('searchResult').innerHTML = '';
        console.log(data);
        if (data.status == 'success') {
            data.products.forEach(product => {
                let price = formatPrice(product.price);
                let imgPath;
                product.media.forEach(media => {
                    if (media.file.id == product.first_pic) {
                        imgPath = media.file.path;
                    }
                })
                var tag = '<li class="resultItem p-3 d-flex align-items-center gap-5 justify-content-between" role="button">' +
                    '<div class="d-flex align-items-center gap-2">' +
                    '<div class="imgBox border border-1 p-1">' +
                    '<img src="' + imgPath + '">' +
                    '</div>' +
                    '<div class="d-flex flex-column">' +
                    '<span>' + product.title + '</span>' +
                    '<small class="text-muted">' + product.sku + '</small>' +
                    '</div>' +
                    '</div>' +
                    '<div class="d-flex flex-column">' +
                    '<div>' +
                    '<span class="text-end">' + price + '</span>' +
                    '<small class="text-muted">ریال</small>' +
                    '</div>' +
                    '<div>' +
                    '<small class="text-muted">' + product.discount_price + '%</small>' +
                    '<small class="text-muted"> :تخفیف</small>' +
                    '</div>' +
                    '</div>' +
                    '</li>';
                document.getElementById('searchResult').innerHTML += tag;
                let line = '<div class="hr w-75 mx-auto my-2"></div>';
                document.getElementById('searchResult').innerHTML += line;
            })
        } else {
            var tag = '<li class="fs-5 text-muted text-center p-3">مـوردی یـافت نشـد!</li>';
            document.getElementById('searchResult').innerHTML = tag;
        }

        loading = false;
        isLoading(loading)
        $('#searchContent').fadeIn(0);
    }
}
/****************************/

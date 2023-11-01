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
                        '<td>' + (key + 1) + '</td>' +
                        '<td>' + value.title + '</td>' +
                        '<td class="text-center">' +
                        '<button type="submit" class="text-danger border-0 p-0 bg-transparent" title="لغو ویژگی از دسته ' + res["attrGroupCategory"]["title"] + '" onClick="deleteAttr(' + value.id + ')">' +
                        '<i class="icon-trash fs-6"></i>' +
                        '</button>' +
                        '</td>' +
                        '</tr>';
                })
                document.getElementById('attrTbody').innerHTML = element;
                $("#loading").fadeOut(250);
                $("#attrTable").fadeIn(300);
            }
        });
    }
}

/****************************/

/*************deleteAttr***************/
async function deleteAttr(id) {
    const formData = new FormData();
    formData.append('_token', _token)
    formData.append('id', id)
    const response = await fetch(urlAttrDestroy, { method: "POST", body: formData });
    const res = await response.json();
    console.log(res);
}
/****************************/
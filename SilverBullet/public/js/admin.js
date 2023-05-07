
$(document).ready(function () {
    $('#add-another-image').click(function () {
        var container = $('#image-field');
        var index = container.children().length + 1;

        var div = $('<div>').attr({
            class: "input-group my-3",
            id: "item-field",
        });

        var button = $('<button>').attr({
            class: "btn btn-danger",
            type: "button",
            id: "btn_remove_sub_item",
        }).text('Odstrániť');

        var input = $('<input>').attr({
            type: 'text',
            name: 'image[]',
            id: 'image' + index,
            class: 'form-control',
        });

        div.append(input, button);
        container.append(div);
    });
});



$(document).ready(function () {
    $('#category_id').change(function () {
        var selectedValue = $(this).val();
        var container = $('#sub_categories');
        console.log(selectedValue);
        fetch(`/category/${selectedValue}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => {
            if (response.ok) {
                container.empty()
                response.json().then(data => {
                    const subCategories = data.subCategories;
                    /*const subCategoriesItems = data.subCategryItems; */
                    for (let i = 0; i < subCategories.length; i++) {

                        var label = $('<label>').text(subCategories[i].name).attr({
                            class: 'fs-4'
                        });
                        var br = $('<br>')
                        var div_sub_cat_items = $('<div>')
                        for (let j = 0; j < subCategories[i].subcategoriyItems.length; j++) {
                            var itemDiv = $('<div>')
                            var checkbox = $('<input>').attr({
                                id: subCategories[i].subcategoriyItems[j].id,
                                name: 'sub_cat_item[]',
                                type: 'checkbox',
                                value: subCategories[i].subcategoriyItems[j].id,

                            })

                            var SubCatItemLable = $('<label>').text(subCategories[i].subcategoriyItems[j].value).attr({
                                class: "mx-2"
                            })
                            console.log(subCategories[i].subcategoriyItems[j].id)
                            itemDiv.append(checkbox, SubCatItemLable)
                            div_sub_cat_items.append(itemDiv)
                        }
                        container.append(label, br, div_sub_cat_items, br)

                    }
                });
            } else {
                console.error('Failed to remove item');
            }
        })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});

$(document).on('click', '#btn_remove_sub_item', function () {
    $(this).closest('.input-group.m-3').remove();
});

document.addEventListener('click', function (event) {
    if (event.target.id === 'btn_remove_sub_item') {
        var image_url = event.target.closest('.input-group').querySelector('input[name="image[]"]').value;
        console.log(image_url);
        fetch(`/admin/imageDelete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                image_url: image_url,

            })
        })
            .then(data => {
                if (data.status === 'success') {
                    console.log('success');
                }
            })
            .catch(error => {
                console.log(error);
                console.error(error);
            });

        event.target.closest('.input-group').remove();
    }
   /*  $(this).closest('.input-group').remove(); */
});



$(document).on('click', '.button-addon', function () {
    var id = $(this).data('id');
    var container = $('#sub_cat_item' + id);

    var div_sub_item = $('<div>').attr({
        class: "input-group m-3",
        id: 'subcategory-field' + id,
    });

    var button_sub_item = $('<button>').attr({
        class: "btn btn-danger",
        type: "button",
        id: "btn_remove_sub_item" + id,
    }).text('Remove');

    var input = $('<input>').attr({
        type: 'text',
        name: 'sub_category_item' + id + '[]',
        id: 'sub_category_item' + id,
        class: 'form-control ',
    });

    button_sub_item.click(function () {
        div_sub_item.remove();
    });

    div_sub_item.append(input, button_sub_item);
    container.append(div_sub_item);
});


$(document).ready(function () {
    $('#add-another-subcategory').click(function () {
        var container = $('#subcategory-field');
        var index = container.children().length + 1;
        var input = $('<input>').attr({
            type: 'text',
            class: "form-control",
            name: "subcategory[]",
            id: 'subcategory',
            class: 'form-control',
            'aria-describedby': "button-addon",
        });

        var button = $('<button>').attr({
            class: "btn btn-outline-secondary",
            type: "button",
            id: "button-addon" + index,
        }).text('Pridať hodnotu');

        var div = $('<div>').attr({
            class: "input-group my-3",
            id: 'subcategory-field' + index,
        });

        var div2 = $('<div>').attr({
            class: '',
            id: 'sub_cat_item' + index,
        });

        button.click(function () {
            var container = $('#sub_cat_item' + index);
            var div_sub_item = $('<div>').attr({
                class: "input-group m-3",
                id: 'subcategory-field' + index,
            });

            var button_sub_item = $('<button>').attr({
                class: "btn btn-danger",
                type: "button",
                id: "btn_remove_sub_item" + index,
            }).text('Odstrániť');

            var input = $('<input>').attr({
                type: 'text',
                name: 'sub_category_item' + index + '[]',
                id: 'sub_category_item' + index,
                class: 'form-control ',
            });

            button_sub_item.click(function () {
                div_sub_item.remove();
            });

            div_sub_item.append(input, button_sub_item);
            container.append(div_sub_item);
        });


        div.append(input, button);
        div2.append(div);
        container.append(div2);
    });
});






$(document).ready(function () {
    $('#button-addon').click(function () {
        var container = $('#sub_category_item-field');

        var input = $('<input>').attr({
            type: 'form-control',
            name: 'sub_category_item1[]',
            id: 'sub_category_item1',
            class: 'form-control',
        });

        var div_sub_item = $('<div>').attr({
            class: "input-group m-3",
            id: 'subcategory-field',
        });

        var button_sub_item = $('<button>').attr({
            class: "btn btn-danger",
            type: "button",
            id: "btn_remove_sub_item",
        }).text('Odstrániť');



        div_sub_item.append(input, button_sub_item);

        button_sub_item.click(function () {
            div_sub_item.remove();
        });

        container.append(div_sub_item);
    });
});



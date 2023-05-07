$(document).ready(function () {
    var checkedSubCategoryItems = [];

    $("input[type=checkbox]").change(function () {
        checkedSubCategoryItems = $(
            "input[name=subCategoryItems\\[\\]]:checked"
        )
            .map(function () {
                return this.value;
            })
            .get();

        console.log(
            "Selected subcategory items: " + checkedSubCategoryItems.join(", ")
        );

        fetch("/search", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            body: JSON.stringify({
                subCategoryItems: checkedSubCategoryItems,
            }),
        })
            .then((response) => {
              console.log(response)
          })
            .then((data) => console.log(data))
            .catch((error) => console.error(error));
    });
});


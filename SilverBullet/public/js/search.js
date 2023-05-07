const filterContainer = document.getElementById("filter-container");
const itemContainer = document.getElementById("item-container");
const mainContainer = document.getElementById("main-container");

const urlParams = new URLSearchParams(window.location.search);
const search_query = urlParams.get("search_query");

const categoriesData = document.getElementById("categories-data").value;
const categories = JSON.parse(categoriesData);

const itemsData = document.getElementById("items-data").value;
const items = JSON.parse(itemsData);

let counter = 0;

categories.forEach((category) => {
    const details = document.createElement("details");
    const summary = document.createElement("summary");
    summary.innerText = category.name;
    summary.style.cssText =
        "font-size: 20px; display: flex; justify-content: space-between;";
    details.appendChild(summary);

    category.subcategories.forEach((subcategory) => {
        const subcategoryTitle = document.createElement("h5");
        subcategoryTitle.classList.add("position-center");
        subcategoryTitle.innerText = subcategory.name;

        const subcategorySection = document.createElement("section");
        subcategorySection.classList.add("subcategory");
        subcategorySection.appendChild(subcategoryTitle);

        subcategory.sub_category_items.forEach((subcategory) => {
            const checkboxDiv = document.createElement("div");
            checkboxDiv.classList.add("checkbox");
            const label = document.createElement("label");
            label.style.marginLeft = "20px";
            const input = document.createElement("input");
            input.type = "checkbox";
            input.classList.add("custom-control-input");
            input.value = subcategory.id;
            input.name = "filter[]";
            const text = document.createTextNode(subcategory.value);
            label.appendChild(input);
            label.appendChild(text);
            checkboxDiv.appendChild(label);
            subcategorySection.appendChild(checkboxDiv);
        });

        details.appendChild(subcategorySection);
    });

    if (counter > 0) {
        const hr = document.createElement("hr");
        filterContainer.appendChild(hr);
    }
    filterContainer.appendChild(details);
    counter++;
});

const updateItems = (items) => {
    itemContainer.innerHTML = "";

    if (items.length > 0) {
        items.forEach((item) => {
            const article = document.createElement("article");
            article.className =
                "card col-xs-12 col-md-6 col-lg-3 mb-3 border-0";
            const div1 = document.createElement("div");
            div1.className = "bg-gray rounded-5 pb-1 shadow";
            article.appendChild(div1);
            const div2 = document.createElement("div");
            div2.className = "image-container position-relative";
            div1.appendChild(div2);
            const imgWrapper = document.createElement("div");
            imgWrapper.style.position = "relative";
            imgWrapper.style.width = "100%";
            imgWrapper.style.paddingTop = "56.25%"; // 16:9 aspect ratio
            imgWrapper.style.overflow = "hidden";
            imgWrapper.style.backgroundColor = "#f8f9fa";
            const img = document.createElement("img");
            img.src = item.image_url;
            img.alt = item.name + " image";
            img.className = "card-img-top w-100 rounded-top-5";
            img.style.position = "absolute";
            img.style.top = "0";
            img.style.left = "0";
            img.style.width = "100%";
            img.style.height = "100%";
            img.style.objectFit = "cover";
            const linkElement = document.createElement("a");
            const href = "/item/" + item.id;
            linkElement.setAttribute("href", href);
            linkElement.classList.add("stretched-link");
            imgWrapper.appendChild(img);
            linkElement.appendChild(imgWrapper);
            div2.appendChild(linkElement);
            const div3 = document.createElement("div");
            div3.className =
                "overlay d-flex justify-content-center align-items-center position-absolute top-0 start-0 w-100 h-100 border rounded-top-5";
            div2.appendChild(div3);
            const img2 = document.createElement("img");
            img2.src = "/images/pictures/buttons/trolley-cart-white.png";
            img2.className = "w-25";
            div3.appendChild(img2);
            const div4 = document.createElement("div");
            div4.className = "card-body";
            div1.appendChild(div4);
            const h5 = document.createElement("h5");
            h5.className = "card-title";
            h5.textContent = item.name;
            div4.appendChild(h5);
            const p1 = document.createElement("p");
            p1.className = "card-text";
            p1.textContent = item.description;
            div4.appendChild(p1);
            const p2 = document.createElement("p");
            p2.className = "card-text";
            p2.textContent = item.price + "€";
            div4.appendChild(p2);
            itemContainer.appendChild(article);
        });
    } else {
        const p = document.createElement("p");
        p.textContent = `No results`;
        itemContainer.appendChild(p);
    }
};

updateItems(items);

const checkboxes = document.querySelectorAll('input[type="checkbox"]');

const onCheckboxChange = (event) => {
    const checkbox = event.target;

    console.log(checkbox.value);
    checkbox.removeEventListener("change", onCheckboxChange);

    const checkedCheckboxes = Array.from(checkboxes).filter(
        (checkbox) => checkbox.checked
    );
    const checkedValues = checkedCheckboxes.map((checkbox) => checkbox.value);
    checkboxes.forEach((checkbox) => {
        checkbox.disabled = false;
    });

    const sortValue = selectSort.value;
    fetchFilteredAndSortedItems(checkedValues, sortValue);
    checkbox.addEventListener("change", onCheckboxChange);
};

checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", onCheckboxChange);
});

const selectSort = document.getElementById("sort");
selectSort.addEventListener("change", () => {
    const checkedValues = Array.from(checkboxes)
        .filter((checkbox) => checkbox.checked)
        .map((checkbox) => checkbox.value);

    const sortValue = selectSort.value;
    console.log(sortValue);
    fetchFilteredAndSortedItems(checkedValues, sortValue);
});

function fetchFilteredAndSortedItems(checkedValues, sortValue) {
    fetch("/search", {
        method: "POST",
        body: JSON.stringify({
            checkedValues,
            sort: sortValue,
            search_query,
        }),
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            const subCategoryIds = Array.isArray(data.subCategoryIds)
                ? data.subCategoryIds
                : Object.values(data.subCategoryIds);

            console.log("sub", subCategoryIds);
            updateItems(data.items.data);

            const updatedCheckedCheckboxes = Array.from(checkboxes).filter(
                (checkbox) => checkbox.checked
            );

            const noCheckboxesChecked = updatedCheckedCheckboxes.length === 0;

            checkboxes.forEach((checkbox) => {
                if (noCheckboxesChecked) {
                    checkbox.disabled = false;
                } else if (
                    !subCategoryIds.includes(parseInt(checkbox.value)) &&
                    !checkbox.checked
                ) {
                    checkbox.disabled = true;
                }
            });
        })
        .catch((error) => {
            console.error("Error filtering items:", error);
        });
}

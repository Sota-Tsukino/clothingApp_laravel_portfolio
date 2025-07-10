export function createItemImageSwitcher() {
    const topsImgEl = document.querySelector("#tops-img");
    const bottomsImgEl = document.querySelector("#bottoms-img");
    const basePath = "/images/measurements/";

    const parkaGroup = [
        "thin-hoodie",
        "thick-hoodie",
        "thin-knitwear",
        "thick-knitwear",
        "thin-blouson",
        "thick-blouson",
    ];
    const fleeceGroup = ["thin-fleece", "thick-fleece", "jumper"];
    const tShirtGroup = [
        "thin-t-shirt",
        "thick-t-shirt",
        "thin-tunic",
        "thick-tunic",
    ];
    const shirtGroup = [
        "thin-shirt",
        "thick-shirt",
        "thin-blouse",
        "thick-blouse",
        "other",
    ];
    const jacketGroup = ["thin-jacket", "thick-jacket", "other"];
    const slacksGroup = [
        "slacks",
        "jeans",
        "jogger-pants",
        "knit-trousers",
        "chino-pants",
        "sweat-pants",
        "cropped-pants",
        "wide-pants",
        "other",
    ];
    const camisoleGroup = ["camisole", "thin-bustier", "thick-bustier"];
    const cardiganGroup = ["thin-cardigan", "thick-cardigan"];
    const coatGroup = ["thin-coat", "thick-coat"];

    function switchItemImg(categoryName, subCategoryName) {
        if (!subCategoryName) {
            if (categoryName === "tops") {
                topsImgEl.src = `${basePath}shirt-common.svg`;
            } else if (categoryName === "outer") {
                topsImgEl.src = `${basePath}jacket-common.svg`;
            } else if (categoryName === "bottoms") {
                bottomsImgEl.src = `${basePath}slacks-common.svg`;
            } else if (categoryName === "setup") {
                topsImgEl.src = `${basePath}jacket-common.svg`;
                bottomsImgEl.src = `${basePath}slacks-common.svg`;
            }
            return;
        }

        if (categoryName === "setup" && subCategoryName) {
            return;
        }

        if (categoryName === "tops" || categoryName === "outer") {
            if (subCategoryName === "down-vest") {
                topsImgEl.src = `${basePath}vest.svg`;
            } else if (parkaGroup.includes(subCategoryName)) {
                topsImgEl.src = `${basePath}parka-common.svg`;
            } else if (fleeceGroup.includes(subCategoryName)) {
                topsImgEl.src = `${basePath}fleece-common.svg`;
            } else if (tShirtGroup.includes(subCategoryName)) {
                topsImgEl.src = `${basePath}t-shirt-common.svg`;
            } else if (shirtGroup.includes(subCategoryName)) {
                topsImgEl.src = `${basePath}shirt-common.svg`;
            } else if (jacketGroup.includes(subCategoryName)) {
                topsImgEl.src = `${basePath}jacket-common.svg`;
            } else if (camisoleGroup.includes(subCategoryName)) {
                topsImgEl.src = `${basePath}camisole-common.svg`;
            } else if (cardiganGroup.includes(subCategoryName)) {
                topsImgEl.src = `${basePath}cardigan.svg`;
            } else if (coatGroup.includes(subCategoryName)) {
                topsImgEl.src = `${basePath}coat.svg`;
            } else {
                topsImgEl.src = `${basePath}${subCategoryName}.svg`;
            }
        } else if (categoryName === "bottoms") {
            if (slacksGroup.includes(subCategoryName)) {
                bottomsImgEl.src = `${basePath}slacks-common.svg`;
            } else {
                bottomsImgEl.src = `${basePath}${subCategoryName}.svg`;
            }
        }
    }

    return { switchItemImg };
}

export function getSelectedCategoryTypes(categorySelect, subCategorySelect) {
    let categoryName = null;
    let subCategoryName = null;

    const isSpan =
        categorySelect?.tagName === "SPAN" &&
        subCategorySelect?.tagName === "SPAN";
    const isSelect =
        categorySelect?.tagName === "SELECT" &&
        subCategorySelect?.tagName === "SELECT";

    if (isSpan) {
        categoryName = categorySelect.getAttribute("data-type");
        subCategoryName = subCategorySelect.getAttribute("data-type");
    } else if (isSelect) {
        const selectedCategory =
            categorySelect.options[categorySelect.selectedIndex];
        const selectedSubCategory =
            subCategorySelect.options[subCategorySelect.selectedIndex];

        categoryName = selectedCategory?.getAttribute("data-type") || null;
        subCategoryName =
            selectedSubCategory?.getAttribute("data-type") || null;
    }

    return { categoryName, subCategoryName };
}

export function toggleImgTitle(categoryName) {
    const upperTitleEl = document.querySelector("#upper-img-title");
    const translations = {
        tops: "トップス",
        setup: "トップス",
        outer: "アウター",
    };
    upperTitleEl.innerHTML = `${translations[categoryName] || ""}測定ガイド`;
}

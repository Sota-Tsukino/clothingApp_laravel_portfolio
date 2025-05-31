export function switchItemImg(categoryName, subCategoryName) {
    const topsImgEl = document.querySelector("#tops-img");
    const bottomsImgEl = document.querySelector("#bottoms-img");
    const basePath = "/images/measurements/";

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

    const parkaGroup = ["hoodie", "pull-over", "knitwear", "blouson"];
    const fleeceGroup = ["fleece", "jumper"];
    const tShirtGroup = ["t-shirt", "tunic"];
    const shirtGroup = ["shirt", "blouse", "other"];
    const jacketGroup = ["jacket", "other"];
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
    const camisoleGroup = ["camisole", "bustier"];

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

export function toggleImgTitle(categoryName) {
    const upperTitleEl = document.querySelector("#upper-img-title");
    const translations = {
        tops: "トップス",
        setup: "トップス",
        outer: "アウター",
    };
    upperTitleEl.innerHTML = `${translations[categoryName] || ""}測定ガイド`;
}

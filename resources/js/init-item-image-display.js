import { switchItemImg, toggleImgTitle } from "./itemImageSwitcher";

window.addEventListener("DOMContentLoaded", () => {
    const categorySelect = document.getElementById("categorySelect");
    const subCategorySelect = document.getElementById("sub_category_id");

    const categoryName = categorySelect?.getAttribute("data-type");
    const subCategoryName = subCategorySelect?.getAttribute("data-type");

    if (!categoryName) return; // 未選択なら何もしない

    if (
        categoryName === "tops" ||
        categoryName === "outer" ||
        categoryName === "setup"
    ) {
        toggleImgTitle(categoryName);
    }

    if (subCategoryName) {
        switchItemImg(categoryName, subCategoryName);
    } else {
        switchItemImg(categoryName, null); // null渡して中で処理させる
    }
});

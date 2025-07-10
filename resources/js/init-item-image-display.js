import {
    createItemImageSwitcher,
    getSelectedCategoryTypes,
    toggleImgTitle,
} from "./itemImageSwitcher";

window.addEventListener("DOMContentLoaded", () => {
    const categorySelect = document.getElementById("categorySelect");
    const subCategorySelect = document.getElementById("sub_category_id");

    const { categoryName, subCategoryName } = getSelectedCategoryTypes(
        categorySelect,
        subCategorySelect
    );
    const { switchItemImg } = createItemImageSwitcher(); // DOM要素をキャッシュ

    if (!categoryName) return; // 未選択なら何もしない

    if (["tops", "outer", "setup"].includes(categoryName)) {
        toggleImgTitle(categoryName);
    }

    switchItemImg(categoryName, subCategoryName || null);
});

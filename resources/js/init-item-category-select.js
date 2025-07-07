import { setupDependentSelect } from "./dependent-select.js";

function initItemCategorySelect() {
    const el = document.getElementById("init-item-category-list"); //laravelの変数を受け取る
    const categories = JSON.parse(el.dataset.categories);
    const subCategoryTranslations = JSON.parse(
        el.dataset.subcategorytranslations
    );
    const item = el.dataset.item ? JSON.parse(el.dataset.item) : null;

    setupDependentSelect({
        parentSelector: "categorySelect", //idの値で指定
        childSelector: "sub_category_id",
        parentCategories: categories,
        userSelectedChildId: item ? item.sub_category_id : null,
        childProperty: "sub_category",
        childLabelKey: "name",
        childValueKey: "id",
        defaultChildOptionText: "サブカテゴリーを選択してください",
        translations: subCategoryTranslations,
    });
}

// 初期ロード時
document.addEventListener("DOMContentLoaded", initItemCategorySelect);

// 戻るボタン等で復元されたときにも再初期化
window.addEventListener("pageshow", function (e) {
    initItemCategorySelect();
});

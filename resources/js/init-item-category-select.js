import { setupDependentSelect } from "./dependent-select.js";

const el = document.getElementById("init-item-category-list"); //laravelの変数を受け取る
const categories = JSON.parse(el.dataset.categories);
const subCategoryTranslations = JSON.parse(el.dataset.subcategorytranslations);
const item = el.dataset.item ? JSON.parse(el.dataset.item) : null;

// サブカテゴリの日本語変換（必要な場合）render時に変換してるので不要
// categories.forEach((cat) => {
//     cat.sub_category.forEach((sub) => {
//         if (sub.name in subCategoryTranslations) {
//             sub.name = subCategoryTranslations[sub.name];
//         }
//     });
// });

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

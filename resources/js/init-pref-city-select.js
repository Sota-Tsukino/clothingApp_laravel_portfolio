import { setupDependentSelect } from "./dependent-select.js";

function initPrefCitySelect() {
    const el = document.getElementById("prefecture-city-list");
    if (!el) return;

    const prefectures = JSON.parse(el.dataset.prefectures);
    const user = el.dataset.user ? JSON.parse(el.dataset.user) : null;

    setupDependentSelect({
        parentSelector: "prefecture_id",
        childSelector: "city_id",
        parentCategories: prefectures,
        userSelectedChildId: user ? user.city_id : null,
        childProperty: "city",
        childLabelKey: "name",
        childValueKey: "id",
        defaultChildOptionText: "市区町村を選択してください",
    });
}

// 初期ロード時
document.addEventListener("DOMContentLoaded", initPrefCitySelect);

// 戻るボタン等で復元されたときにも再初期化
window.addEventListener("pageshow", function (e) {
    initPrefCitySelect();
});

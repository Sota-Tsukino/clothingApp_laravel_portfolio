import { setupDependentSelect } from "./dependent-select.js";

const el = document.getElementById("prefecture-city-list");
const prefectures = JSON.parse(el.dataset.prefectures);
const user = JSON.parse(el.dataset.user);

setupDependentSelect({
    parentSelector: "prefecture_id",
    childSelector: "city_id",
    parentCategories: prefectures,
    userSelectedChildId: user.city_id,
    childProperty: "city",
    childLabelKey: "name",
    childValueKey: "id",
    defaultChildOptionText: "市区町村を選択してください",
});

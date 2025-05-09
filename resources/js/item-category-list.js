const el = document.getElementById("item-categories-list");
const categories = JSON.parse(el.dataset.categories); // [{},{},...]で渡る
const subCategoryTranslations = JSON.parse(el.dataset.subcategorytranslations);
const user = el.dataset.user ? JSON.parse(el.dataset.user) : "";

const categorySelect = document.getElementById("categorySelect");
const subCategorySelect = document.getElementById("sub_category_id");

//英語→日本語に置き換え
categories.forEach((category) => {
    category.sub_category.forEach((subCategory) => {
        if (subCategory.name in subCategoryTranslations) {
            subCategory.name = subCategoryTranslations[subCategory.name];
        }
    });
});

// 初期状態の保存（Laravelが出力した<option>を一旦削除して書き直すため）
const defaultCategoryOption = categorySelect.innerHTML;

function renderSubCategories(subCategoryId) {
    // 一度クリア
    subCategorySelect.innerHTML =
        '<option value="">サブカテゴリーを選択してください</option>';

    // 該当するカテゴリーを探す
    const selectedCategory = categories.find((p) => p.id == subCategoryId);

    if (selectedCategory && selectedCategory.sub_category) {
        selectedCategory.sub_category.forEach((subcategory) => {
            const option = document.createElement("option");
            option.value = subcategory.id;
            option.textContent = subcategory.name;

            // プロフィール編集画面で既に選択されている市区町村の場合は selected にする
            if (user.subcategory_id && user.subcategory_id == subcategory.id) {
                option.selected = true;
            }

            subCategorySelect.appendChild(option);
        });
    }
}

// 初期レンダリング（ページ読み込み時に都道府県が選択されていたら）
if (categorySelect.value) {
    renderSubCategories(categorySelect.value);
}

// 都道府県変更時に市区町村の選択肢を更新
categorySelect.addEventListener("change", function () {
    renderSubCategories(this.value);
});

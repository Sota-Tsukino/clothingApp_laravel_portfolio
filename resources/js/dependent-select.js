export function setupDependentSelect({
    parentSelector,
    childSelector,
    parentCategories,
    userSelectedChildId = null,
    childProperty = "children",
    childLabelKey = "name",
    childValueKey = "id",
    defaultChildOptionText = "選択してください",
    translations = null,
}) {
    const parentSelectEl = document.getElementById(parentSelector);
    const childSelect = document.getElementById(childSelector);

    function renderChildOptions(selectedParentId) {
        childSelect.innerHTML = `<option value="">${defaultChildOptionText}</option>`;

        const selectedParent = parentCategories.find(
            (parentCategory) => parentCategory.id == selectedParentId
        ); //dataは親カテゴリーの配列、find()はその中から条件に一致する最初の１要素を返す
        if (selectedParent && selectedParent[childProperty]) {
            selectedParent[childProperty].forEach((child) => {
                generateOptionEl(child);
            });
        }
    }

    function generateOptionEl(child) {
        //optionタグの生成 generateOptionEls
        const option = document.createElement("option");
        option.value = child[childValueKey];
        option.dataset.type = child["name"];

        let label = child[childLabelKey];

        //英語→日本語変換処理 translateLabel
        if (translations && label in translations) {
            label = translations[label];
        }

        option.textContent = label;

        if (
            userSelectedChildId &&
            userSelectedChildId == child[childValueKey]
        ) {
            option.selected = true;
        }

        childSelect.appendChild(option);
    }

    // 初期レンダリング
    if (parentSelectEl.value) {
        renderChildOptions(parentSelectEl.value);
    }

    // 親変更時に子を更新
    parentSelectEl.addEventListener("change", function () {
        renderChildOptions(this.value);
    });
}

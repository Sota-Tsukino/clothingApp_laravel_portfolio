export function setupDependentSelect({
    parentSelector,
    childSelector,
    data,
    userSelectedChildId = null,
    childProperty = "children",
    childLabelKey = "name",
    childValueKey = "id",
    defaultChildOptionText = "選択してください",
    translations = null,
}) {
    const parentSelect = document.getElementById(parentSelector);
    const childSelect = document.getElementById(childSelector);

    function renderChildOptions(parentId) {
        childSelect.innerHTML = `<option value="">${defaultChildOptionText}</option>`;

        const selectedParent = data.find((parent) => parent.id == parentId); //dataは親カテゴリーの配列、find()はその中から条件に一致する最初の１要素を返す
        if (selectedParent && selectedParent[childProperty]) {
            selectedParent[childProperty].forEach((child) => {
                //optionタグの生成
                const option = document.createElement("option");
                option.value = child[childValueKey];
                let label = child[childLabelKey];

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
            });
        }
    }

    // 初期レンダリング
    // if (parentSelect.value) {
        renderChildOptions(parentSelect.value);
    // }

    // 親変更時に子を更新
    parentSelect.addEventListener("change", function () {
        renderChildOptions(this.value);
    });
}

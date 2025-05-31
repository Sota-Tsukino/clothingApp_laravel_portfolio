import Choices from "choices.js"; // choices.jsライブラリから、デフォルトエクスポート（＝本体） を Choicesという名前で受け取る
import "choices.js/public/assets/styles/choices.min.css"; //CSSファイルをバンドルに含める

//　通常の記述
// const multiSelects = document.querySelectorAll("#colors, #tags");
// multiSelects.forEach((select) => {
//     new Choices(select, {
//         removeItemButton: true,
//         shouldSort: false,
//     });
// });

// Choices.js を使ってマルチセレクトを拡張　色
const colorSelectElement = document.querySelector("#colors");

const colorSelect = new Choices(colorSelectElement, {
    removeItemButton: true,
    searchEnabled: true,
    placeholderValue: "色を選択",
    callbackOnCreateTemplates: function (template) {
        return {
            item: (classNames, data) => {
                const hex = data.customProperties?.hex || "#ccc";
                return template(`
              <div class="${classNames.item} ${
                    data.highlighted
                        ? classNames.highlightedState
                        : classNames.itemSelectable
                } inline-block mr-2" data-item data-id="${
                    data.id
                }" data-value="${data.value}" ${
                    data.active ? 'aria-selected="true"' : ""
                } ${
                    data.disabled ? 'aria-disabled="true"' : ""
                } style="border-left: 30px solid ${hex}; padding: 4px; border-radius:5px; ">
                ${data.label}
                <button type="button" class="${
                    classNames.button
                }" data-button>✕</button>
              </div>
            `);
            },
            choice: (classNames, data) => {
                const hex = data.customProperties?.hex || "#ccc";
                return template(`
              <div class="${classNames.item} ${classNames.itemChoice} ${
                    data.disabled
                        ? classNames.itemDisabled
                        : classNames.itemSelectable
                }" data-select-text="${
                    this.config.itemSelectText
                }" data-choice ${
                    data.disabled
                        ? 'data-choice-disabled aria-disabled="true"'
                        : "data-choice-selectable"
                } data-id="${data.id}" data-value="${data.value}" ${
                    data.groupId > 0 ? 'role="treeitem"' : 'role="option"'
                } style="border-left: 30px solid ${hex}; padding-left: 6px;">
                ${data.label}
              </div>
            `);
            },
        };
    },
});

// Choices.js を使ってマルチセレクトを拡張　タグ
const tagSelect = new Choices("#tags", {
    removeItemButton: true,
    searchEnabled: true,
    placeholderValue: "タグを選択",
    callbackOnCreateTemplates: function (template) {
        return {
            // 選択されたアイテムの見た目（画面上で選ばれたタグ）
            item: (classNames, data) => {
                return template(`
          <div class="${classNames.item} ${
                    data.highlighted
                        ? classNames.highlightedState
                        : classNames.itemSelectable
                } inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2"
               data-item data-id="${data.id}" data-value="${data.value}"
               ${data.active ? 'aria-selected="true"' : ""}
               ${data.disabled ? 'aria-disabled="true"' : ""}>
            ${data.label}
            <button type="button" class="${
                classNames.button
            }" data-button>✕</button>
          </div>
        `);
            },

            // 選択肢の見た目（セレクトボックスのドロップダウン内）
            choice: (classNames, data) => {
                return template(`
          <div class="${classNames.item} ${classNames.itemChoice} ${
                    data.disabled
                        ? classNames.itemDisabled
                        : classNames.itemSelectable
                }"
            data-select-text="${this.config.itemSelectText}" data-choice
            ${
                data.disabled
                    ? 'data-choice-disabled aria-disabled="true"'
                    : "data-choice-selectable"
            }
            data-id="${data.id}" data-value="${data.value}"
            ${data.groupId > 0 ? 'role="treeitem"' : 'role="option"}'}>
            ${data.label}
          </div>
        `);
            },
        };
    },
});

// フォーム送信前にバリデーションチェック
document.querySelector("#form").addEventListener("submit", function (e) {
    const selected = colorSelect.getValue();

    if (selected.length === 0) {
        e.preventDefault();
        alert("色を1つ以上選択してください。");
    }
});

//登録画像のプレビュー
document
    .getElementById("file_name")
    .addEventListener("change", function (event) {
        const file = event.target.files[0]; //event.targetにDOM(input)が渡ってくる
        const preview = document.getElementById("preview"); //img tagを取得

        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader(); // FileReader ブラウザでファイルを読み込むAPI
            reader.onload = function (e) {
                //  onload  読み込み完了後に発火するイベント。
                preview.src = e.target.result; // 読み込んだ画像をBase64で取得して表示
                preview.style.display = "block"; // styleを書き換え
            };
            reader.readAsDataURL(file); // 画像をBase64形式で読み込み
        } else {
            preview.src = "";
            preview.style.display = "none";
        }
    });

//カテゴリーの選択に応じた、衣類サイズ入力項目の表示切替
const categorySelect = document.getElementById("categorySelect");
const subCategorySelect = document.getElementById("sub_category_id");

function toggleFields(categoryName) {
    const topItems = document.querySelectorAll(".top-item");
    const bottomItems = document.querySelectorAll(".bottom-item");

    if (categoryName === "tops" || categoryName === "outer") {
        topItems.forEach((el) => (el.style.display = ""));
        bottomItems.forEach((el) => (el.style.display = "none"));
    } else if (categoryName === "bottoms") {
        topItems.forEach((el) => (el.style.display = "none"));
        bottomItems.forEach((el) => (el.style.display = ""));
    } else {
        // どちらでもない場合（未選択）
        topItems.forEach((el) => (el.style.display = ""));
        bottomItems.forEach((el) => (el.style.display = ""));
    }
}

function toggleClothingImg(subCategoryName) {}

subCategorySelect.addEventListener("change", function () {
    const selected = subCategorySelect.options[subCategorySelect.selectedIndex];
    const subCategoryName = selected.getAttribute("data-type");
    toggleClothingImg(subCategoryName);
});

categorySelect.addEventListener("change", function () {
    const selected = categorySelect.options[categorySelect.selectedIndex];
    const categoryName = selected.getAttribute("data-type");
    toggleFields(categoryName);
});

// 初期化（画面ロード時に実行）
const initialCategoryName =
    categorySelect.options[categorySelect.selectedIndex]?.getAttribute(
        "data-type"
    );
toggleFields(initialCategoryName);

// resources/js/modal.js
import MicroModal from "micromodal";

document.addEventListener("DOMContentLoaded", () => {
    MicroModal.init({
        disableScroll: true,
        awaitOpenAnimation: true,
        awaitCloseAnimation: true,
    });
});

// 初期レンダリング時のキャンセルボタンの初期化
const target = ["main", "sub1", "sub2"];
function initCancelBtn() {
    target.forEach((target) => {
        const cancelBtn = document.getElementById(`cancel-${target}`);
        const input = document.getElementById(`input-${target}`);
        if (input && input.value) {
            cancelBtn.style.display = "inline-block";
        }
    });
}
initCancelBtn();

let currentTarget = null;

// モーダルを開いたとき、どのボタンから開かれたかを記録
document.querySelectorAll("[data-micromodal-trigger]").forEach((button) => {
    button.addEventListener("click", (event) => {
        currentTarget = button.dataset.target; // e.g. 'main', 'sub1'
    });
});

// window objectに定義しすることで、item-cardクリック時にonclick="selectItem()"でhtmlから関数を呼べるようにする
window.selectItem = function (itemId, imageUrl) {
    if (!currentTarget) return;

    // 対応するプレビュー画像とhidden inputを取得
    const previewImg = document.getElementById(`preview-${currentTarget}`);
    const input = document.getElementById(`input-${currentTarget}`);
    const cancelBtn = document.getElementById(`cancel-${currentTarget}`);

    previewImg.src = imageUrl;
    previewImg.style.display = "block";
    input.value = itemId;
    cancelBtn.style.display = "inline-block";

    // モーダルを閉じる
    MicroModal.close("modal-item-list");
};

//キャンセルボタンクリック時に衣類アイテムプレビュー画像を非表示にする
document.querySelectorAll(".cancel-button").forEach((button) => {
    button.addEventListener("click", () => {
        const target = button.dataset.target;
        const previewImg = document.getElementById(`preview-${target}`);
        const input = document.getElementById(`input-${target}`);
        const cancelBtn = document.getElementById(`cancel-${target}`);

        if (previewImg) {
            previewImg.src = "";
            previewImg.style.display = "none";
        }
        if (input) {
            input.value = "";
        }

        cancelBtn.style.display = "none";
    });
});

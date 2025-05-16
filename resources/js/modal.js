// resources/js/modal.js
import MicroModal from "micromodal";

document.addEventListener("DOMContentLoaded", () => {
    MicroModal.init({
        disableScroll: true,
        awaitOpenAnimation: true,
        awaitCloseAnimation: true,
    });
});

let currentTarget = null;

// モーダルを開いたとき、どのボタンから開かれたかを記録
document.querySelectorAll("[data-micromodal-trigger]").forEach((button) => {
    button.addEventListener("click", (event) => {
        currentTarget = button.dataset.target; // e.g. 'main', 'sub1'
    });
});

window.selectItem = function (itemId, imageUrl) {
    if (!currentTarget) return;

    // 対応するプレビュー画像とhidden inputを取得
    const previewImg = document.getElementById(`preview-${currentTarget}`);
    const input = document.getElementById(`input-${currentTarget}`);

    previewImg.src = imageUrl;
    previewImg.style.display = "block";
    input.value = itemId;

    // モーダルを閉じる
    MicroModal.close("modal-item-list");
};

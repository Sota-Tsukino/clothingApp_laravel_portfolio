//size-checker, item.create.bladeでこのJSファイルを読み込み(エントリーポイント)
import { setupSizeCheckerForm } from "./size-checker-form.js";

function initSizeChecker() {
    const el = document.getElementById("size-checker");//bladeファイルの変数を読み込む
    if (el) {
        const tolerance = JSON.parse(el.dataset.tolerance);
        const suitable = JSON.parse(el.dataset.suitable);
        setupSizeCheckerForm(document, tolerance, suitable);
    }
}

// 初期ロード時
document.addEventListener("DOMContentLoaded", initSizeChecker);

// 戻るボタン等で復元されたときにも再初期化
window.addEventListener("pageshow", function (e) {
    initSizeChecker();
});

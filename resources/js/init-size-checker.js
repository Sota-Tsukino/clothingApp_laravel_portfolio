//size-checker, item.create.bladeでこのJSファイルを読み込み(エントリーポイント)
import { setupSizeCheckerForm } from "./size-checker-form.js";

const el = document.getElementById("size-checker");//bladeファイルの変数を読み込む
if (el) {
    const tolerance = JSON.parse(el.dataset.tolerance);
    const suitable = JSON.parse(el.dataset.suitable);
    setupSizeCheckerForm(document, tolerance, suitable);
}

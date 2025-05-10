import { applyStaticSizeEvaluation } from "./size-checker-display.js";

const el = document.getElementById("item-detail");// item.show.blade.phpで変数を取得
const tolerance = JSON.parse(el.dataset.tolerance);
const suitable = JSON.parse(el.dataset.suitable);
const item = JSON.parse(el.dataset.item);

applyStaticSizeEvaluation(document, tolerance, suitable, item);

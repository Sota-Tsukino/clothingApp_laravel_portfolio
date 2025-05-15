import { evaluateSize } from "./size-checker.js";

export function applyStaticSizeEvaluation(
    container,
    tolerance,
    suitableSize,
    item
) {
    const colorClasses = ["text-green-600", "text-yellow-500", "text-red-600", "text-gray-800"];

    for (let field in tolerance) {
        const resultEl = container.querySelector(`#${field}_result`);
        if (!resultEl) continue;

        const inputVal = parseFloat(item[field]);
        if (isNaN(inputVal)) {
            resultEl.classList.remove(...colorClasses);
            resultEl.innerText = "未判定";
            continue;
        }

        const { result, class: resultClass } = evaluateSize(
            field,
            inputVal,
            suitableSize[field],
            tolerance[field]
        );

        resultEl.classList.remove(...colorClasses);
        resultEl.classList.add(resultClass);
        resultEl.innerText = result;
    }
}

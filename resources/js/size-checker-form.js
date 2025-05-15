import { evaluateSize } from "./size-checker.js";

export function setupSizeCheckerForm(container, tolerance, suitableSize) {
    const colorClasses = ["text-green-600", "text-yellow-500", "text-red-600"];

    for (let field in tolerance) {
        const inputEl = container.querySelector(`input[name="${field}"]`);
        const resultEl = container.querySelector(`#${field}_result`);
        if (!inputEl || !resultEl) continue;

        inputEl.addEventListener("input", function () {
            const inputVal = parseFloat(this.value);

            if (isNaN(inputVal)) {
                resultEl.classList.remove(...colorClasses);
                resultEl.innerText = "未判定";
                return;
            }

            const { result, class: resultClass } = evaluateSize(
                field,
                inputVal,
                suitableSize[field],
                tolerance[field]
            );

            // すべての色クラスを削除してから新しいクラスを追加
            resultEl.classList.remove(...colorClasses);
            resultEl.classList.add(resultClass);
            resultEl.innerText = result;
        });
    }
}

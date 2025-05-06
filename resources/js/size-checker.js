import './size-checker.js';

const el = document.getElementById('size-checker');
const userTolerance = JSON.parse(el.dataset.tolerance);
const suitableSize = JSON.parse(el.dataset.suitable);

const colorClasses = ["text-green-600", "text-yellow-600", "text-red-600"];

for (let field in userTolerance) {
  const inputEl = document.querySelector(`input[name="${field}"]`);

  inputEl.addEventListener("input", function() {
    const inputVal = parseFloat(this.value);
    const ideal = suitableSize[field];
    const resultEl = document.querySelector(`#${field}_result`);

    let result = "未判定";
    let resultClass = '';

    if (isNaN(inputVal)) {
      resultEl.classList.remove(...colorClasses);
      resultEl.innerText = result;
      return;
    }



    // ユーザーの許容値（min~max)を取得
    const toleranceJust = userTolerance[field]['just'];
    const toleranceSlight = userTolerance[field]['slight'];
    const toleranceShortOrLong = userTolerance[field]['long_or_short'];

    const diff = inputVal - ideal;

    if (diff >= toleranceJust.min_value && diff <= toleranceJust.max_value) {
      result = "✅ ちょうどいい";
      resultClass = "text-green-600";
    } else if (diff >= toleranceSlight.min_value && diff <= toleranceSlight.max_value) {
      result = "△ やや合わない";
      resultClass = "text-yellow-600";
    } else {
      result = "✕ 大きく合わない";
      resultClass = "text-red-600";
    }

    // すべての色クラスを削除してから新しいクラスを追加
    resultEl.classList.remove(...colorClasses);
    resultEl.classList.add(resultClass);
    resultEl.innerText = result;
  });
}

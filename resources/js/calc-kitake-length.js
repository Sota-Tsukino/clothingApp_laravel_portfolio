const heightInputEl = document.querySelector("#height");
const displayKitakeEl = document.querySelector("#display_kitake_length");
const kitakeInputEl = document.querySelector("#kitake_length");
heightInputEl.addEventListener("input", function () {
    const inputVal = parseFloat(this.value);

    if (isNaN(inputVal)) {
        kitakeInputEl.value = "";
        displayKitakeEl.innerText = "身長 × 0.42";
        return;
    }
    const kitakeVal = inputVal * 0.42;
    const roundedKitakeVal = kitakeVal.toFixed(1); // 小数第1位で四捨五入された文字列

    kitakeInputEl.value = roundedKitakeVal;
    displayKitakeEl.innerText = roundedKitakeVal;
});

// 初期レンダリング時の表示
if (heightInputEl.value && !kitakeInputEl.value) {
    const kitakeVal = heightInputEl.value * 0.42;
    const roundedKitakeVal = kitakeVal.toFixed(1);

    kitakeInputEl.value = roundedKitakeVal;
    displayKitakeEl.innerText = roundedKitakeVal;
}

const chestInputEl = document.querySelector("#chest_circumference");
const displayArmpitEl = document.querySelector(
    "#display_armpit_to_armpit_width"
);
const armpitInputEl = document.querySelector("#armpit_to_armpit_width");
chestInputEl.addEventListener("input", function () {
    const inputVal = parseFloat(this.value);

    if (isNaN(inputVal)) {
        armpitInputEl.value = "";
        displayArmpitEl.innerText = "胸囲 / 2";
        return;
    }
    const armpitVal = inputVal / 2;
    const roundedArmpitVal = armpitVal.toFixed(1);

    armpitInputEl.value = roundedArmpitVal;
    displayArmpitEl.innerText = roundedArmpitVal;
});

//初期レンダリング時の表示
if (chestInputEl.value && !armpitInputEl.value) {
    const armpitVal = chestInputEl.value / 2;
    const roundedArmpitVal = armpitVal.toFixed(1);

    displayArmpitEl.innerText = roundedArmpitVal;
    armpitInputEl.value = roundedArmpitVal;
}

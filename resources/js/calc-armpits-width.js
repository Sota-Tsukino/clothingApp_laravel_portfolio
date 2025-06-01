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

    armpitInputEl.value = armpitVal;
    displayArmpitEl.innerText = armpitVal;
});

//初期レンダリング時の表示
if(chestInputEl.value && !armpitInputEl.value) {
    displayArmpitEl.innerText = chestInputEl.value / 2;
     armpitInputEl.value = chestInputEl.value / 2;
}

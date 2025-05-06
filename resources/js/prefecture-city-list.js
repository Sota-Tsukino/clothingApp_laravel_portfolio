const el = document.getElementById("prefecture-city-list");
const prefectures = JSON.parse(el.dataset.prefectures);//data-prefecturesに定義した変数を読み込み
const user = el.dataset.user ? JSON.parse(el.dataset.user) : ""; //register.blade.phpでは使用しない

const prefectureSelect = document.getElementById("prefecture_id");
const citySelect = document.getElementById("city_id");

// 初期状態の保存（Laravelが出力した<option>を一旦削除して書き直すため）
const defaultCityOption = citySelect.innerHTML;
console.log(defaultCityOption);

function renderCities(prefectureId) {
    // 一度クリア
    citySelect.innerHTML =
        '<option value="">市区町村を選択してください</option>';

    // 該当する都道府県を探す
    const selectedPref = prefectures.find((p) => p.id == prefectureId);

    if (selectedPref && selectedPref.city) {
        selectedPref.city.forEach((city) => {
            const option = document.createElement("option");
            option.value = city.id;
            option.textContent = city.name;

            // プロフィール編集画面で既に選択されている市区町村の場合は selected にする
            if (user.city_id && user.city_id == city.id) {
                option.selected = true;
            }

            citySelect.appendChild(option);
        });
    }
}

// 初期レンダリング（ページ読み込み時に都道府県が選択されていたら）
if (prefectureSelect.value) {
    renderCities(prefectureSelect.value);
}

// 都道府県変更時に市区町村の選択肢を更新
prefectureSelect.addEventListener("change", function () {
    renderCities(this.value);
});

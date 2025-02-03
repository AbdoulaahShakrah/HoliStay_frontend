var slider = document.getElementById("price-slider");
var priceMin = document.getElementById("price-min");
var priceMax = document.getElementById("price-max");


//Para fazer o set dos inputs
let params = new URLSearchParams(window.location.search);
let minVal = params.get("propertyPrice[gte]") || 10;
let maxVal = params.get("propertyPrice[lte]") || 1000;

priceMin.value = minVal;
priceMax.value = maxVal;

noUiSlider.create(slider, {
    start: [minVal, maxVal], // Usa os valores do request
    connect: true,
    orientation: "horizontal",
    range: {
        min: 0,
        max: 1000,
    },
});

slider.noUiSlider.on("update", function (values, handle) {
    if (handle === 0) {
        priceMin.value = Math.round(values[0]);
    } else {
        priceMax.value = Math.round(values[1]);
    }
});

priceMin.addEventListener("change", function () {
    slider.noUiSlider.set([this.value, null]);
});

priceMax.addEventListener("change", function () {
    slider.noUiSlider.set([null, this.value]);
});

document.getElementById("submit_btn").addEventListener("click", function (event) {
    event.preventDefault();
    let minVal = priceMin.value;
    let maxVal = priceMax.value;

    let currentUrl = new URL(window.location.href);
    let params = new URLSearchParams(currentUrl.search);

    params.set("propertyPrice[gte]", minVal);
    params.set("propertyPrice[lte]", maxVal);

    window.location.href = currentUrl.pathname + "?" + params.toString();
});

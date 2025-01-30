document.addEventListener("DOMContentLoaded", function () {
    const image_list = document.getElementById("imageList");

    document
        .getElementById("prev-slide")
        .addEventListener("click", function () {
            image_list.scrollLeft -= 900;
        });

    document
        .getElementById("next-slide")
        .addEventListener("click", function () {
            image_list.scrollLeft += 900; // Scroll para a right
        });
});

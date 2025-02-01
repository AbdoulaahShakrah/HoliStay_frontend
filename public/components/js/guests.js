document.addEventListener("DOMContentLoaded", function () {
    const guestInput = document.getElementById("guests");
    const guestDropdown = document.getElementById("guest-dropdown");
    const counters = document.querySelectorAll(".counter");

    guestInput.addEventListener("click", (e) => {
        e.stopPropagation();
        guestDropdown.classList.toggle("show");
    });

    function updateGuestInput() {
        let adultos = parseInt(document.querySelector(".guest-option:nth-child(1) .count").textContent);
        let criancas = parseInt(document.querySelector(".guest-option:nth-child(2) .count").textContent);
        let bebes = parseInt(document.querySelector(".guest-option:nth-child(3) .count").textContent);

        let feedback = "";
        if (adultos > 0) feedback += `${adultos} adulto${adultos !== 1 ? 's' : ''}`;
        if (criancas > 0) feedback += `, ${criancas} criança${criancas !== 1 ? 's' : ''}`;
        if (bebes > 0) feedback += `, ${bebes} bebé${bebes !== 1 ? 's' : ''}`;

        guestInput.value = feedback;
    }

    counters.forEach((counter) => {
        const decrementBtn = counter.querySelector(".decrement");
        const incrementBtn = counter.querySelector(".increment");
        const countDisplay = counter.querySelector(".count");

        decrementBtn.addEventListener("click", (e) => {
            let count = parseInt(countDisplay.textContent);
            if (count > 0) {
                countDisplay.textContent = count - 1;
                updateGuestInput();
            }
        });

        incrementBtn.addEventListener("click", (e) => {
            let count = parseInt(countDisplay.textContent);
            countDisplay.textContent = count + 1;
            updateGuestInput(); 
        });
    });

    guestDropdown.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    document.addEventListener("click", () => {
        if (guestDropdown.classList.contains("show")) {
            guestDropdown.classList.remove("show");
            updateGuestInput(); 
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("search-btn").addEventListener("click", function (event) {
        event.preventDefault();

        const form = document.getElementById("searchbar-form");

        if (!form.checkValidity()) {
            alert("Por favor, preencha todos os campos obrigatórios.");
            return;
        }

        form.submit();
    });
});

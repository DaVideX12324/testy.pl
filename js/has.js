document.querySelectorAll("[data-eye]").forEach(eye => {
    eye.addEventListener("click", function() {
        const input = document.querySelector(`#${eye.dataset.target}`);
        const isPassword = input.getAttribute("type") === "password";

        // Zmiana typu pola (password/text)
        input.setAttribute("type", isPassword ? "text" : "password");

        // Zmiana klasy ikony
        if (isPassword) {
            eye.classList.remove("fa-eye");
            eye.classList.add("fa-eye-slash");
        } else {
            eye.classList.remove("fa-eye-slash");
            eye.classList.add("fa-eye");
        }
    });
});

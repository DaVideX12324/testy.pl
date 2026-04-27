$(document).ready(function () {
    var $txtPassword = $("#has");
    var $txtConfirmPassword = $("#has2");

    $txtPassword.on("change", confirmPassword);
    $txtConfirmPassword.on("keyup", confirmPassword);

    function confirmPassword() {
        $txtConfirmPassword[0].setCustomValidity(""); // Reset komunikatu
        if ($txtPassword.val() !== $txtConfirmPassword.val()) {
            $txtConfirmPassword[0].setCustomValidity("Hasła nie są zgodne.");
        }
    }
});

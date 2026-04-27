$(document).ready(function () {
    var count = 0;
    var $btn = $("#btn");
    var $a = $("#kat_stw");

    $btn.on("click", function () {
        switch (count) {
            case 0:
                $a.html("<br><br><input type='text' class='text' name='kat2'/><br><br><input type='submit' class='btn' value='Dodaj kategorię' formaction='stworz.php'/>");
                count = 1;
                break;

            default:
                $a.html("");
                count = 0;
                break;
        }
    });
});

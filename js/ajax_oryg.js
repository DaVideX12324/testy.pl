$(document).ready(function () {
    // Pobierz dane użytkownika z backendu
    $.ajax({
        url: '../dane_oryg.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                $('#main2').html('<p>' + response.error + '</p>');
                return;
            }

            if (response.role === 'Egzaminator') {
                $('#menu').html(`
                    <li class="menu"><a href="stworz.php" style="text-decoration:none" id="head_zal">Stwórz test</a></li>
                    <li class="menu"><a href="edytuj_testy.php" style="text-decoration:none" class="zwykle_a">Edytuj testy</a></li>
                    <li class="menu"><a href="testy.php" style="text-decoration:none" class="zwykle_a">Twoje testy</a></li>
                    <li class="menu"><a href="ustawienia.php" style="text-decoration:none" class="zwykle_a">Ustawienia konta</a></li>
                    <li class="menu"><a href="wylogowano.php" style="text-decoration:none" id="head_stw">Wyloguj się</a></li>
                `);

                const tests = response.tests;
                let html = `<h1>Wyniki testów: (${tests.length}):</h1>`;
                tests.forEach(test => {
                    html += `
                        <div class="testy" id="${test.id}">
                            <legend id="rej_leg">${test.name}</legend>
                            <h3>Średni wynik: ${test.average_score}%</h3>
                        </div>
                    `;
                });

                $('#main2').html(html);
            }

            if (response.role === 'Zdający') {
                $('#menu').html(`
                    <li class="menu"><a href="testy.php" style="text-decoration:none" class="zwykle_a">Twoje wyniki</a></li>
                    <li class="menu"><a href="ustawienia.php" style="text-decoration:none" class="zwykle_a">Ustawienia konta</a></li>
                    <li class="menu"><a href="wylogowano.php" style="text-decoration:none" id="head_stw">Wyloguj się</a></li>
                `);

                const results = response.results;
                let html = `<h1>Twoje wyniki:</h1>`;
                results.forEach(result => {
                    html += `
                        <div class="testy_waskie" id="${result.test_id}">
                                    <legend id="rej_leg">ID Testu: ${result.test_id}</legend>
                                    <h2>Nazwa testu: ${result.test_name}</h2>
                                    <h3>Ilość punktów: ${result.points}</h3>
                                    <h3>Ilość procent: ${result.percentage}%</h3>
                                    <h3>Zdane: ${result.passed}</h3>
                        </div>
                    `;
                });

                $('#main2').html(html);
            }
        },
        error: function () {
            $('#main2').html('<p>Wystąpił błąd podczas pobierania danych.</p>');
        }
    });
});

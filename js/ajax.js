$(document).ready(function () {
    // Automatyczne ładowanie danych użytkownika
    $.ajax({
        url: '/asdf/dane.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                console.error("Błąd z backendu:", response.error);
                $('#main2').html('<p>' + response.error + '</p>');
                return;
            }

            console.log("Otrzymane dane z backendu:", response);

            if (response.role === 'Egzaminator') {
                $('#menu').html(`
                    <li class="menu"><a href="stworz.php" style="text-decoration:none" id="head_zal">Stwórz test</a></li>
                    <!--<li class="menu"><a href="edytuj_testy.php" style="text-decoration:none" class="zwykle_a">Edytuj testy</a></li>-->
                    <li class="menu"><a href="testy.php" style="text-decoration:none" class="zwykle_a">Twoje testy</a></li>
                    <li class="menu"><a href="ustawienia.php" style="text-decoration:none" class="zwykle_a">Ustawienia konta</a></li>
                    <li class="menu"><a href="wylogowano.php" style="text-decoration:none" id="head_stw">Wyloguj się</a></li>
                `);

                // Egzaminator: Tworzenie testów i przycisków „Szczegóły”
                const tests = response.tests;
                let html = `<h1>Wyniki testów (${tests.length}):</h1>`;
                tests.forEach(test => {
                    html += `
                        <div class="testy" id="test-${test.id}">
                            <legend id="rej_leg">${test.name}</legend>
                            <h3>Średni wynik: ${test.average_score}%</h3>
                            <button class="view-results zwykle_a2" data-id="${test.id}">Szczegóły</button>
                            <div id="details-${test.id}" class="details" style="display:none;"></div>
							
							<a href="edytuj_test.php?test_id=${test.id}" class="zwykle_a5" style="text-decoration:none">Edytuj</a>
							<a href="usun_test.php?test_id=${test.id}" class="zwykle_a2" style="text-decoration:none">Usuń</a>
                        </div>
                    `;
                });
                $('#main2').html(html);
            } else if (response.role === 'Zdający') {
                $('#menu').html(`
                    <li class="menu"><a href="testy.php" style="text-decoration:none" class="zwykle_a">Twoje wyniki</a></li>
                    <li class="menu"><a href="ustawienia.php" style="text-decoration:none" class="zwykle_a">Ustawienia konta</a></li>
                    <li class="menu"><a href="wylogowano.php" style="text-decoration:none" id="head_stw">Wyloguj się</a></li>
                `);
                // Zdający: Wyświetlanie wyników użytkownika
                const results = response.results;
                let html = `<h1>Twoje wyniki:</h1>`;
                results.forEach(result => {
                    html += `
                        <div class="testy_waskie" id="result-${result.test_id}">
                            <legend id="rej_leg">ID Testu: ${result.test_id}</legend>
                            <h2>Nazwa testu: ${result.test_name}</h2>
                            <p>Ilość punktów: ${result.points}</p>
                            <p>Ilość procent: ${result.percentage}%</p>
                            <p>Zdane: ${result.passed}</p>
                        </div>
                    `;
                });
                $('#main2').html(html);
            }
        },
        error: function (xhr, status, error) {
            console.error("Błąd podczas pobierania danych AJAX:", status, error);
            $('#main2').html('<p>Wystąpił błąd podczas pobierania danych.</p>');
        }
    });

    // Obsługa szczegółów wyników dla egzaminatora
    $(document).on('click', '.view-results', function () {
        const testId = $(this).data('id');
        const detailsContainer = $(`#details-${testId}`);

        console.log("Kliknięto przycisk szczegóły dla testu ID:", testId);

        if (detailsContainer.is(':visible')) {
            console.log("Szczegóły są widoczne. Ukrywam div.");
            detailsContainer.slideUp();
        } else {
            console.log("Szczegóły są ukryte. Pobieram dane dla testu ID:", testId);

            $.ajax({
                url: '/asdf/dane.php',
                method: 'POST',
                dataType: 'json',
                data: { action: 'get_results', test_id: testId },
                success: function (response) {
                    console.log("Otrzymane szczegóły wyników:", response);

                    // Tworzenie tabeli wyników zdających dla testu
                let html = `
                    <h1>Wyniki zdających:</h1>
                    <table class="wyniki_tabela">
                        <thead>
                            <tr>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>E-mail</th>
                                <th>Punkty</th>
                                <th>Procent</th>
                                <th>Zdane</th>
                                <th>Szczegóły</th>
                            </tr>
                        </thead>
                        <tbody>`;

                response.forEach(result => {
                    html += `
                        <tr>
                            <td>${result.first_name}</td>
                            <td>${result.last_name}</td>
                            <td>${result.email}</td>
                            <td>${result.points}</td>
                            <td>${result.percentage}%</td>
                            <td>${result.passed}</td>
							<td>
                                <a href="szczegoly_wyniku.php?wynik_id=${result.id}" style="text-decoration:none" class="zwykle_a3">Zobacz szczegóły</a>
                            </td>
                        </tr>
                    `;
                });
                    html += `</tbody></table>`;

                    detailsContainer.html(html).slideDown();
                },
                error: function (xhr, status, error) {
                    console.error("Błąd AJAX dla szczegółów testu ID:", testId, status, error);
                    alert('Nie udało się pobrać szczegółowych wyników.');
                }
            });
        }
    });
});

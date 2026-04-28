# testy.pl

Webowa aplikacja do tworzenia i rozwiązywania testów wielokrotnego wyboru, napisana w PHP z bazą danych MySQL.

## Funkcjonalności

- **Rejestracja i logowanie** – system kont użytkowników z sesją
- **Tworzenie testów** – kreator testów z pytaniami i odpowiedziami wielokrotnego wyboru
- **Rozwiązywanie testów** – interaktywne rozwiązywanie z obsługą czasu
- **Punktacja i wyniki** – automatyczne obliczanie wyniku po zakończeniu testu
- **Szczegóły wyniku** – podgląd poprawnych i błędnych odpowiedzi po rozwiązaniu
- **Zarządzanie testami** – edycja, usuwanie testów, pytań i odpowiedzi
- **Panel użytkownika** – ustawienia konta, możliwość usunięcia konta

## Technologie

- **Backend:** PHP (architektura wieloplikowa, sesje, PDO/MySQL)
- **Baza danych:** MySQL (schemat dostępny w pliku `projekt (2).sql`)
- **Frontend:** HTML, CSS, JavaScript

## Struktura projektu

```
testy.pl/
├── index.php              # Strona główna / lista testów
├── login.php              # Logowanie
├── rejestracja.php        # Rejestracja
├── stworz.php             # Tworzenie nowego testu
├── stw_pyt.php            # Dodawanie pytań do testu
├── odpowiadanie.php       # Rozwiązywanie testu
├── punktacja.php          # Wynik testu
├── szczegoly_wyniku.php   # Szczegółowy podgląd wyników
├── edytuj_test.php        # Edycja testu
├── edytuj_testy.php       # Lista testów do edycji
├── usun_test.php          # Usuwanie testu
├── ustawienia.php         # Ustawienia konta
├── css/                   # Arkusze stylów
├── js/                    # Skrypty JavaScript
├── img/                   # Zasoby graficzne
└── projekt (2).sql        # Schemat bazy danych
```

## Uruchomienie lokalne

1. Sklonuj repozytorium:
   ```bash
   git clone https://github.com/DaVideX12324/testy.pl.git
   ```
2. Skopiuj pliki do katalogu serwera (np. `htdocs` w XAMPP lub `www` w WAMP)
3. Utwórz bazę danych MySQL i zaimportuj schemat:
   ```sql
   SOURCE projekt\ \(2\).sql;
   ```
4. Skonfiguruj połączenie z bazą danych w pliku `dane.php`
5. Uruchom serwer i otwórz `index.php` w przeglądarce

## Autor

[DaVideX12324](https://github.com/DaVideX12324)

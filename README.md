<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Status Kompilacji"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Całkowita Liczba Pobierań"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Najnowsza Stabilna Wersja"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="Licencja"></a>
</p>

# Projekt Kursy

## Cel Projektu

Projekt "Kursy" to aplikacja webowa stworzona w celu zarządzania kursami online. Umożliwia tworzenie, edytowanie i przeglądanie kategorii, tagów, kursów oraz zarządzanie użytkownikami z różnymi rolami (administrator, moderator, użytkownik). Głównym celem jest stworzenie platformy do organizacji i prezentacji treści edukacyjnych.

## Budowa Projektu

Aplikacja została zbudowana w oparciu o framework **Laravel**, co zapewnia solidną i skalowalną architekturę. Wykorzystuje:

-   **PHP** jako język programowania backendu.
-   **MySQL** (lub SQLite w środowisku deweloperskim) jako bazę danych.
-   **Blade** jako silnik szablonów do renderowania widoków.
-   **Tailwind CSS** do stylizacji interfejsu użytkownika, co zapewnia nowoczesny i responsywny wygląd.
-   **JavaScript** (z wykorzystaniem Alpine.js) dla interaktywności na stronie.

Struktura projektu jest zgodna ze standardami Laravel, z podziałem na kontrolery, modele, widoki, migracje baz danych itp.

## Działanie Aplikacji

Aplikacja oferuje następujące kluczowe funkcjonalności:

-   **Zarządzanie Kategoriami**: Tworzenie, edytowanie, usuwanie i przeglądanie kategorii kursów.
-   **Zarządzanie Tagami**: Tworzenie, edytowanie, usuwanie i przeglądanie tagów przypisanych do kursów.
-   **Zarządzanie Kursami**: Tworzenie, edytowanie, usuwanie i przeglądanie kursów, z możliwością przypisywania do nich kategorii i tagów. Kursy mogą zawierać tytuł, opis, cenę, status (opublikowany/nieopublikowany) oraz URL do wideo.
-   **Zarządzanie Użytkownikami**: System ról (administrator, moderator, użytkownik) z różnymi uprawnieniami dostępu do funkcji aplikacji.
-   **Autoryzacja i Autentykacja**: Standardowy system logowania i rejestracji użytkowników.

## Jak Uruchomić Projekt

Aby uruchomić projekt lokalnie, wykonaj następujące kroki:

1.  **Sklonuj repozytorium:**
    ```bash
    git clone <URL_TWOJEGO_REPOZYTORIUM>
    cd projekt-kursy
    ```

2.  **Zainstaluj zależności PHP:**
    ```bash
    composer install
    ```

3.  **Zainstaluj zależności Node.js:**
    ```bash
    npm install
    ```

4.  **Skopiuj plik `.env.example` i skonfiguruj `.env`:**
    ```bash
    cp .env.example .env
    ```
    Otwórz plik `.env` i skonfiguruj połączenie z bazą danych (np. SQLite lub MySQL). Jeśli używasz SQLite, upewnij się, że plik `database/database.sqlite` istnieje (możesz go utworzyć pustym plikiem).

5.  **Wygeneruj klucz aplikacji:**
    ```bash
    php artisan key:generate
    ```

6.  **Uruchom migracje bazy danych:**
    ```bash
    php artisan migrate
    ```
    Jeśli chcesz wypełnić bazę danych przykładowymi danymi, możesz użyć:
    ```bash
    php artisan db:seed
    ```

7.  **Skompiluj zasoby front-endowe:**
    ```bash
    npm run dev
    # lub npm run build dla wersji produkcyjnej
    ```

8.  **Uruchom serwer deweloperski Laravel:**
    ```bash
    php artisan serve
    ```

Aplikacja będzie dostępna pod adresem `http://127.0.0.1:8000` (lub innym, wskazanym przez `php artisan serve`).

## Licencja

Projekt "Kursy" jest oprogramowaniem open-source na licencji [MIT](https://opensource.org/licenses/MIT).
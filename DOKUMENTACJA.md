# Dokumentacja Projektu: Akademia Wiedzy

## 1. Wprowadzenie i Cel Projektu

**Akademia Wiedzy** to zaawansowana aplikacja internetowa do zarządzania i uczestnictwa w kursach online. Została zbudowana w oparciu o framework Laravel 12. Celem projektu było stworzenie w pełni funkcjonalnej platformy e-learningowej, która spełnia wszystkie wymogi nowoczesnych aplikacji webowych, włączając w to system ról, zarządzanie treścią oraz interaktywny interfejs użytkownika.

### Główne Technologie Użyte w Projekcie

- **Backend:** PHP 8.4, Laravel 12.x
- **Frontend:** HTML5, Tailwind CSS, Alpine.js, JavaScript (ES6+)
- **Baza Danych:** MySQL / MariaDB (zarządzana przez DBeaver), z wykorzystaniem Eloquent ORM
- **Narzędzia:** Composer, NPM, Vite, Git & GitHub

## 2. Architektura i Struktura Projektu

Aplikacja została zbudowana w oparciu o architektoniczny wzorzec projektowy **Model-View-Controller (MVC)**, co jest standardem w frameworku Laravel.

- **Model (M)**: Reprezentuje logikę danych i interakcję z bazą danych. W projekcie modele znajdują się w katalogu `app/Models` (np. `User.php`, `Course.php`). Odpowiadają one za definicję relacji, logikę biznesową związaną z danymi oraz strukturę tabel.
- **View (V)**: Odpowiada za warstwę prezentacji, czyli to, co widzi użytkownik. Widoki znajdują się w `resources/views` i są tworzone przy użyciu silnika szablonów Blade. W projekcie zastosowano reużywalne komponenty Blade (`resources/views/components`), co znacząco poprawia organizację i unikanie powtórzeń w kodzie.
- **Controller (C)**: Pełni rolę pośrednika między Modelem a Widokiem. Odbiera żądania od użytkownika (HTTP requests), przetwarza je, komunikuje się z modelami w celu operacji na danych, a na koniec przekazuje te dane do odpowiedniego widoku. Kontrolery znajdują się w `app/Http/Controllers`.

### Kluczowe Katalogi Projektu

- **`app/`**: Serce aplikacji, zawiera modele, kontrolery, middleware, dostawców usług (Providers) i całą logikę biznesową.
- **`bootstrap/`**: Zawiera plik `app.php`, który jest nowym centrum konfiguracji Laravela 12, odpowiedzialnym m.in. za rejestrację middleware.
- **`config/`**: Pliki konfiguracyjne aplikacji (baza danych, sesja, autentykacja).
- **`database/`**: Migracje (schematy tabel), seeder'y (wypełnianie bazy danymi) oraz factories.
- **`public/`**: Jedyny publicznie dostępny katalog, punkt wejściowy aplikacji (`index.php`) oraz skompilowane zasoby (CSS, JS).
- **`resources/`**: Nieskompilowane zasoby front-endowe: widoki Blade, surowe pliki CSS i JavaScript, oraz pliki językowe (`lang`).
- **`routes/`**: Definicje wszystkich tras (adresów URL) aplikacji. `web.php` dla tras webowych, `auth.php` dla autentykacji.
- **`storage/`**: Pliki generowane przez framework, takie jak logi, cache, sesje, czy pliki wgrywane przez użytkowników.

## 3. Baza Danych i Modele Eloquent

Schemat bazy danych składa się z 7 głównych tabel, które realizują logikę platformy.

### Opis Tabel i Relacji

- **`users`**: Przechowuje dane użytkowników. Posiada dodatkową kolumnę `role` (`admin`, `moderator`, `user`) oraz `deleted_at` do obsługi Soft Deletes.
- **`courses`**: Główna tabela z kursami. Posiada klucz obcy `category_id`.
- **`categories`**: Kategorie kursów.
- **`tags`**: Tagi, którymi można opisywać kursy.
- **`course_tag`** (tabela pivot): Realizuje relację **wiele-do-wielu** między kursami a tagami.
- **`course_user`** (tabela pivot): Realizuje relację **wiele-do-wielu** między kursami a użytkownikami (zapisy na kurs).
- **`password_reset_tokens`**: Przechowuje tokeny do resetowania hasła.

### Opis Modeli

- **`User.php`**:
  - Używa `trait` `SoftDeletes` do "miękkiego usuwania".
  - Definiuje relację `enrollments()`: `belongsToMany(Course::class)`, która pozwala na pobranie wszystkich kursów, na które zapisany jest użytkownik.
- **`Course.php`**:
  - `category()`: Relacja `belongsTo(Category::class)`. Każdy kurs należy do jednej kategorii.
  - `tags()`: Relacja `belongsToMany(Tag::class)`. Kurs może mieć wiele tagów.
  - `participants()`: Relacja `belongsToMany(User::class)`. Kurs może mieć wielu uczestników.
- **`Category.php`** i **`Tag.php`**: Proste modele z zdefiniowanymi polami `fillable`.

## 4. System Trasowania (Routing)

Plik `routes/web.php` został zorganizowany w oparciu o grupy middleware, aby precyzyjnie kontrolować dostęp do poszczególnych zasobów.

- **Trasy publiczne**: Dostępne dla każdego (strona główna).
- **Trasy `auth`**: Dostępne tylko dla zalogowanych użytkowników (np. dashboard, profil).
- **Grupa `moderator`**: Dostępna dla ról `moderator` i `admin`. Obejmuje pełne zarządzanie kursami, kategoriami i tagami (`Route::resource`).
- **Grupa `admin`**: Dostępna wyłącznie dla roli `admin`. Obejmuje zarządzanie użytkownikami.

Wykorzystanie `Route::resource` automatyzuje tworzenie tras CRUD, co jest zgodne z najlepszymi praktykami Laravela.

## 5. Kluczowe Funkcjonalności - Backend

### 5.1. System Ról i Uprawnień

To jedna z najbardziej zaawansowanych funkcji projektu. Została zrealizowana przy użyciu **niestandardowego Middleware**.

- **`IsAdmin.php`** i **`IsModerator.php`**: Dwa pliki middleware w `app/Http/Middleware`. Sprawdzają one rolę zalogowanego użytkownika. Jeśli rola się nie zgadza, dostęp jest blokowany i zwracany jest błąd 403 (Forbidden). `IsModerator` przepuszcza również adminów.
- **Rejestracja Middleware**: Skróty `admin` i `moderator` zostały zarejestrowane w `bootstrap/app.php` w metodzie `withMiddleware()`, co jest nowym standardem w Laravelu 12.

### 5.2. Kontrolery i Logika Biznesowa

- **`DashboardController`**: Jego kluczową funkcją jest personalizacja. Sprawdza rolę zalogowanego użytkownika i na tej podstawie przygotowuje inny zestaw danych (np. statystyki globalne dla admina, a listę "moich kursów" i "propozycje" dla zwykłego usera).
- **`CourseController`**: Zawiera logikę zapisu (`enroll`) i wypisu (`unenroll`) z kursu, używając metod `syncWithoutDetaching` i `detach` na relacji `belongsToMany`.
- **`UserController`**: Posiada pełną logikę CRUD, włączając w to "miękkie usuwanie" za pomocą metody `delete()` na modelu używającym `SoftDeletes`.

### 5.3. Walidacja Danych

Każda operacja zapisu (`store`) i aktualizacji (`update`) w kontrolerach jest poprzedzona walidacją przy użyciu metody `$request->validate()`. Zastosowano szeroki wachlarz reguł, m.in.:
- `required`, `string`, `min`, `max`: Podstawowe reguły.
- `unique:table,column,except,id`: Zapewnia unikalność danych.
- `exists:table,column`: Gwarantuje integralność relacji.
- `url`, `date`, `after_or_equal:today`: Specyficzne reguły dla typów danych.
- `not_regex`: Zapobiega używaniu niechcianych znaków.

## 6. Interfejs Użytkownika - Frontend

### 6.1. System Widoków i Komponentów Blade

Interfejs został zbudowany w oparciu o reużywalne komponenty Blade, co pozwoliło na zachowanie spójności i unikanie powtórzeń kodu.
- **Layouty**: `app.blade.php` (dla zalogowanych) i `guest.blade.php` (dla gości) definiują główną strukturę HTML.
- **Komponenty**: Stworzono wiele małych komponentów (np. `x-input-label`, `x-primary-button`) oraz bardziej złożone.

### 6.2. Niestandardowe Komponenty Modali

Zamiast standardowych alertów `confirm()` JavaScriptu, stworzono dwa niestandardowe, w pełni reużywalne komponenty modalne:
- **`<x-confirm-deletion-modal>`**: Używany do potwierdzania operacji usuwania.
- **`<x-success-modal>`**: Używany do wyświetlania wiadomości o sukcesie zapisu na kurs.

### 6.3. Interaktywność z Alpine.js

Modale są obsługiwane przez lekki framework JavaScript, **Alpine.js**.
- **`x-data`**: Inicjalizuje stan komponentu (np. `show: false`).
- **`x-on:click`**: Reaguje na kliknięcie przycisku.
- **`$dispatch('open-modal', { ... })`**: Wysyła niestandardowe zdarzenie w przeglądarce, przekazując dane (nazwę modala, tytuł, akcję).
- **`x-on:open-modal.window`**: Komponent modala "nasłuchuje" na to globalne zdarzenie i na jego podstawie aktualizuje swój stan (np. staje się widoczny i pobiera tytuł).

### 6.4. Efekty Specjalne (Confetti.js)

Po pomyślnym zapisie na kurs, użytkownik jest nagradzany animacją konfetti.
- Zostało to zrealizowane za pomocą biblioteki **`canvas-confetti`**, zainstalowanej przez `npm`.
- W `resources/js/app.js` biblioteka jest importowana i przypisywana do obiektu `window`, aby była globalnie dostępna.
- W widoku `courses/show.blade.php`, skrypt `x-init` jest uruchamiany, gdy w sesji pojawi się klucz `enrollment_success`, i wywołuje on funkcję `confetti()`.

### 6.5. Kompilacja Zasobów z Vite

Wszystkie zasoby frontendowe (CSS, JS) są zarządzane i kompilowane przez **Vite**, co zapewnia błyskawiczne przeładowywanie w trybie deweloperskim i optymalizację w trybie produkcyjnym. Konfiguracja znajduje się w `vite.config.js`.

## 7. Tłumaczenia (Localization)

Aplikacja została częściowo spolszczona.
- W `config/app.php` ustawiono `locale` na `pl`.
- Komunikaty walidacji zostały przetłumaczone w pliku `resources/lang/pl/validation.php`.
- Zastosowano również sekcję `attributes`, aby nazwy pól w komunikatach były bardziej przyjazne dla użytkownika (np. "Pole nazwa jest wymagane" zamiast "Pole name jest wymagane").

## 8. Potencjalne Pytania na Prezentacji

1.  **Pytanie:** *Dlaczego do kontroli dostępu użyłeś Middleware, a nie Gates lub Policies?*
    **Odpowiedź:** Middleware idealnie nadaje się do ochrony całych grup tras w oparciu o prosty warunek, jakim jest rola użytkownika. Jest to bardzo wydajne i czytelne rozwiązanie dla tego typu logiki. Gates i Policies byłyby lepszym wyborem, gdyby uprawnienia były bardziej złożone, np. zależały od stanu obiektu (czy użytkownik może edytować *ten konkretny* kurs, którego jest autorem).

2.  **Pytanie:** *Jak działa mechanizm "Soft Deletes"?*
    **Odpowiedź:** Po dodaniu `trait` `SoftDeletes` do modelu i kolumny `deleted_at` do tabeli, wywołanie metody `delete()` na obiekcie nie usuwa rekordu z bazy. Zamiast tego, w kolumnie `deleted_at` ustawiany jest aktualny znacznik czasu. Eloquent automatycznie modyfikuje wszystkie zapytania `SELECT`, dodając warunek `WHERE deleted_at IS NULL`, dzięki czemu "usunięte" rekordy są niewidoczne w aplikacji, ale wciąż istnieją w bazie.

3.  **Pytanie:** *W jaki sposób przekazywane są dane do komponentu modala, skoro jest on w innym pliku?*
    **Odpowiedź:** Wykorzystałem system zdarzeń w Alpine.js. Przycisk "Usuń" za pomocą `$dispatch` wysyła niestandardowe zdarzenie (`event`) do globalnego obiektu `window`. Komponent modala "nasłuchuje" na to zdarzenie za pomocą dyrektywy `x-on:open-modal.window`. Kiedy zdarzenie zostanie przechwycone, modal odczytuje przekazane w nim dane (tytuł, akcję) i aktualizuje swój wewnętrzny stan, stając się widocznym.

4.  **Pytanie:** *Jakie było największe wyzwanie w tym projekcie?*
    **Odpowiedź:** (Tutaj możesz opowiedzieć o czymś, co sprawiło Ci trudność, np. o konfiguracji ról, o problemach z zależnościami Composer/NPM, czy o wdrożeniu dynamicznych komponentów z Alpine.js).

## 9. Podsumowanie i Możliwe Rozszerzenia

Projekt "Akademia Wiedzy" jest w pełni funkcjonalną, nowoczesną aplikacją webową, która spełnia wszystkie założone wymagania. Zaimplementowane funkcje, takie jak system ról, dynamiczny interfejs i zaawansowana walidacja, świadczą o głębokim zrozumieniu frameworka Laravel i nowoczesnych technologii webowych.

Możliwe kierunki dalszego rozwoju:
- **Testy Jednostkowe i Funkcjonalne**: Napisanie testów w Pest/PHPUnit, aby zautomatyzować sprawdzanie poprawności działania aplikacji.
- **System Powiadomień**: Wysyłanie e-maili do użytkowników po zapisaniu się na kurs.
- **System Ukończenia Kursów**: Dodanie mechanizmu oznaczania lekcji/kursów jako ukończone.
- **Wdrożenie Laravel Policies**: Refaktoryzacja uprawnień, aby były jeszcze bardziej granularne.

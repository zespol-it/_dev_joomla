# Nowe funkcjonalności na istniejącym serwisie Joomla

Jak dokładać funkcje do działającej witryny **bez psucia przyszłych upgrade’ów**. Dotyczy serwisów na Joomla 4/5/6 — docelowo pracuj na J6 (patrz [UPGRADE_V4_TO_V6.md](UPGRADE_V4_TO_V6.md)).

## Matryca decyzji

| Potrzeba | Mechanizm | Gdzie |
|----------|-----------|--------|
| Zmiana HTML wyjścia core/extension | Template override | Child template → folder `html/` |
| Inny styl / kolory / CSS | Child template + `user.css` | Nie edytuj Cassiopeia bezpośrednio |
| Reakcja na event (zapis artykułu, prepare content…) | Plugin | `plugins/{grupa}/...` |
| Blok w pozycji szablonu | Moduł | `modules/mod_...` |
| Własny CRUD / panel admin / pozycja menu | Komponent | `components/com_...` + admin |
| Wspólne CSS/JS dla kilku rozszerzeń | Media + ewentualnie package | `/media/...` + `joomla.asset.json` |
| Funkcja bez kodu | Custom Fields, Workflow, Smart Search, Permissions | Core Joomla |

Oficjalnie o child templates: [guide.joomla.org – Child Templates](https://guide.joomla.org/user-manual/templates/templates-child-templates).

## Proces krok po kroku

### 1. Staging i backup

- Kopia serwisu (subdomena / lokalnie).
- Backup (np. Akeeba Backup lub backup hostingu) + **test restore**.
- Nie zaczynaj od produkcji.

### 2. Wybierz warstwę

Użyj matrycy powyżej. Przykłady:

- „Zmień układ pojedynczego artykułu” → override `com_content` w child template.
- „Po publikacji artykułu wyślij webhook” → plugin `content` lub `system`.
- „Pokaż 5 ostatnich pozycji z własnej tabeli w sidebarze” → komponent + moduł.
- „Cały panel zarządzania produktami” → komponent (admin + site).

### 3. Child template (wygląd)

1. **System → Templates → Site Templates** → utwórz child z Cassiopeia (lub używanego parenta).
2. Overrides twórz w child (Create Overrides), nie w parentcie.
3. CSS: `user.css` w child.
4. Style child przypisz do pozycji menu / domyślnego stylu.

Parent aktualizuje się przy update CMS; child zostaje.

### 4. Własne rozszerzenie

Start:

- Czysty szkielet: `skeletons/com_hello`, `mod_hello`, `plg_system_hello`.
- Gotowy mini-stack: `examples/com_items` + `mod_items` + `plg_content_items`.

Zasady:

- Własny namespace (w tym repo: `Dev\...`).
- Manifest `method="upgrade"`.
- DI + `services/provider.php`.
- Bez edycji plików core.

Szczegóły praktyk: [PROFESJONALNY_DEVELOPMENT.md](PROFESJONALNY_DEVELOPMENT.md).

### 5. Instalacja na staging

1. Spakuj folder rozszerzenia do ZIP (manifest XML w katalogu głównym ZIP-a) **albo** Install from Folder.
2. **System → Install → Extensions**.
3. Kolejność dla przykładów: najpierw `com_items`, potem `mod_items`, potem `plg_content_items`.
4. Włącz plugin / opublikuj moduł / dodaj pozycję menu komponentu.
5. Ustaw ACL (Permissions) jeśli potrzeba.

### 6. Testy

- Front i administrator.
- Użytkownik z ograniczonymi uprawnieniami.
- SEF / Rewrite włączone.
- Wielojęzyczność (jeśli serwis ML).
- **Global Configuration → Debug System = Yes** — złap deprecations i wyjątki.
- Formularze: token CSRF, walidacja.

### 7. Aktualizacje CMS a Twoje zmiany

Po każdym update Joomla / szablonu parent:

- Sprawdź listę zaktualizowanych plików / diff względem swoich overrides.
- Nie polegaj na stałe na pluginach **Backward Compatibility** — aktualizuj własne rozszerzenia do API J6.
- Trzymaj kod rozszerzeń w VCS (git), nie tylko na serwerze.

### 8. Wdrożenie na produkcję

1. Backup produkcji + test restore.
2. Okno serwisowe (jeśli duża zmiana).
3. Instalacja **tej samej** wersji paczki co na staging.
4. Smoke test: strona główna, login, kluczowa ścieżka biznesowa, admin.
5. Monitoring logów / Debug wyłączony.

## Anty-wzorce

| Nie rób | Zamiast tego |
|---------|----------------|
| Edycja `components/com_content`, `libraries/`, Cassiopeia bez child | Child + override / własne rozszerzenie |
| Logika biznesowa w pliku `tmpl` override | Plugin / model komponentu |
| Ręczne SQL „na produkcji” poza migracją | Pliki SQL w manifeście rozszerzenia |
| Trzymanie BC plugin jako „rozwiązanie na zawsze” | Refaktor do aktualnego API |
| Deploy bez staging | Staging → prod |
| Hardcode tekstów PL w PHP | Pliki `.ini` języków |

## Szybki scenariusz przykładowy

Cel: na istniejącym serwisie dodać listę własnych „Items” + box na stronie głównej + dopisek pod artykułami.

1. Staging + backup.
2. Zainstaluj `examples/com_items`.
3. W adminie dodaj kilka pozycji.
4. Menu → nowa pozycja typu Items (lista).
5. Zainstaluj `mod_items`, opublikuj w pozycji szablonu, ustaw limit.
6. Zainstaluj i włącz `plg_content_items`.
7. Test front/admin → wdrożenie na prod.

## Powiązane dokumenty

- [JOOMLA_4_VS_6.md](JOOMLA_4_VS_6.md)
- [UPGRADE_V4_TO_V6.md](UPGRADE_V4_TO_V6.md)
- [PROFESJONALNY_DEVELOPMENT.md](PROFESJONALNY_DEVELOPMENT.md)
- [README.md](README.md) — instalacja paczek z tego repo

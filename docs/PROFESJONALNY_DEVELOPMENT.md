# Profesjonalny development w Joomla

Mapa oficjalnych narzędzi i praktyk. Źródło organizacji: [github.com/orgs/joomla/repositories](https://github.com/orgs/joomla/repositories).

## Kluczowe repozytoria

| Repo | Rola |
|------|------|
| [joomla-cms](https://github.com/joomla/joomla-cms) | Referencyjna implementacja core — MVC, DI, eventy, SQL updates |
| [Manual](https://github.com/joomla/Manual) → [manual.joomla.org](https://manual.joomla.org/) | Dokumentacja programisty (extensions, DI, migrations) |
| [manual-examples](https://github.com/joomla/manual-examples) | Kod z tutoriali Manuala — kopiuj strukturę |
| [coding-standards](https://github.com/joomla/coding-standards) | PHPCS; od J4.2: **PSR-12 / PER** |
| [schemas](https://github.com/joomla/schemas) | Schematy manifestów XML |
| [rfc](https://github.com/joomla/rfc) | RFC i specyfikacje nowych API |
| [updates](https://github.com/joomla/updates) / [update.joomla.org](https://github.com/joomla/update.joomla.org) | Kanały aktualizacji core (TUF / update XML) |
| [core-translations](https://github.com/joomla/core-translations) | Wzorzec plików językowych / Crowdin |

Uzupełniająco: [Development Best Practices](https://docs.joomla.org/Development_Best_Practices), [Coding Standards Manual](https://developer.joomla.org/coding-standards/php-code.html).

## Zasady

### 1. Nigdy nie edytuj core

Zmiany wyglądu → **child template** + overrides w `html/`.  
Logika → **własny** komponent / moduł / plugin.  
Edycja `libraries/`, `components/com_content`, Cassiopeia bez child = utrata zmian przy update.

### 2. Architektura J4+/J6

- Namespace PSR-4 w manifeście (`<namespace path="src">...</namespace>`).
- Bootstrap przez `services/provider.php` i DI Container.
- Eventy: `SubscriberInterface` + typed events (nie legacy `JPlugin` jako domyślny styl nowych projektów).
- Entry point dyspozytora (Dispatcher), nie „goły” plik PHP z logiką biznesową.

### 3. MVC + Form + Table

Wzorce bierz z analogicznego rozszerzenia w `joomla-cms` (np. proste listy w adminie).  
SQL: Query Builder / Framework DB, prepared statements.  
Formularze: XML Form API Joomla.

### 4. Media i assety

- Pliki CSS/JS/obrazy w `/media/...` (nie tylko w folderze komponentu).
- Ładowanie przez **Web Asset Manager** i `joomla.asset.json`.
- Dzięki temu szablon może nadpisać assety bez ruszania Twojego kodu.

### 5. Języki

- Zawsze `en-GB` + docelowy język (tu: `pl-PL`).
- Klucze: `COM_*`, `MOD_*`, `PLG_*`.
- Zero hardcodu tekstów UI w PHP/tmpl.

### 6. Bezpieczeństwo

- ACL (`Access` / permissions w manifeście i w kodzie).
- Tokeny CSRF w formularzach admin/site.
- Escaping wyjścia (`htmlspecialchars`, `Text::_` tylko do tłumaczeń).
- Walidacja inputu; nigdy slepe `$_GET`/`$_POST`.

### 7. Jakość

- PHP **8.3+** (target J6).
- PHPCS ze standardów Joomla / PSR-12.
- Unikaj API oznaczonych deprecated (Manual → migrations).
- Test na staging z **Debug System = On**.

### 8. Workflow wdrożeń

```
feature branch → staging → backup → instalacja paczki → smoke test → produkcja
```

- Manifest: `method="upgrade"`.
- Zmiany schematu DB: wersjonowane pliki SQL w manifeście.
- Po update CMS: sprawdź overrides / Updated Files.

### 9. Gdzie szukać wzorca (kolejność)

1. Analogiczny typ w **joomla-cms**.
2. **manual-examples** + tutorial w Manualu.
3. Szkielety w tym repo: `skeletons/`, `examples/`.
4. Dopiero wtedy własna architektura.

## Decyzja: gdzie wrzucić kod

```
Nowa potrzeba
 ├─ Zmiana wyglądu?          → Child template + override html / user.css
 ├─ Hook do istniejącego?    → Plugin
 ├─ Blok w pozycji szablonu? → Moduł
 ├─ Pełny CRUD / admin?      → Komponent
 └─ Tylko CSS/JS?            → media + WebAsset / child user.css
```

Szczegóły procesu na żywym serwisie: [NOWE_FUNKCJONALNOSCI.md](NOWE_FUNKCJONALNOSCI.md).

## Checklist przed merge / release rozszerzenia

- [ ] Działa bez pluginu Backward Compatibility
- [ ] `services/provider.php` + namespace
- [ ] Języki en-GB + pl-PL
- [ ] Media przez Web Asset Manager (jeśli są assety)
- [ ] ACL + CSRF
- [ ] Install / upgrade / uninstall przetestowane
- [ ] PHP 8.3, brak deprecated warnings przy Debug ON

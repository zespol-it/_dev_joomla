# Joomla 6 — dokumentacja i rozszerzenia (dev_joomla)

Repozytorium pomocnicze: dokumentacja po polsku oraz instalowalne szkielety i przykłady pod **Joomla 6** (DI, `services/provider.php`, namespace PSR-4).

Nie zawiera pełnego CMS — instaluj rozszerzenia na osobnej instalacji Joomla 6.

## Dokumentacja

| Plik | Temat |
|------|--------|
| [JOOMLA_4_VS_6.md](JOOMLA_4_VS_6.md) | Różnice Joomla 4 vs 6 (wymagania, API, BC) |
| [UPGRADE_V4_TO_V6.md](UPGRADE_V4_TO_V6.md) | Upgrade 4 → 5.4 → 6 (checklisty) |
| [PROFESJONALNY_DEVELOPMENT.md](PROFESJONALNY_DEVELOPMENT.md) | Profesjonalny development + mapa repo [org/joomla](https://github.com/orgs/joomla/repositories) |
| [NOWE_FUNKCJONALNOSCI.md](NOWE_FUNKCJONALNOSCI.md) | Jak dokładać funkcje na istniejącym serwisie |

## Struktura

```
docs/           ← ten katalog
skeletons/      ← czyste szablony rozszerzeń
  com_hello/
  mod_hello/
  plg_system_hello/
examples/       ← działające przykłady (CRUD + moduł + plugin)
  com_items/
  mod_items/
  plg_content_items/
```

Vendor namespace: `Dev\...`.

## Instalacja rozszerzeń

Na Joomla 6 (admin):

1. **System → Install → Extensions**
2. **Install from Folder** — podaj ścieżkę do katalogu z plikiem manifestu XML  
   **albo** spakuj katalog rozszerzenia do ZIP (XML w katalogu głównym archiwum) i wgraj plik.

### Szkielety (`skeletons/`)

| Folder | Manifest | Typ |
|--------|----------|-----|
| `skeletons/com_hello` | `hello.xml` | komponent |
| `skeletons/mod_hello` | `mod_hello.xml` | moduł site |
| `skeletons/plg_system_hello` | `hello.xml` | plugin system |

Po instalacji pluginu: **System → Plugins** → włącz *System - Hello*.

### Przykłady (`examples/`) — kolejność

1. **`examples/com_items`** (`items.xml`) — tabela `#__items`, admin lista/edycja, front lista + szczegóły.
2. **`examples/mod_items`** (`mod_items.xml`) — lista pozycji z `com_items` (parametr limitu).
3. **`examples/plg_content_items`** (`items.xml`) — `onContentPrepare`: stopka z liczbą Items pod artykułem.

Następnie:

- Menu → nowa pozycja typu **Items list** / **Single item**.
- Moduły → opublikuj *Items list* w pozycji szablonu.
- Pluginy → włącz *Content - Items*.

## ZIP (opcjonalnie)

```bash
cd skeletons/com_hello && zip -r ../../com_hello.zip .
cd ../mod_hello && zip -r ../../mod_hello.zip .
cd ../plg_system_hello && zip -r ../../plg_system_hello.zip .

cd ../../examples/com_items && zip -r ../../com_items.zip .
cd ../mod_items && zip -r ../../mod_items.zip .
cd ../plg_content_items && zip -r ../../plg_content_items.zip .
```

## Oficjalne źródła

- [manual.joomla.org](https://manual.joomla.org/) / [joomla/Manual](https://github.com/joomla/Manual)
- [joomla/manual-examples](https://github.com/joomla/manual-examples)
- [joomla/joomla-cms](https://github.com/joomla/joomla-cms)
- [Upgrade 5.4 → 6](https://docs.joomla.org/Joomla_5.4.x_to_6.x_Planning_and_Upgrade_Step_by_Step/en)

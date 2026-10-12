# Joomla 4 vs Joomla 6 — różnice

Dokument skupia się na tym, co ma znaczenie przy upgrade’ie i przy pisaniu rozszerzeń. Joomla 5 jest pomostem między 4 a 6 — bezpośredni skok 4→6 nie istnieje.

Oficjalne źródła:

- [Joomla 6.0 announcement](https://www.joomla.org/announcements/release-news/joomla-6-0-and-joomla-5-4-are-here.html)
- [Removed / Backward Incompatibility (5.4→6)](https://manual.joomla.org/updates/54-60/removed-backward-incompatibility/)
- [Compatibility plugins](https://manual.joomla.org/updates/54-60/compat-plugin/)
- [Technical requirements](https://manual.joomla.org/docs/get-started/technical-requirements/)

## Porównanie

| Obszar | Joomla 4 | Joomla 6 |
|--------|----------|----------|
| Wsparcie | EOL (październik 2025) | aktywna major |
| PHP | od 7.2.5 (typowe produkcje: 8.x) | **min. 8.3** (zalecane 8.4) |
| MySQL | niższe minima | **8.0.13+** (zalecane 8.4) |
| MariaDB | niższe minima | **~10.6+** (zalecane nowsze) |
| PostgreSQL | niższe minima | **14.0+** (zalecane) |
| Aktualizacje core | ręczne | TUF + **automatyczne** aktualizacje core |
| Szablon front | Cassiopeia | Cassiopeia (+ child templates) |
| Edytor | TinyMCE 5 | TinyMCE 8.0.1 |
| Media Manager | miniatury głównie obrazów | miniatury dla wielu typów plików |
| Cache języków | brak / ograniczone | language file caching |
| BC plugin | przy przejściu na 5: `Behaviour - Backward Compatibility` | `Behaviour - Backward Compatibility 6` |
| API Input | `\Joomla\CMS\Input` (legacy) | `\Joomla\Input` (Framework); CMS Input tylko przez BC 6 |
| Filesystem | `\Joomla\CMS\Filesystem` | `\Joomla\Filesystem`; CMS FS przeniesione do BC 6 |
| CMSObject | szerokie użycie w core | usunięty z core (docelowo całkowicie w J7) |
| Rozszerzenia | klasyczny / częściowo DI | **DI + `services/provider.php`** jako standard |

## Ścieżka życia wersji

```
Joomla 4.x → 4.4.x → 5.x → 5.4.x → 6.x
```

- **4.4 → 5.x** — upgrade (nie pełna migracja jak 3→4), z pluginem BC dla kodu J4.
- **5.4 → 6.x** — upgrade; plugin BC (bez numeru) musi być **wyłączony**, plugin **BC 6** włączony.
- Szczegóły kroków: [UPGRADE_V4_TO_V6.md](UPGRADE_V4_TO_V6.md).

## Pluginy kompatybilności wstecznej

| Plugin | Skąd | Rola |
|--------|------|------|
| `Behaviour - Backward Compatibility` | J4.4 / J5 | Warstwa dla kodu J4 w J5 |
| `Behaviour - Backward Compatibility 6` | J5.4 / J6 | Warstwa dla kodu J5 w J6 |

Na nowej instalacji J6 plugin BC 6 jest **zainstalowany, ale wyłączony**. Przy upgrade z 5.4 jest włączony, żeby nie zablokować update’u rozszerzeń zależnych od starego API.

Cel projektu: z czasem wyłączyć BC i przejść na czyste API J6 (BC 6 ma żyć przez cykl J6; w J7 warstwa J5 nie będzie utrzymywana).

## Zmiany API istotne dla developerów

Najważniejsze usunięcia / przeniesienia do BC 6 (lista pełna w Manualu):

1. **`\Joomla\CMS\Input`** → używaj `\Joomla\Input\Input`.
2. **`\Joomla\CMS\Filesystem`** → `\Joomla\Filesystem`; zamiast `File::exists()` / `Folder::exists()` używaj `is_file()` / `is_dir()`.
3. **CMSObject / JObject** — usunięte z core; nie polegaj na dynamicznych właściwościach w stylu JObject.
4. **Legacy aliases klas** — ładują się przez plugin BC; nowe rozszerzenia powinny używać namespace’ów Framework/CMS bez aliasów `J*`.

## Rozszerzenia: J4 vs J6

| Temat | J4 (starzej) | J6 (standard) |
|-------|--------------|---------------|
| Bootstrap | często `mod_*.php` / legacy entry | `services/provider.php` + Dispatcher |
| Namespace | opcjonalny / mieszany | wymagany PSR-4 w manifeście |
| Eventy | `onEventName` w klasie Plugin | `SubscriberInterface` + typed events |
| Media | częste hardcode ścieżek | Web Asset Manager + `joomla.asset.json` |
| PHP | 7.x/8.0 patterns | typed props, PHP 8.3+ |

Szkielety i przykłady w tym repo (`skeletons/`, `examples/`) są napisane pod model J6.

## Co J6 dodaje „dla użytkownika”

- Automatyczne, podpisane aktualizacje core.
- Lepsze versioning treści (w tym custom fields).
- Nowe typy pól (m.in. Date / Datetime, Note, Number).
- Poprawki wydajności, dostępności i czyszczenie zależności.
- TinyMCE 8, usprawnienia Media Managera i cache’owania języków.

## Podsumowanie dla decyzji projektowych

- Serwis na J4 bez wsparcia = ryzyko bezpieczeństwa → planuj przejście przez **5.4** na **6**.
- Nowe rozszerzenia pisz od razu pod J6 (DI, Framework Input/Filesystem, bez legacy).
- Nie buduj nowych funkcji zależnych od włączonego pluginu BC — traktuj BC jako most tymczasowy.

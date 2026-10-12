# Upgrade Joomla 4 → Joomla 6

Nie ma bezpośredniego update’u 4→6. Ścieżka oficjalna:

```
Joomla 4.x → 4.4.x → 5.x → 5.4.x → 6.x
```

Źródła:

- [Joomla 4.4.x to 5.x Planning and Upgrade](https://docs.joomla.org/Joomla_4.4.x_to_5.x_Planning_and_Upgrade_Step_by_Step/en)
- [Joomla 5.4.x to 6.x Planning and Upgrade](https://docs.joomla.org/Joomla_5.4.x_to_6.x_Planning_and_Upgrade_Step_by_Step/en)
- [Compatibility plugins](https://manual.joomla.org/updates/54-60/compat-plugin/)

## Wymagania serwera (cel: J6)

| Software | Minimum (J6) | Zalecane |
|----------|--------------|----------|
| PHP | 8.3.0 | 8.4 |
| MySQL | 8.0.13 | 8.4 |
| MariaDB | ~10.6 | nowsze |
| PostgreSQL | 14.0 | nowsze |
| Apache / Nginx | 2.4 / 1.26+ | aktualne |

Moduły PHP: `json`, `simplexml`, `dom`, `zlib`, `gd`, oraz `mysqlnd` / `pdo_mysql` / `pdo_pgsql`. Zalecane: `mbstring`, memory limit ≥ 256 MB.

Sprawdź: **System → System Information**.

## Zasada ogólna

1. Pracuj najpierw na **kopii / staging**.
2. Rób **backup** i **przetestuj restore**.
3. Aktualizuj rozszerzenia **przed** skokiem major.
4. Włącz **Debug System** na czas upgrade’u.
5. Pre-update check to podpowiedź — źródłem prawdy jest test rozszerzeń + strona developera / JED.

---

## Etap 0 — przygotowanie na J4

1. Zaktualizuj Joomla do **4.4.x** (kanał Default).
2. Zaktualizuj wszystkie rozszerzenia i szablony do wersji deklarujących wsparcie J5.
3. Sprawdź PHP/DB pod wymagania J5 (minimum PHP 8.1 dla J5).
4. Pełny backup + test restore na staging.

---

## Etap A — Joomla 4.4 → 5.x

### Planning (skrót)

- Odinstaluj stare **Search** (`com_search`) i powiązane moduły — nie idą do J5.
- Jeśli używasz Google reCAPTCHA (stare) → przejdź na Invisible reCAPTCHA / wspierane rozwiązanie.
- Sprawdź kompatybilność rozszerzeń (strona developera, JED, trial na kopii).
- Szablon: Cassiopeia zwykle przechodzi; custom szablony przetestuj osobno.

### Kroki

1. Backup (ponownie).
2. Zaktualizuj rozszerzenia.
3. Wyłącz / odinstaluj rozszerzenia niekompatybilne z J5.
4. Debug System = **Yes**.
5. Backup + test restore.
6. **System → Update → Joomla → Options**.
7. Update Channel = **Joomla Next** → Save & Close.
8. Przejrzyj pre-update check (Required / Recommended / Extensions).
9. Acknowledge warnings → **Update**.
10. Po sukcesie: test front + admin.
11. Plugin **Behaviour - Backward Compatibility** zostanie włączony automatycznie — zostaw na razie.
12. Debug możesz na chwilę wyłączyć; Smart Search — sprawdź/przebuduj indeks jeśli trzeba.

Następnie aktualizuj J5 kolejnymi wersjami aż do **5.4.x** (kanał Default / Next zgodnie z polityką hostingu).

---

## Stabilizacja na Joomla 5.4

Cel przed skokiem na J6:

1. Serwis na **5.4.x**.
2. Wszystkie rozszerzenia działają **bez** pluginu `Behaviour - Backward Compatibility` (tego **bez numeru**).
3. Plugin **Behaviour - Backward Compatibility 6** jest **włączony** (w 5.4 jest instalowany i włączany przy update — to most na J6).

### Jak bezpiecznie wyłączyć BC (bez numeru)

1. Najpierw na staging.
2. Wyłącz plugin BC (bez numeru).
3. Jeśli site/admin pada — włącz z powrotem (UI lub baza `#__extensions`) i napraw rozszerzenie jeszcze na J5.4.
4. Dopiero gdy wszystko działa bez BC (bez numeru), możesz iść na J6.

Oba pluginy BC (bez numeru + „6”) **nie mogą** być jednocześnie wymagane w złym stanie przy update do J6: BC (bez numeru) **musi być wyłączony**, BC 6 **włączony**.

---

## Etap B — Joomla 5.4 → 6.x

### Planning (skrót)

Trzy sposoby weryfikacji rozszerzeń:

1. Strona developera / badge J6 na JED.
2. Kopia J5.4 → upgrade trial z Debug ON — wyłączaj rozszerzenia rzucające błędy.
3. Czysta instalacja J6 + BC 6 + instalacja Twoich rozszerzeń jedno po drugim.

Cassiopeia pozostaje szablonem frontu J6. `com_weblinks` (jeśli używany) — wersja 5.4.0+ działa bez BC 6.

### Kroki

1. Ukończ Planning + trial run na staging.
2. Backup produkcyjnej / stagingowej kopii.
3. Zaktualizuj rozszerzenia.
4. Wyłącz lub odinstaluj niekompatybilne z J6.
5. Debug System = **Yes**.
6. Backup + test restore.
7. **System → Update → Joomla → Options**.
8. Update Channel = **Joomla Next** → Save & Close.
9. Upewnij się: **BC (bez numeru) = wyłączony**, **BC 6 = włączony**.
10. Acknowledge warnings → potwierdź backup → **Update**.
11. Po sukcesie: w prawym górnym rogu powinno być Joomla 6.
12. Test front + admin.
13. Debug = **No**.
14. **System → Maintenance → Database** — Update Structure, jeśli coś zgłasza.
15. Smart Search — przebuduj przy potrzebie.

---

## Awaria / rollback

| Objaw | Działanie |
|-------|-----------|
| Admin niedostępny po disable BC | W `#__extensions` ustaw `enabled=1` dla odpowiedniego pluginu BC |
| Błąd konkretnego rozszerzenia | `enabled=0` dla tego rozszerzenia w `#__extensions`, potem napraw / odinstaluj |
| Upgrade niekompletny / chaos | Przywróć przetestowany backup |
| Problemy schematu DB | System → Database → Update Structure |

Nazwa pluginu BC 6 w bazie: `plg_behaviour_compat6`.

---

## Checklist skrócona

### Przed 4→5

- [ ] Joomla 4.4.x
- [ ] PHP/DB spełniają J5
- [ ] Backup + restore OK
- [ ] `com_search` usunięte
- [ ] Rozszerzenia J5-ready

### Przed 5.4→6

- [ ] Joomla 5.4.x
- [ ] PHP ≥ 8.3, DB wg J6
- [ ] Trial upgrade na staging OK
- [ ] BC (bez numeru) **OFF** i site działa
- [ ] BC 6 **ON**
- [ ] Backup + restore OK

### Po J6

- [ ] Front / admin OK
- [ ] Debug OFF
- [ ] Database structure OK
- [ ] Plan wyłączenia BC 6 po aktualizacji rozszerzeń do czystego API J6

---

## Powiązane dokumenty w tym repo

- [JOOMLA_4_VS_6.md](JOOMLA_4_VS_6.md) — różnice funkcjonalne i API
- [PROFESJONALNY_DEVELOPMENT.md](PROFESJONALNY_DEVELOPMENT.md) — jak pisać rozszerzenia bez legacy
- [NOWE_FUNKCJONALNOSCI.md](NOWE_FUNKCJONALNOSCI.md) — dokladanie funkcji po upgrade

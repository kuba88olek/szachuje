# language: pl

@pc
Potrzeba biznesowa: Strona informacyjna agencji kreatywnej Szachuje przystosowana do przeglądania w rozdzielczości 960x800px lub wyższej
  W celu poznania profilu firmy Szachuje oraz zakresu jej działań
  Jako użytkownik szukający informacji na temat firmy
  Chciałbym móc przeglądnąć stronę firmy na ekranie o rozdzielczości co namniej 960x800px

  Scenariusz: Widoczność nagłówka strony
    Zakładając że otworzyłem "Stronę główną" serwisu
    Wtedy powinienem w nagłówku zobaczyć logo firmy Szachuje
    Oraz w nagłówku powinienem widzieć menu serwisu zawierające następujące elementy
      | Nazwa         |
      | STRONA GŁÓWNA |
      | O NAS         |
      | KONTAKT       |

  Scenariusz: Widoczność stopki strony
    Zakładając że otworzyłem "Stronę główną" serwisu
    Wtedy powinienem zobaczyć stopkę
    I stopka powinna zawierać element "Kontakt" z danymi kontaktowymi firmy
    I dane kontaktowe w stopce powinny zawierać następujące elementy
      | Treść                               |
      | Szachuje agencja public relations   |
      | ul. Warszawska 1/2, 12-345 WARSZAWA |
      | T: (+48) 12 345 678                 |
      | E: biuro@szachuje.com               |
    Oraz w stopce powinno znajdować się menu z pozycjami
      | Nazwa         |
      | strona główna |
      | o nas         |
      | kontakt       |

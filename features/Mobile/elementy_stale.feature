# language: pl

@mobile
Potrzeba biznesowa: Strona informacyjna agencji kreatywnej Szachuje przystosowana do przeglądania na telefonie
  W celu poznania profilu firmy Szachuje oraz zakresu jej działań
  Jako użytkownik szukający informacji na temat firmy
  Chciałbym móc przeglądnąć stronę firmy na telefonie

  @javascript
  Scenariusz: Widoczność nagłówka strony mobilnej
    Zakładając że otworzyłem "Stronę główną" serwisu
    Oraz w nagłówku powinienem widzieć menu serwisu zawierające następujące elementy
      | Nazwa         |
      | Strona główna |
      | O nas         |
      | Kontakt       |
    Oraz nie powinno być widoczne logo firmy

  @javascript
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
    Oraz w stopce nie powinno być widoczne menu

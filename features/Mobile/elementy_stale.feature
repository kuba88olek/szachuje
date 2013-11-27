# language: pl

@mobile @javascript
Aspekt: Widoczność stałych elementów serwisu podczas przeglądania na telefonie
  Jako użytkownik szukający informacji i przeglądający stronę na telefonie
  Powienienem widzieć nagłowek strony zawierający menu serwisu
  Oraz powinienem widzieć stopkę serwisu zawierającą najważniejszcze dane kontaktowe.

  Założenia:
    Zakładając że otworzyłem dowolną stronę serwisu

  Scenariusz: Wyświetlanie naglówka strony
    Wtedy logo firmy Szachuje nie powinno być widoczne
    Oraz powinienem w nagłówku widzieć menu zawierające elementy:
      | Nazwa         |
      | STRONA GŁÓWNA |
      | O NAS         |
      | KONTAKT       |

  Scenariusz: Wyświetlanie stopki strony
    Wtedy powinienem w stopce zobaczyć nagłowek "Kontakt"
    Oraz dane w stopce powiny zawierac treści:
      | Nazwa                               |
      | SZACHUJE agencja public relations   |
      | ul. Warszawska 1/2, 12-345 WARSZAWA |
      | T: (+48) 12 345 678                 |
      | biuro@szachuje.com                  |
    Oraz menu w stopce nie powinno być widoczne

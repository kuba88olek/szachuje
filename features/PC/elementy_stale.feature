# language: pl

@pc @db @javascript @clearcache
Aspekt: Widoczność stałych elementów serwisu podczas przeglądania na ekranie w rozdzielczości 960x800px lub wyższej
  Jako użytkownik szukający informacji i przeglądający stronę w rozdzielczości 960x800px lub wyższej
  Powienienem widzieć nagłowek strony zawierający menu serwisu oraz logo
  Oraz powinienem widzieć stopkę serwisu zawierającą menu oraz najważniejszcze dane kontaktowe.

  Założenia:
    Zakładając że otworzyłem dowolną stronę serwisu

  Scenariusz: Wyświetlanie naglówka strony
    Wtedy logo firmy Szachuje powinno być widoczne
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
    Oraz powinienem w stopce widzieć menu serwisu zawierające elementy:
      | Nazwa         |
      | strona głowna |
      | o nas         |
      | kontakt       |

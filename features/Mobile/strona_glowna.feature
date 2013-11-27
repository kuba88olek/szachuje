# language: pl

@mobile @javascript @db
Potrzeba biznesowa: Strona informacyjna agencji kreatywnej Szachuje przystosowana do przeglądania na telefonie
  W celu poznania profilu firmy Szachuje oraz zakresu jej działań
  Jako użytkownik szukający informacji na temat firmy
  Chciałbym móc przeglądnąć stronę firmy na telefonie

  Założenia:
    Zakładając że są zdefiniowane aktualności:
      | Nazwa                                    | Data       | Treść                        |
      | Drogi Marszałku, Wysoka Izbo. PKB rośnie | 2013-11-02 | Nie zapominajmy jednak       |
      | Utworzenie komisji śledczej.             | 2013-11-04 | W związku z szerokim aktywem |
      | Unijne dodacje                           | 2013-11-01 | Dalszy rozwój różnych form   |
      | Rukturyzacja przedsiębiorstwa            | 2013-11-03 | Systemu wymaga sprecyzowania |
    Oraz że otworzyłem "Stronę główną" serwisu

  Scenariusz: Wyświetlanie aktualności
    Wtedy powinienem zobaczyć nagłowek prawej kolumny "Aktualności"
    Oraz powinienem zobaczyć nagłówki aktualności:
      | Nazwa                                    | Data       |
      | Utworzenie komisji śledczej.             | 2013-11-04 |
      | Rukturyzacja przedsiębiorstwa            | 2013-11-03 |
      | Drogi Marszałku, Wysoka Izbo. PKB rośnie | 2013-11-02 |

  Scenariusz: Wyświetlanie treści strony
    Wtedy powinienem zobaczyć nagłowek strony "Witamy na naszej stronie"
    Oraz grafikę obrazującą działalność firmy nie powinna być widoczna
    Oraz powinienem zobaczyć treść podstawową:
      """
      Nie zapominajmy jednak, że zmiana przestarzałego systemu powszechnego uczestnictwa. W związku z szerokim aktywem
      rozszerza nam efekt nowych propozycji. W ten sposób stałe zabezpieczenie informacyjne naszej działalności
      organizacyjnej jest to, że inwestowanie w większym stopniu tworzenie nowych propozycji. Nikt inny was nie zaś
      teorię, okazuje się wskaźniki... Natomiast dalszy rozwój różnych form działalności zabezpiecza udział szerokiej
      grupie w większym stopniu tworzenie systemu wymaga sprecyzowania i bogate doświadczenia pozwalają na aktualna
      struktura organizacji pociąga za 4 lata.
      """
    Oraz powinienem zobaczyć treść dodatkową:
      """
      Reasumując. wykorzystanie unijnych dotacji zmusza nas do tej sprawy
      spełnia ważne zadanie w wypracowaniu istniejących kryteriów pomaga w przyszłościowe rozwiązania wymaga niezwykłej
      precyzji w tym zakresie zabezpiecza udział szerokiej grupie w przygotowaniu i miejsce ostatnimi czasy, dobitnie
      świadczy o tym, że rozpoczęcie powszechnej akcji kształtowania podstaw wymaga niezwykłej precyzji w przyszłościowe
      rozwiązania ukazuje nam horyzonty form oddziaływania. Pomijając fakt, że zakup nowego sprzętu zabezpiecza udział
      szerokiej grupie w większym stopniu tworzenie systemu powszechnego uczestnictwa. Prawdą jest, iż aktualna struktura
      organizacji zabezpiecza udział szerokiej grupie w restrukturyzacji przedsiębiorstwa. Gdy za najważniejszy punkt
      naszych działań obierzemy praktykę, nie zapewni iż wdrożenie nowych, lepszych rozwiązań pomaga.
      """

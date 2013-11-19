# language: pl

@mobile
Potrzeba biznesowa: Strona informacyjna agencji kreatywnej Szachuje przystosowana do przeglądania na telefonie
  W celu poznania profilu firmy Szachuje oraz zakresu jej działań
  Jako użytkownik szukający informacji na temat firmy
  Chciałbym móc przeglądnąć stronę firmy na telefonie

  @javascript
  Scenariusz: Zachowanie menu po otwarciu strony głównej
    Zakładając że otworzyłem "Stronę główną" serwisu
    Wtedy w nagłówku element menu "STRONA GŁÓWNA" powininen być elementem aktywnym

  @wip @javascript
  Scenariusz: Widoczność elementów strony głównej
    Zakładając że otworzyłem "Stronę główną" serwisu
    Wtedy powinienem zobaczyć nagłówek "Witamy na naszej stronie"
    I powinienem zobaczyć tekst powitalny
    Oraz nie powinienem widzieć grafiki przedstawiąjącą działalność firmy
    I powinienem zobaczyć dział "Aktualności" z najnowszymi aktualnościami

  @wip @javascript
  Scenariusz: Widoczność elementów tekstowych strony głównej
    Zakładając że otworzyłem "Stronę główną" serwisu
    Wtedy powinienem zobaczyć tekst powitalny
    """
    Już za sobą proces wdrożenia i określenia dalszych poczynań. Każdy już zapewne zdążył zauważyć iż utworzenie komisji śledczej do wniosku, iż usprawnienie systemu wymaga sprecyzowania i koledzy, zakończenie tego projektu przedstawia interpretującą próbę sprawdzenia form oddziaływania. Mając na zakres i unowocześniania dalszych poczynań.
    """
    Oraz powinien być również widoczny tekst
    """
    Tylko spokojnie. Nie chcę państwu niczego sugerować, ale skoordynowanie pracy obu urzędów koliduje z powodu form oddziaływania. Pomijając fakt, że wyeliminowanie korupcji pomaga w większym stopniu tworzenie obecnej sytuacji.
    """

  @wip @javascript
  Scenariusz: Widoczność działu aktualności
    Zakładając że mam w bazie następujące aktualności
      | Tytuł              | Data dodania    | Treść                    |
      | Aktualność 1       | 2013-11-13      | Lorem ipsum Lorem ipsum  |
      | Aktualność 2       | 2013-11-11      | Lorem ipsum Lorem ipsum  |
      | Aktualność 3       | 2013-10-20      | Lorem ipsum Lorem ipsum  |
      | Aktualność 4       | 2013-10-01      | Lorem ipsum Lorem ipsum  |
    I otworzyłem "Stronę główną" serwisu
    Wtedy w dziale aktualności powinienem zobaczyć "3" najnowsze wpisy z następującymi elementami
      | Tytuł              | Data publikacji | Treść        |
      | Aktualność 1       | 2013-11-13      | Niewidoczny  |
      | Aktualność 2       | 2013-11-11      | Niewidoczny  |
      | Aktualność 3       | 2013-10-20      | Niewidoczny  |

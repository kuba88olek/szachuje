#Szachuje - aplikacja szkoleniowa FSi

Przed rozpoczęciem pracy powinieneś zapoznać się z instrukcjami z pliku [CONTRIBUTING](CONTRIBUTING.md)
Celem tej aplikacji jest wdrożenie nowych osób w metodykę pracy stosowaną w FSi.
Kod aplikacji zawiera implementację kilku historyjek użytkownika oraz specyfikacji obiektów.
Zadaniem osoby wdrażającej się w proces pracy jest dokończenie aplikacji z wykorzystaniem metodyki pracy BDD.

##Opis aplikacji
Aplikacja jest prostą stroną firmową fikcyjnej agencji kreatywnej Szachuje.
Strona ma być dostępna w wersji PC (>1280px szerokości) oraz mobilnej (<768px szerokości).
Folder [features/gfx](features/gfx) zawiera projekty graficzne wymagane do stworzenia aplikacji.

Aplikacja składa się z 3 stron, których treści przedstawione są na projektach graficznych

- Strona główna
 - tekst powitalny
 - 2 najnowsze aktualności
 - grafika reprezentująca firmę
- O firmie
 - prosta strona tekstowa
- Kontakt
 - szczegółowe dane kontaktowe firmy
 - formularz wysyłające zapytanie na kontaktowy adres email firmy

##Rozwój aplikacji
Proces pracy powinien wyglądać (mniej lub więcej) w następujący sposób:

1. Przygotowanie user stories dla konkretnej funkcjonalności/potrzeby biznesowej (np. menu serwisu w wersji PC).
2. Wysłanie pull requesta przy użyciu githuba zawierającego jedynie przygotowane wcześniej user stories.
3. Przygotowanie testów (kryteriów akceptacyjnych) dla jednego scenariusza oraz zaktualizowanie pull requesta
4. Implementacja kodu spełniającego kryteria akceptacyjne dla wcześniej przygotowanego scenariusza
5. Refaktoryzacja wcześniej napisanego kodu.

Jeden pull request powinien zawierać następujące commity:

1. Przygotowanie user stories dla funkcjonalności XXX
2. Przygotowanie testów dla scenariusza XXX
3. Implementacja kodu dla scenariusza XXX
4. Refaktoryzacja kodu dla scenariusza XXX

Oczywiście powyższy schemat nie jest wymogiem koniecznym jednak bardzo ułatwia weryfikację procesu pracy.

#Instalacja aplikacji

Pierwszym krokiem jest stworzenie wirtualnego środowiska przy użyciu vagranta

```
$ cd szachuje
$ composer install
$ git submodule init
$ git submodule update
$ cd vagrant
$ vagrant up
```

W czasie konfigurowania się środowiska do pliku /etc/hosts należy dodać następujący wpis

```
10.0.0.200      szachuje.dev
```

Po po zakończeniu procesu konfiguracji środowiska wirtualnego przez vagranta strona powinna być automatycznie
dostępna z przeglądarki na komputerze hosta pod adresem http://szachuje.dev



# Rozwój aplikacji

## Przygotowanie repozytorium

Przed rozpoczęciem pracy należy wykonać polecenie fork przy użyciu serwisu github w celu sklonowania
własnej kopii serwisu.

Następnie należy sklonować repozytorium na dysk lokalny (zamiast ***** powinieneś wpisać swój nick na githubie)

```
$ git clone git@github.com:*****/szachuje.git
```

Kolejnym krokiem jest dodanie oryginalnego repozytorium jako ``upstream`` do repozytorium na naszym dysku.

```
$ cd szachuje
$ git remote add upstream git@github.com:fsi-open/szachuje.git
$ git fetch upstream
```

## Wprowadzanie zmian w repozytorium

Przed przystąpieniem do pracy należy utworzyć nową gałąź (nazwa dev-branch jest przykładowa) bezpośrednio z gałęzi master,
upewniając się najpierw, że gałąź master jest aktualna względem oryginalnego repozytorium

```
$ git checkout master
$ git fetch upstream
$ git merge upstream/master
$ git branch dev-branch
$ git checkout dev-branch
```

Wprowadzone zmiany należy dodać do repozytorium przy użyciu polecenia git commit

```
$ git add .
$ git commit -a -m "Dodanie mechanizmu generowania plików PDF"
```

Przed wypchnięciem zmian należy wykonać polecenie rebase w celu upewnienia się, że zmiany zostały wprowadzone na
najświeższej wersji systemu. W tym celu należy przełączyć się na brancha master, zaktualizować go, wrócić na brancha
na którym były wprowadzane zmiany i wykonać polecenie rebase.

```
$ git checkout master
$ git fetch upstream
$ git merge upstream/master
$ git checkout dev-branch
$ git rebase master
```

> W przypadku wystąpienia konfliktów podczas operacji rebase należy je ręcznie rozwiązać a następnie wykonać polecenie
> ``git commit -a``

Tak przygotowane zmiany możemy wypchnąc na nasze repozytorium na githubie

```
$ git push origin branch-dev
```
Przed wysłaniem pierwszego pull requesta należy utworzyć issue na githubie w celu przygotowania przez osoby zarządzające
repozytorium gałęzi, na którą będą wysyłane zmiany.
Przykładowy tytuł issue "Branch norzechowicz"
W tej sytuacji właściciel repozytorium utworzy gałąź "norzechowicz", do której powinny być wysyłane wszystkie pull requesty.

# language: pl

@mobile @pc
Potrzeba biznesowa: Formularz kontaktowy
  W celu skontaktowania się firmy Szachuje
  Chciałbym miec możliwość wysłania wiadomości przed formularz kontaktowy nas tronie

  Założenia:
    Zakładając że otworzyłem stronę "Kontakt"

  Scenariusz: Widoczność formularza kontaktowego
    Wtedy powinienem zobaczyć formularz z polami:
      | Nazwa           |
      | imię            |
      | nazwisko        |
      | adres e-mail    |
      | numer telefonu  |
      | treść zapytania |
    Oraz powinienem zobaczyć przyck "Wyślij"

  Scenariusz: Nie prawidłowe wypełnienie formularza
    Gdy nacisnę przycisk "Wyślij"
    Wtedy powinienem zobaczyć komunikat "Formularz został wypełniony nieprawidłowo"
    Oraz powinny zostać oznaczone jako błędne pola:
      | Nazwa           |
      | adres e-mail    |
      | treść zapytania |
    Oraz email nie powinien zostać wysłany

  Scenariusz: Prawidłowe wypełnienie formularza
    I wypełniłem pole formularza kontaktowego "imię" wartością "Jan"
    I wypełniłem pole formularza kontaktowego "nazwisko" wartością "Kowalski"
    I wypełniłem pole formularza kontaktowego "adres e-mail" wartością "klient@example.com"
    I wypełniłem pole formularza kontaktowego "numer telefonu" wartością "123456789"
    I wypełniłem pole formularza kontaktowego "treść zapytania" wartością "Lorem Ipsum"
    Gdy nacisnę przycisk "Wyślij"
    Wtedy powinienem zobaczyć komunikat "Wiadomość została wysłana"
    Oraz na adres email firmy Szachuje powinien zostać wysłany email o temacie "Wiadomość z formularza kontaktowego" od nadawcy "klient@example.com" o treści:
    """
    Wiadomość z formularza kontaktowego:

    imię: Jan
    nazwisko: Kowalski
    adres e-mail: klient@example.com
    numer telefonu: 123456789
    treść zapytania:
    Lorem Ipsum
    """

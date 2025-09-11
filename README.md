# AGOS Website

Die Aikido Gemeinschaft Oder-Spree e.V. (AGOS) möchte eine moderne Vereinswebseite aufbauen.
Dieses Repository dient dazu, verschiedene Ansätze für Konzept, Design und technische Umsetzung auszuprobieren.

## Ziele

- Bereitstellung einer ansprechenden Webseite für Mitglieder, Interessierte und neue Besucher:innen

- Einfache Pflege der Inhalte (z. B. Trainingszeiten, Veranstaltungen, Nachrichten)

- Trennung von Inhalt und Darstellung, damit die Seite flexibel erweitert werden kann

- Möglichkeit, unterschiedliche technische Ansätze zu vergleichen und zu evaluieren

## Aktueller Stand

Der erste Prototyp besteht aus einem React-Frontend, das Inhalte aus einer Drupal-Instanz bezieht.
Damit ergibt sich folgende Aufteilung:

- Frontend: Darstellung der Webseite mit React in einem seperaten Repository: [AGOS Website react](https://github.com/mkuhles/agos-website-react)

- Backend: Verwaltung der Inhalte mit Drupal mittels eigens definierter content types

- Schnittstelle ist die im modul [agos](web/modules/custom/agos/) definierte API 

## Ausblick

Langfristig soll aus den Tests ein Konzept entstehen, das:

- für die Redaktion (Vereinsmitglieder, Trainer:innen) einfach zu bedienen ist,

- den Besucher:innen eine ansprechende, moderne Nutzererfahrung bietet,

- und möglichst wartungsarm betrieben werden kann.

# Local Logging Plugin für Moodle

Das Local Logging Plugin ermöglicht eine einfache Protokollierung von Ereignissen in Moodle. Es stellt eine Logger-Klasse zur Verfügung, die es Entwicklern ermöglicht, Nachrichten verschiedener Schweregrade zu protokollieren.

## Funktionsweise

Erstelle ein `Logger`-Objekt mit einem Komponentennamen und verwende die Methoden `info`, `debug`, `warning` und `error`, um Nachrichten zu protokollieren. Die Nachrichten werden in der Datenbank gespeichert.

## Installation

1. Kopiere den `local/logging`-Ordner in dein Moodle-`local`-Verzeichnis.
2. Besuche die Benachrichtigungsseite in deinem Moodle, um das Plugin zu installieren.

## Verwendung

```php
$logger = new \local_logging\logger('meineKomponente', 'aktuelle Komponente');
$logger->info('Eine informative Nachricht');
$logger->debug('Eine Debug-Nachricht');
```

## Konfiguration

Standardmäßig wird das Protokollierungsniveau auf WARNING gesetzt. Ändere `$CFG->local_logging_minloglevel` in deiner config.php, um dies anzupassen.

Die maximale Anzahl von Protokolleinträgen, die aufbewahrt werden sollen, kann durch `$CFG->local_logging_maxlogs` (Standardwert: 10000) in config.php konfiguriert werden.

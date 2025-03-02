# Local Logging Plugin für Moodle

[![Coverage Status](https://coveralls.io/repos/github/ProjektAdLer/MoodlePluginLocalLogging/badge.svg?branch=main)](https://coveralls.io/github/ProjektAdLer/MoodlePluginLocalLogging?branch=main)

Das Local Logging Plugin ermöglicht eine einfache Protokollierung von Ereignissen in Moodle. Es stellt eine Logger-Klasse zur Verfügung, die es Entwicklern ermöglicht, Nachrichten verschiedener Schweregrade zu protokollieren.

## Kompabilität
Folgende Versionen werden unterstützt (mit mariadb und postresql getestet):

siehe [plugin_compatibility.json](plugin_compatibility.json)

## Funktionsweise

Erstelle ein `Logger`-Objekt mit einem Komponentennamen und verwende die Methoden `info`, `debug`, `warning` und `error`, um Nachrichten zu protokollieren. Die Nachrichten werden in der Datenbank gespeichert.

## Verwendung

```php
$logger = new \local_logging\logger('meineKomponente', 'aktuelle Komponente');
$logger->info('Eine informative Nachricht');
$logger->debug('Eine Debug-Nachricht');
```

## Konfiguration

Standardmäßig wird das Protokollierungsniveau auf WARNING gesetzt. Ändere `$CFG->local_logging_minloglevel` in deiner config.php, um dies anzupassen. Beispiel: `$CFG->local_logging_minloglevel = 'TRACE';`

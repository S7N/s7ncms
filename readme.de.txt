S7Ncms

Sollten Sie Fehler finden oder Anregungen zu S7Ncms haben, melden Sie sich
bitte per E-Mail unter info@s7n.de.
Ich würde mich auch über eine Benachrichtigung freuen, wenn Sie sich für
S7Ncms entschieden haben und Ihre Seiten damit betreiben.

ANFORDERUNGEN
-------------------
Um S7Ncms erfolgreich einzusetzen, benötigen Sie die folgenden Software auf
Ihrem Webserver:
 * Apache mit mod_rewrite
 * PHP5
 * MySQL


INSTALLTION
-------------------
Nachdem Sie S7Ncms heruntergeladen haben, entpacken Sie das Archiv auf Ihrem
Computer. Wenn Sie damit fertig sind, müssen Sie folgende Einstellungen
vornehmen:
 * In der Datei administration/config/config.php
 
 * In der Datei administration/config/database.php
 
 * In der Datei application/config/config.php
 
 * In der Datei application/config/database.php

Falls Sie S7Ncms bei einem Webhoster einsetzen möchten, der .php-Dateien
standardmäßig als PHP4-Dateien behandelt und PHP5 auf dem Server nur als
FastCGI-Modul zur Verfügung steht (wie z.B. bei UD Media GmbH), so reicht es
aus, wenn Sie in der Datei .htaccess die Folgende Zeile hinzufügen:
    AddHandler php5-fastcgi .php

Sollte das nicht funktionieren, kontaktieren Sie bitte Ihren Webhoster.
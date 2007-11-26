S7Ncms 0.5

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
 	- Ändern Sie 'site_domain' auf Ihren Domainnamen und ggf. den Unterordner,
 	  in dem S7Ncms liegt. Beachten Sie, dass ein 'http://' nicht hingehört. Da
 	  Es sich hier um eine Einstellung für die Administration handelt, muss
 	  unbedingt '/admin' am ende Stehen, da diese sonst nicht aufgerufen werden
 	  kann!
 	  Beispiel: 'site_domain' => 'www.example.com/S7Ncms/admin'
 	  
 * In der Datei administration/config/database.php
            und application/config/database.php
 	- 'connection' muss die DSN (Data Source Name) der Datenbank enthalten.
 	  Eine DSN ist wie folgt aufgebaut:
 	      driver://user:password@server/database
 	  - driver: muss bei S7Ncms 'mysql' lauten
 	  - user: Benutzername für den MySQL-Server
 	  - password: Das dazugehörige Passwort
 	  - server: IP oder host des, auf dem MySQL läuft
 	  - database: Datenbank, in der Ihre Daten gespeichert sind
 	  
 	  Beispiel: mysql://s7n:cms@example.com/s7ncms
 
 * In der Datei application/config/config.php
    - Ändern Sie 'site_domain' auf Ihren Domainnamen und ggf. den Unterordner,
 	  in dem S7Ncms liegt. Beachten Sie, dass ein 'http://' nicht hingehört.
 	  Beispiel: 'site_domain' => 'www.example.com/S7Ncms' 


Falls Sie S7Ncms bei einem Webhoster einsetzen möchten, der .php-Dateien
standardmäßig als PHP4-Dateien behandelt und PHP5 auf dem Server als FastCGI-
Modul zur Verfügung steht (wie z.B. bei UD Media GmbH), so reicht es aus, wenn
Sie in der Datei .htaccess die Folgende Zeile hinzufügen:

    AddHandler php5-fastcgi .php

Sollte das nicht funktionieren, kontaktieren Sie bitte Ihren Webhoster.


Als Nächstes übertragen Sie mit phpMyAdmin (oder mit Hilfe der Tools, die Ihnen
zur Verfügung stehen) die Datei s7ncms.sql auf ihre MySQL-Datenbank.


Jetzt ist S7Ncms fertig konfiguriert und kann auf den Server übertragen werden.

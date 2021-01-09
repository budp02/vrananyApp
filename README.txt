Pro správnou funkci databáze je potřebné nastavit:
1. v souboru zsVranany.sql upravit na řádku 19 hodnotu s názvem databáze
2. v souboru /inc/db.php vložit správné přihlašovací údaje k MySQL serveru

Pro správnou funkčnost externího modulu TinyMCE je nutné:
1. registrace na https://www.tiny.cloud/auth/signup/
2. zkopírovaní klíče do souboru /admin/private.key, tento klíč je vygenerován po přihlášení
3. v souboru /admin/config.php upravit hodnotu $config['apikey'], kde vložíte vygenerovaný API key, přidělený po registraci

Údaje pro přihlášení do administrátorské části:
Jméno: test.user
Heslo: Passw0rd (pozor na nulu)

<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Admin\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'key' => 'admin',
        'boxes' => [
            'langswitch' => [
                'de_DE' => [
                    'name' => 'Sprachauswahl'
                ],
                'en_EN' => [
                    'name' => 'Language selection'
                ]
            ],
            'layoutswitch' => [
                'de_DE' => [
                    'name' => 'Layoutauswahl'
                ],
                'en_EN' => [
                    'name' => 'Layout selection'
                ]
            ]
        ]
    ];

    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());

        $date = new \Ilch\Date();
        $databaseConfig = new \Ilch\Config\Database($this->db());
        $databaseConfig->set('version', VERSION, 1)
            ->set('updateserver', 'https://www.ilch.de/ilch2_updates/stable/')
            ->set('locale', $this->getTranslator()->getLocale(), 1)
            ->set('date_cms_installed', $date->format('Y-m-d H:i:s'), 1)
            ->set('timezone', $_SESSION['install']['timezone'])
            ->set('default_layout', 'clan3columns')
            ->set('start_page', 'module_article')
            ->set('favicon', '')
            ->set('apple_icon', '')
            ->set('page_title', 'ilch - Content Management System')
            ->set('description', 'Das ilch CMS bietet dir ein einfach erweiterbares Grundsystem, welches keinerlei Kenntnisse in Programmiersprachen voraussetzt.')
            ->set('standardMail', $_SESSION['install']['adminEmail'])
            ->set('defaultPaginationObjects', 20)
            ->set('hideCaptchaFor', '1')
            ->set('admin_layout_hmenu', 'hmenu-fixed')
            ->set('maintenance_mode', '0')
            ->set('maintenance_status', '0')
            ->set('maintenance_date', $date->format('Y-m-d H:i:s'))
            ->set('maintenance_text', '<p>Die Seite befindet sich im Wartungsmodus</p>')
            ->set('custom_css', '')
            ->set('emailBlacklist', '')
            ->set('disable_purifier', '0');
    }

    public function getInstallSql()
    {
        return 'CREATE TABLE IF NOT EXISTS `[prefix]_config` (
                `key` VARCHAR(191) NOT NULL,
                `value` TEXT NOT NULL,
                `autoload` TINYINT(1) NOT NULL,
                UNIQUE KEY `key` (`key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_emails` (
                `moduleKey` VARCHAR(255) NOT NULL,
                `type` VARCHAR(255) NOT NULL,
                `desc` VARCHAR(255) NOT NULL,
                `text` TEXT NOT NULL,
                `locale` VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_modules` (
                `key` VARCHAR(191) NOT NULL,
                `system` TINYINT(1) NOT NULL DEFAULT 0,
                `layout` TINYINT(1) NOT NULL DEFAULT 0,
                `hide_menu` TINYINT(1) NOT NULL DEFAULT 0,
                `author` VARCHAR(255) NULL DEFAULT NULL,
                `version` VARCHAR(255) NULL DEFAULT NULL,
                `link` VARCHAR(255) NULL DEFAULT NULL,
                `icon_small` VARCHAR(255) NOT NULL,
                UNIQUE KEY `key` (`key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_modules_content` (
                `key` VARCHAR(255) NOT NULL,
                `locale` VARCHAR(255) NOT NULL,
                `description` VARCHAR(255) NOT NULL,
                `name` VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_modules_php_extensions` (
                `key` VARCHAR(255) NOT NULL,
                `extension` VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_modules_folderrights` (
                `key` VARCHAR(255) NOT NULL,
                `folder` VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_modules_boxes_content` (
                `key` VARCHAR(255) NOT NULL,
                `module` VARCHAR(255) NOT NULL,
                `locale` VARCHAR(255) NOT NULL,
                `name` VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_menu` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `title` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_menu_items` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `menu_id` INT(11) NOT NULL,
                `sort` INT(11) NOT NULL DEFAULT 0,
                `parent_id` INT(11) NOT NULL DEFAULT 0,
                `page_id` INT(11) NOT NULL DEFAULT 0,
                `box_id` INT(11) NOT NULL DEFAULT 0,
                `box_key` VARCHAR(255) NULL DEFAULT NULL,
                `type` TINYINT(1) NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `href` VARCHAR(255) NULL DEFAULT NULL,
                `target` VARCHAR(50) NULL DEFAULT NULL,
                `module_key` VARCHAR(255) NULL DEFAULT NULL,
                `access` VARCHAR(255) NOT NULL DEFAULT "",
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_boxes` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `date_created` DATETIME NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_boxes_content` (
                `box_id` INT(11) NOT NULL,
                `content` MEDIUMTEXT NOT NULL,
                `locale` VARCHAR(255) NOT NULL,
                `title` VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_pages` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `date_created` DATETIME NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_pages_content` (
                `page_id` INT(11) NOT NULL,
                `content` MEDIUMTEXT NOT NULL,
                `description` MEDIUMTEXT NOT NULL,
                `keywords` MEDIUMTEXT NOT NULL,
                `locale` VARCHAR(255) NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `perma` VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_backup` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL,
                `date` DATETIME NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_logs` (
                `user_id` VARCHAR(255) NOT NULL,
                `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `info` VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_admin_layoutadvsettings` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `layoutKey` VARCHAR(255) NOT NULL,
                `key` VARCHAR(255) NOT NULL,
                `value` TEXT NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_admin_notifications` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `module` VARCHAR(255) NOT NULL,
                `message` VARCHAR(255) NOT NULL,
                `url` VARCHAR(255) NOT NULL,
                `type` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_admin_notifications_permission` (
                `module` VARCHAR(255) NOT NULL,
                `granted` TINYINT(1) NOT NULL,
                `limit` TINYINT(1) UNSIGNED NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE IF NOT EXISTS `[prefix]_admin_updateservers` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `url` VARCHAR(255) NOT NULL,
                `operator` VARCHAR(255) NOT NULL,
                `country` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;
            
            INSERT INTO `[prefix]_admin_updateservers` (`id`, `url`, `operator`, `country`) VALUES (1, "https://www.ilch.de/ilch2_updates/stable/", "ilch", "Germany");';
    }

    public function getUpdate($installedVersion)
    {
        switch ($installedVersion) {
            case "2.0.1":
                // Add new hide_menu column
                $this->db()->query('ALTER TABLE `[prefix]_modules` ADD COLUMN `hide_menu` TINYINT(1) NOT NULL DEFAULT 0;');
                $this->db()->query('UPDATE `[prefix]_modules` SET `hide_menu` = 1 WHERE `key` = "comment";');
                break;
            case "2.0.3":
                // Add new top column for the top article feature
                // Add new read_access column to restrict who can read an article
                $this->db()->query('ALTER TABLE `[prefix]_articles` ADD COLUMN `top` TINYINT(1) NOT NULL DEFAULT 0;');
                $this->db()->query('ALTER TABLE `[prefix]_articles` ADD COLUMN `read_access` VARCHAR(255) NOT NULL DEFAULT \'1,2,3\';');

                replaceVendorDirectory();
                break;
            case "2.1.1":
                // Remove no longer needed gallery_id column.
                $this->db()->query('ALTER TABLE `[prefix]_users_gallery_items` DROP COLUMN `gallery_id`;');
                break;
            case "2.1.2":
                // Add new votes column for the article rating feature
                $this->db()->query('ALTER TABLE `[prefix]_articles_content` ADD COLUMN `votes` LONGTEXT NOT NULL;');

                replaceVendorDirectory();
                break;
            case "2.1.3":
                $this->db()->query('ALTER TABLE `[prefix]_menu_items` MODIFY COLUMN `access` VARCHAR(255) NOT NULL DEFAULT "";');
                $this->db()->query('ALTER TABLE `[prefix]_users` MODIFY COLUMN `locale` VARCHAR(255) NOT NULL DEFAULT "";');
                break;
            case "2.1.4":
                // Add new columns for user profile
                $this->db()->query('ALTER TABLE `[prefix]_users` ADD COLUMN `steam` VARCHAR(255) NOT NULL;');
                $this->db()->query('ALTER TABLE `[prefix]_users` ADD COLUMN `twitch` VARCHAR(255) NOT NULL;');
                $this->db()->query('ALTER TABLE `[prefix]_users` ADD COLUMN `teamspeak` VARCHAR(255) NOT NULL;');
                $this->db()->query('ALTER TABLE `[prefix]_users` ADD COLUMN `discord` VARCHAR(255) NOT NULL;');
                break;
            case "2.1.5":
                replaceVendorDirectory();
                break;
            case "2.1.7":
                // Create statistic_visibleStats and convert old settings into new format
                $databaseConfig = new \Ilch\Config\Database($this->db());
                $visibilitySettings = $databaseConfig->get('statistic_site');

                if ($databaseConfig->get('statistic_site')) {
                    $visibilitySettings .= ',1,1';
                } else {
                    $visibilitySettings .= ',0,0';
                }

                $visibilitySettings .= ','.$databaseConfig->get('statistic_visits');
                $visibilitySettings .= ','.$databaseConfig->get('statistic_browser');
                $visibilitySettings .= ','.$databaseConfig->get('statistic_os');
                $databaseConfig->set('statistic_visibleStats', $visibilitySettings, 0);

                // Remove the no longer needed settings of the statistic module
                $this->db()->queryMulti("DELETE FROM `[prefix]_config` WHERE `key` = 'statistic_site';
                             DELETE FROM `[prefix]_config` WHERE `key` = 'statistic_visits';
                             DELETE FROM `[prefix]_config` WHERE `key` = 'statistic_browser';
                             DELETE FROM `[prefix]_config` WHERE `key` = 'statistic_os';");

                // Add new default rule to the beginning of the current rules (DSGVO)
                $databaseConfig->set('regist_rules', '<p>Mit der Registrierung auf dieser Webseite, akzeptieren Sie die Datenschutzbestimmungen und den Haftungsausschluss.</p>'
                    .$databaseConfig->get('regist_rules'));

                // Add default value for the captcha setting, which indicates that administrators should not need to solve captchas.
                $databaseConfig->set('hideCaptchaFor', '1');
                break;
            case "2.1.8":
                // Imprint module
                // Create new needed column "imprint"
                $this->db()->query('ALTER TABLE `[prefix]_imprint` ADD COLUMN `imprint` MEDIUMTEXT NULL DEFAULT NULL;');

                // Copy previous entered information to the new column "imprint"
                $content = $this->db()->select('*')
                    ->from('imprint')
                    ->execute()
                    ->fetchAssoc();
                $contentString = '<b>'.$content['paragraph'].'</b><br><br>';
                $contentString .= $content['company'].'<br>';
                $contentString .= $content['name'].'<br>';
                $contentString .= $content['address'].'<br>';
                $contentString .= $content['addressadd'].'<br><br>';
                $contentString .= $content['city'].'<br><br>';

                $contentString .= '<b>Kontakt</b><br>';
                $contentString .= 'Telefon: '.$content['phone'].'<br>';
                $contentString .= 'Telefax: '.$content['fax'].'<br>';
                $contentString .= 'E-Mail: '.$content['email'].'<br><br>';

                $contentString .= 'Registergericht: '.$content['registration'].'<br>';
                $contentString .= 'Handelsregisternummer: '.$content['commercialregister'].'<br>';
                $contentString .= 'Umsatzsteuer-ID-Nummer: '.$content['vatid'].'<br>';

                $contentString .= $content['other'].'<br><br>';
                $contentString .= $content['disclaimer'].'<br>';

                $this->db()->query('UPDATE `[prefix]_imprint` SET `imprint` = \''.$contentString.'\';');

                // Delete now unneeded old columns
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `paragraph`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `company`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `name`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `address`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `addressadd`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `city`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `phone`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `fax`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `email`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `registration`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `commercialregister`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `vatid`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `other`;');
                $this->db()->query('ALTER TABLE `[prefix]_imprint` DROP COLUMN `disclaimer`;');

                // Delete unneeded files and folders
                unlink(ROOT_PATH.'/application/modules/imprint/controllers/admin/Settings.php');
                removeDir(ROOT_PATH.'/application/modules/imprint/views/admin/settings');

                // Privacy module
                // Insert new templates
                $this->db()->query('INSERT INTO `[prefix]_privacy` (`title`, `urltitle`, `url`, `text`, `show`) VALUES
                ("Datenschutz auf einen Blick", "eRecht24", "https://www.e-recht24.de", "<h3>Allgemeine Hinweise</h3> <p>Die folgenden Hinweise geben einen einfachen ??berblick dar??ber, was mit Ihren personenbezogenen Daten passiert, wenn Sie unsere Website besuchen. Personenbezogene Daten sind alle Daten, mit denen Sie pers??nlich identifiziert werden k??nnen. Ausf??hrliche Informationen zum Thema Datenschutz entnehmen Sie unserer unter diesem Text aufgef??hrten Datenschutzerkl??rung.</p> <h3>Datenerfassung auf unserer Website</h3> <p><strong>Wer ist verantwortlich f??r die Datenerfassung auf dieser Website?</strong></p> <p>Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber. Dessen Kontaktdaten k??nnen Sie dem Impressum dieser Website entnehmen.</p> <p><strong>Wie erfassen wir Ihre Daten?</strong></p> <p>Ihre Daten werden zum einen dadurch erhoben, dass Sie uns diese mitteilen. Hierbei kann es sich z.B. um Daten handeln, die Sie in ein Kontaktformular eingeben.</p> <p>Andere Daten werden automatisch beim Besuch der Website durch unsere IT-Systeme erfasst. Das sind vor allem technische Daten (z.B. Internetbrowser, Betriebssystem oder Uhrzeit des Seitenaufrufs). Die Erfassung dieser Daten erfolgt automatisch, sobald Sie unsere Website betreten.</p> <p><strong>Wof??r nutzen wir Ihre Daten?</strong></p> <p>Ein Teil der Daten wird erhoben, um eine fehlerfreie Bereitstellung der Website zu gew??hrleisten. Andere Daten k??nnen zur Analyse Ihres Nutzerverhaltens verwendet werden.</p> <p><strong>Welche Rechte haben Sie bez??glich Ihrer Daten?</strong></p> <p>Sie haben jederzeit das Recht unentgeltlich Auskunft ??ber Herkunft, Empf??nger und Zweck Ihrer gespeicherten personenbezogenen Daten zu erhalten. Sie haben au??erdem ein Recht, die Berichtigung, Sperrung oder L??schung dieser Daten zu verlangen. Hierzu sowie zu weiteren Fragen zum Thema Datenschutz k??nnen Sie sich jederzeit unter der im Impressum angegebenen Adresse an uns wenden. Des Weiteren steht Ihnen ein Beschwerderecht bei der zust??ndigen Aufsichtsbeh??rde zu.</p> <h3>Analyse-Tools und Tools von Drittanbietern</h3> <p>Beim Besuch unserer Website kann Ihr Surf-Verhalten statistisch ausgewertet werden. Das geschieht vor allem mit Cookies und mit sogenannten Analyseprogrammen. Die Analyse Ihres Surf-Verhaltens erfolgt in der Regel anonym; das Surf-Verhalten kann nicht zu Ihnen zur??ckverfolgt werden. Sie k??nnen dieser Analyse widersprechen oder sie durch die Nichtbenutzung bestimmter Tools verhindern. Detaillierte Informationen dazu finden Sie in der folgenden Datenschutzerkl??rung.</p> <p>Sie k??nnen dieser Analyse widersprechen. ??ber die Widerspruchsm??glichkeiten werden wir Sie in dieser Datenschutzerkl??rung informieren.</p>", 0),
                ("Allgemeine Hinweise und Pflichtinformationen", "eRecht24", "https://www.e-recht24.de", "<h3>Datenschutz</h3> <p>Die Betreiber dieser Seiten nehmen den Schutz Ihrer pers??nlichen Daten sehr ernst. Wir behandeln Ihre personenbezogenen Daten vertraulich und entsprechend der gesetzlichen Datenschutzvorschriften sowie dieser Datenschutzerkl??rung.</p> <p>Wenn Sie diese Website benutzen, werden verschiedene personenbezogene Daten erhoben. Personenbezogene Daten sind Daten, mit denen Sie pers??nlich identifiziert werden k??nnen. Die vorliegende Datenschutzerkl??rung erl??utert, welche Daten wir erheben und wof??r wir sie nutzen. Sie erl??utert auch, wie und zu welchem Zweck das geschieht.</p> <p>Wir weisen darauf hin, dass die Daten??bertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitsl??cken aufweisen kann. Ein l??ckenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht m??glich.</p> <h3>Hinweis zur verantwortlichen Stelle</h3> <p>Die verantwortliche Stelle f??r die Datenverarbeitung auf dieser Website ist:</p> <p>Beispielfirma<br /> Musterweg 10<br /> 90210 Musterstadt</p>  <p>Telefon: +49 (0) 123 44 55 66<br /> E-Mail: info@beispielfirma.de</p>  <p>Verantwortliche Stelle ist die nat??rliche oder juristische Person, die allein oder gemeinsam mit anderen ??ber die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten (z.B. Namen, E-Mail-Adressen o. ??.) entscheidet.</p> <h3>Widerruf Ihrer Einwilligung zur Datenverarbeitung</h3> <p>Viele Datenverarbeitungsvorg??nge sind nur mit Ihrer ausdr??cklichen Einwilligung m??glich. Sie k??nnen eine bereits erteilte Einwilligung jederzeit widerrufen. Dazu reicht eine formlose Mitteilung per E-Mail an uns. Die Rechtm????igkeit der bis zum Widerruf erfolgten Datenverarbeitung bleibt vom Widerruf unber??hrt.</p> <h3>Beschwerderecht bei der zust??ndigen Aufsichtsbeh??rde</h3> <p>Im Falle datenschutzrechtlicher Verst????e steht dem Betroffenen ein Beschwerderecht bei der zust??ndigen Aufsichtsbeh??rde zu. Zust??ndige Aufsichtsbeh??rde in datenschutzrechtlichen Fragen ist der Landesdatenschutzbeauftragte des Bundeslandes, in dem unser Unternehmen seinen Sitz hat. Eine Liste der Datenschutzbeauftragten sowie deren Kontaktdaten k??nnen folgendem Link entnommen werden: <a href=\"https://www.bfdi.bund.de/DE/Infothek/Anschriften_Links/anschriften_links-node.html\" target=\"_blank\">https://www.bfdi.bund.de/DE/Infothek/Anschriften_Links/anschriften_links-node.html</a>.</p> <h3>Recht auf Daten??bertragbarkeit</h3> <p>Sie haben das Recht, Daten, die wir auf Grundlage Ihrer Einwilligung oder in Erf??llung eines Vertrags automatisiert verarbeiten, an sich oder an einen Dritten in einem g??ngigen, maschinenlesbaren Format aush??ndigen zu lassen. Sofern Sie die direkte ??bertragung der Daten an einen anderen Verantwortlichen verlangen, erfolgt dies nur, soweit es technisch machbar ist.</p> <h3>SSL- bzw. TLS-Verschl??sselung</h3> <p>Diese Seite nutzt aus Sicherheitsgr??nden und zum Schutz der ??bertragung vertraulicher Inhalte, wie zum Beispiel Bestellungen oder Anfragen, die Sie an uns als Seitenbetreiber senden, eine SSL-bzw. TLS-Verschl??sselung. Eine verschl??sselte Verbindung erkennen Sie daran, dass die Adresszeile des Browsers von ???http://??? auf ???https://??? wechselt und an dem Schloss-Symbol in Ihrer Browserzeile.</p> <p>Wenn die SSL- bzw. TLS-Verschl??sselung aktiviert ist, k??nnen die Daten, die Sie an uns ??bermitteln, nicht von Dritten mitgelesen werden.</p> <h3>Verschl??sselter Zahlungsverkehr auf dieser Website</h3> <p>Besteht nach dem Abschluss eines kostenpflichtigen Vertrags eine Verpflichtung, uns Ihre Zahlungsdaten (z.B. Kontonummer bei Einzugserm??chtigung) zu ??bermitteln, werden diese Daten zur Zahlungsabwicklung ben??tigt.</p> <p>Der Zahlungsverkehr ??ber die g??ngigen Zahlungsmittel (Visa/MasterCard, Lastschriftverfahren) erfolgt ausschlie??lich ??ber eine verschl??sselte SSL- bzw. TLS-Verbindung. Eine verschl??sselte Verbindung erkennen Sie daran, dass die Adresszeile des Browsers von \"http://\" auf \"https://\" wechselt und an dem Schloss-Symbol in Ihrer Browserzeile.</p> <p>Bei verschl??sselter Kommunikation k??nnen Ihre Zahlungsdaten, die Sie an uns ??bermitteln, nicht von Dritten mitgelesen werden.</p> <h3>Auskunft, Sperrung, L??schung</h3> <p>Sie haben im Rahmen der geltenden gesetzlichen Bestimmungen jederzeit das Recht auf unentgeltliche Auskunft ??ber Ihre gespeicherten personenbezogenen Daten, deren Herkunft und Empf??nger und den Zweck der Datenverarbeitung und ggf. ein Recht auf Berichtigung, Sperrung oder L??schung dieser Daten. Hierzu sowie zu weiteren Fragen zum Thema personenbezogene Daten k??nnen Sie sich jederzeit unter der im Impressum angegebenen Adresse an uns wenden.</p> <h3>Widerspruch gegen Werbe-Mails</h3> <p>Der Nutzung von im Rahmen der Impressumspflicht ver??ffentlichten Kontaktdaten zur ??bersendung von nicht ausdr??cklich angeforderter Werbung und Informationsmaterialien wird hiermit widersprochen. Die Betreiber der Seiten behalten sich ausdr??cklich rechtliche Schritte im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-E-Mails, vor.</p>", 0),
                ("Datenschutzbeauftragter", "eRecht24", "https://www.e-recht24.de", "<h3>Gesetzlich vorgeschriebener Datenschutzbeauftragter</h3> <p>Wir haben f??r unser Unternehmen einen Datenschutzbeauftragten bestellt.</p> <p>Beispielfirma<br /> Musterweg 10<br /> 90210 Musterstadt</p>  <p>Telefon: +49 (0) 123 44 55 66<br /> E-Mail: info@beispielfirma.de</p>", 0),
                ("Datenerfassung auf unserer Website", "eRecht24", "https://www.e-recht24.de", "<h3>Cookies</h3> <p>Die Internetseiten verwenden teilweise so genannte Cookies. Cookies richten auf Ihrem Rechner keinen Schaden an und enthalten keine Viren. Cookies dienen dazu, unser Angebot nutzerfreundlicher, effektiver und sicherer zu machen. Cookies sind kleine Textdateien, die auf Ihrem Rechner abgelegt werden und die Ihr Browser speichert.</p> <p>Die meisten der von uns verwendeten Cookies sind so genannte ???Session-Cookies???. Sie werden nach Ende Ihres Besuchs automatisch gel??scht. Andere Cookies bleiben auf Ihrem Endger??t gespeichert bis Sie diese l??schen. Diese Cookies erm??glichen es uns, Ihren Browser beim n??chsten Besuch wiederzuerkennen.</p> <p>Sie k??nnen Ihren Browser so einstellen, dass Sie ??ber das Setzen von Cookies informiert werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies f??r bestimmte F??lle oder generell ausschlie??en sowie das automatische L??schen der Cookies beim Schlie??en des Browser aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalit??t dieser Website eingeschr??nkt sein.</p> <p>Cookies, die zur Durchf??hrung des elektronischen Kommunikationsvorgangs oder zur Bereitstellung bestimmter, von Ihnen erw??nschter Funktionen (z.B. Warenkorbfunktion) erforderlich sind, werden auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO gespeichert. Der Websitebetreiber hat ein berechtigtes Interesse an der Speicherung von Cookies zur technisch fehlerfreien und optimierten Bereitstellung seiner Dienste. Soweit andere Cookies (z.B. Cookies zur Analyse Ihres Surfverhaltens) gespeichert werden, werden diese in dieser Datenschutzerkl??rung gesondert behandelt.</p> <h3>Server-Log-Dateien</h3> <p>Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten Server-Log-Dateien, die Ihr Browser automatisch an uns ??bermittelt. Dies sind:</p> <ul> <li>Browsertyp und Browserversion</li> <li>verwendetes Betriebssystem</li> <li>Referrer URL</li> <li>Hostname des zugreifenden Rechners</li> <li>Uhrzeit der Serveranfrage</li> <li>IP-Adresse</li> </ul> <p>Eine Zusammenf??hrung dieser Daten mit anderen Datenquellen wird nicht vorgenommen.</p> <p>Grundlage f??r die Datenverarbeitung ist Art. 6 Abs. 1 lit. b DSGVO, der die Verarbeitung von Daten zur Erf??llung eines Vertrags oder vorvertraglicher Ma??nahmen gestattet.</p> <h3>Kontaktformular</h3> <p>Wenn Sie uns per Kontaktformular Anfragen zukommen lassen, werden Ihre Angaben aus dem Anfrageformular inklusive der von Ihnen dort angegebenen Kontaktdaten zwecks Bearbeitung der Anfrage und f??r den Fall von Anschlussfragen bei uns gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.</p> <p>Die Verarbeitung der in das Kontaktformular eingegebenen Daten erfolgt somit ausschlie??lich auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Sie k??nnen diese Einwilligung jederzeit widerrufen. Dazu reicht eine formlose Mitteilung per E-Mail an uns. Die Rechtm????igkeit der bis zum Widerruf erfolgten Datenverarbeitungsvorg??nge bleibt vom Widerruf unber??hrt.</p> <p>Die von Ihnen im Kontaktformular eingegebenen Daten verbleiben bei uns, bis Sie uns zur L??schung auffordern, Ihre Einwilligung zur Speicherung widerrufen oder der Zweck f??r die Datenspeicherung entf??llt (z.B. nach abgeschlossener Bearbeitung Ihrer Anfrage). Zwingende gesetzliche Bestimmungen ??? insbesondere Aufbewahrungsfristen ??? bleiben unber??hrt.</p> <h3>Registrierung auf dieser Website</h3> <p>Sie k??nnen sich auf unserer Website registrieren, um zus??tzliche Funktionen auf der Seite zu nutzen. Die dazu eingegebenen Daten verwenden wir nur zum Zwecke der Nutzung des jeweiligen Angebotes oder Dienstes, f??r den Sie sich registriert haben. Die bei der Registrierung abgefragten Pflichtangaben m??ssen vollst??ndig angegeben werden. Anderenfalls werden wir die Registrierung ablehnen.</p> <p>F??r wichtige ??nderungen etwa beim Angebotsumfang oder bei technisch notwendigen ??nderungen nutzen wir die bei der Registrierung angegebene E-Mail-Adresse, um Sie auf diesem Wege zu informieren.</p> <p>Die Verarbeitung der bei der Registrierung eingegebenen Daten erfolgt auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Sie k??nnen eine von Ihnen erteilte Einwilligung jederzeit widerrufen. Dazu reicht eine formlose Mitteilung per E-Mail an uns. Die Rechtm????igkeit der bereits erfolgten Datenverarbeitung bleibt vom Widerruf unber??hrt.</p> <p>Die bei der Registrierung erfassten Daten werden von uns gespeichert, solange Sie auf unserer Website registriert sind und werden anschlie??end gel??scht. Gesetzliche Aufbewahrungsfristen bleiben unber??hrt.</p> <h3>Registrierung mit Facebook Connect</h3> <p>Statt einer direkten Registrierung auf unserer Website k??nnen Sie sich mit Facebook Connect registrieren. Anbieter dieses Dienstes ist die Facebook Ireland Limited, 4 Grand Canal Square, Dublin 2, Irland.</p> <p>Wenn Sie sich f??r die Registrierung mit Facebook Connect entscheiden und auf den ???Login with Facebook???- / ???Connect with Facebook???-Button klicken, werden Sie automatisch auf die Plattform von Facebook weitergeleitet. Dort k??nnen Sie sich mit Ihren Nutzungsdaten anmelden. Dadurch wird Ihr Facebook-Profil mit unserer Website bzw. unseren Diensten verkn??pft. Durch diese Verkn??pfung erhalten wir Zugriff auf Ihre bei Facebook hinterlegten Daten. Dies sind vor allem:</p> <ul> <li>Facebook-Name</li> <li>Facebook-Profil- und Titelbild</li> <li>Facebook-Titelbild</li> <li>bei Facebook hinterlegte E-Mail-Adresse</li> <li>Facebook-ID</li> <li>Facebook-Freundeslisten</li> <li>Facebook Likes (???Gef??llt-mir???-Angaben)</li> <li>Geburtstag</li> <li>Geschlecht</li> <li>Land</li> <li>Sprache</li> </ul> <p>Diese Daten werden zur Einrichtung, Bereitstellung und Personalisierung Ihres Accounts genutzt.</p> <p>Weitere Informationen finden Sie in den Facebook-Nutzungsbedingungen und den Facebook-Datenschutzbestimmungen. Diese finden Sie unter: <a href=\"https://de-de.facebook.com/about/privacy/\" target=\"_blank\">https://de-de.facebook.com/about/privacy/</a> und <a href=\"https://www.facebook.com/legal/terms/\" target=\"_blank\">https://www.facebook.com/legal/terms/</a>.</p> <h3>Kommentarfunktion auf dieser Website</h3> <p>F??r die Kommentarfunktion auf dieser Seite werden neben Ihrem Kommentar auch Angaben zum Zeitpunkt der Erstellung des Kommentars, Ihre E-Mail-Adresse und, wenn Sie nicht anonym posten, der von Ihnen gew??hlte Nutzername gespeichert.</p> <p><strong>Speicherdauer der Kommentare</strong></p> <p>Die Kommentare und die damit verbundenen Daten (z.B. IP-Adresse) werden gespeichert und verbleiben auf unserer Website, bis der kommentierte Inhalt vollst??ndig gel??scht wurde oder die Kommentare aus rechtlichen Gr??nden gel??scht werden m??ssen (z.B. beleidigende Kommentare).</p> <p><strong>Rechtsgrundlage</strong></p> <p>Die Speicherung der Kommentare erfolgt auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Sie k??nnen eine von Ihnen erteilte Einwilligung jederzeit widerrufen. Dazu reicht eine formlose Mitteilung per E-Mail an uns. Die Rechtm????igkeit der bereits erfolgten Datenverarbeitungsvorg??nge bleibt vom Widerruf unber??hrt.</p>", 0),
                ("Soziale Medien", "eRecht24", "https://www.e-recht24.de", "<h3>Inhalte teilen ??ber Plugins (Facebook, Google+1, Twitter & Co.)</h3> <p>Die Inhalte auf unseren Seiten k??nnen datenschutzkonform in sozialen Netzwerken wie Facebook, Twitter oder Google+ geteilt werden. Diese Seite nutzt daf??r das <a href=\"https://www.e-recht24.de/erecht24-safe-sharing.html#datenschutz\" target=\"_blank\">eRecht24 Safe Sharing Tool</a>. Dieses Tool stellt den direkten Kontakt zwischen den Netzwerken und Nutzern erst dann her, wenn der Nutzer aktiv auf einen dieser Button klickt.</p> <p>Eine automatische ??bertragung von Nutzerdaten an die Betreiber dieser Plattformen erfolgt durch dieses Tool nicht. Ist der Nutzer bei einem der sozialen Netzwerke angemeldet, erscheint bei der Nutzung der Social-Buttons von Facebook, Google+1, Twitter & Co. ein Informations-Fenster, in dem der Nutzer den Text vor dem Absenden best??tigen kann.</p> <p>Unsere Nutzer k??nnen die Inhalte dieser Seite datenschutzkonform in sozialen Netzwerken teilen, ohne dass komplette Surf-Profile durch die Betreiber der Netzwerke erstellt werden.</p> <h3>Facebook-Plugins (Like & Share-Button)</h3> <p>Auf unseren Seiten sind Plugins des sozialen Netzwerks Facebook, Anbieter Facebook Inc., 1 Hacker Way, Menlo Park, California 94025, USA, integriert. Die Facebook-Plugins erkennen Sie an dem Facebook-Logo oder dem \"Like-Button\" (\"Gef??llt mir\") auf unserer Seite. Eine ??bersicht ??ber die Facebook-Plugins finden Sie hier: <a href=\"https://developers.facebook.com/docs/plugins/\" target=\"_blank\">https://developers.facebook.com/docs/plugins/</a>.</p> <p>Wenn Sie unsere Seiten besuchen, wird ??ber das Plugin eine direkte Verbindung zwischen Ihrem Browser und dem Facebook-Server hergestellt. Facebook erh??lt dadurch die Information, dass Sie mit Ihrer IP-Adresse unsere Seite besucht haben. Wenn Sie den Facebook \"Like-Button\" anklicken w??hrend Sie in Ihrem Facebook-Account eingeloggt sind, k??nnen Sie die Inhalte unserer Seiten auf Ihrem Facebook-Profil verlinken. Dadurch kann Facebook den Besuch unserer Seiten Ihrem Benutzerkonto zuordnen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt der ??bermittelten Daten sowie deren Nutzung durch Facebook erhalten. Weitere Informationen hierzu finden Sie in der Datenschutzerkl??rung von Facebook unter: <a href=\"https://de-de.facebook.com/policy.php\" target=\"_blank\">https://de-de.facebook.com/policy.php</a>.</p> <p>Wenn Sie nicht w??nschen, dass Facebook den Besuch unserer Seiten Ihrem Facebook-Nutzerkonto zuordnen kann, loggen Sie sich bitte aus Ihrem Facebook-Benutzerkonto aus.</p> <h3>Twitter Plugin</h3> <p>Auf unseren Seiten sind Funktionen des Dienstes Twitter eingebunden. Diese Funktionen werden angeboten durch die Twitter Inc., 1355 Market Street, Suite 900, San Francisco, CA 94103, USA. Durch das Benutzen von Twitter und der Funktion \"Re-Tweet\" werden die von Ihnen besuchten Websites mit Ihrem Twitter-Account verkn??pft und anderen Nutzern bekannt gegeben. Dabei werden auch Daten an Twitter ??bertragen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt der ??bermittelten Daten sowie deren Nutzung durch Twitter erhalten. Weitere Informationen hierzu finden Sie in der Datenschutzerkl??rung von Twitter unter: <a href=\"https://twitter.com/privacy\" target=\"_blank\">https://twitter.com/privacy</a>.</p> <p>Ihre Datenschutzeinstellungen bei Twitter k??nnen Sie in den Konto-Einstellungen unter <a href=\"https://twitter.com/account/settings\" target=\"_blank\">https://twitter.com/account/settings</a> ??ndern.</p> <h3>Google+ Plugin</h3> <p>Unsere Seiten nutzen Funktionen von Google+. Anbieter ist die Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA.</p> <p>Erfassung und Weitergabe von Informationen: Mithilfe der Google+-Schaltfl??che k??nnen Sie Informationen weltweit ver??ffentlichen. ??ber die Google+-Schaltfl??che erhalten Sie und andere Nutzer personalisierte Inhalte von Google und unseren Partnern. Google speichert sowohl die Information, dass Sie f??r einen Inhalt +1 gegeben haben, als auch Informationen ??ber die Seite, die Sie beim Klicken auf +1 angesehen haben. Ihre +1 k??nnen als Hinweise zusammen mit Ihrem Profilnamen und Ihrem Foto in Google-Diensten, wie etwa in Suchergebnissen oder in Ihrem Google-Profil, oder an anderen Stellen auf Websites und Anzeigen im Internet eingeblendet werden.</p> <p>Google zeichnet Informationen ??ber Ihre +1-Aktivit??ten auf, um die Google-Dienste f??r Sie und andere zu verbessern. Um die Google+-Schaltfl??che verwenden zu k??nnen, ben??tigen Sie ein weltweit sichtbares, ??ffentliches Google-Profil, das zumindest den f??r das Profil gew??hlten Namen enthalten muss. Dieser Name wird in allen Google-Diensten verwendet. In manchen F??llen kann dieser Name auch einen anderen Namen ersetzen, den Sie beim Teilen von Inhalten ??ber Ihr Google-Konto verwendet haben. Die Identit??t Ihres Google-Profils kann Nutzern angezeigt werden, die Ihre E-Mail-Adresse kennen oder ??ber andere identifizierende Informationen von Ihnen verf??gen.</p> <p>Verwendung der erfassten Informationen: Neben den oben erl??uterten Verwendungszwecken werden die von Ihnen bereitgestellten Informationen gem???? den geltenden Google-Datenschutzbestimmungen genutzt. Google ver??ffentlicht m??glicherweise zusammengefasste Statistiken ??ber die +1-Aktivit??ten der Nutzer bzw. gibt diese an Nutzer und Partner weiter, wie etwa Publisher, Inserenten oder verbundene Websites.</p> <h3>Instagram Plugin</h3> <p>Auf unseren Seiten sind Funktionen des Dienstes Instagram eingebunden. Diese Funktionen werden angeboten durch die Instagram Inc., 1601 Willow Road, Menlo Park, CA 94025, USA integriert.</p> <p>Wenn Sie in Ihrem Instagram-Account eingeloggt sind, k??nnen Sie durch Anklicken des Instagram-Buttons die Inhalte unserer Seiten mit Ihrem Instagram-Profil verlinken. Dadurch kann Instagram den Besuch unserer Seiten Ihrem Benutzerkonto zuordnen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt der ??bermittelten Daten sowie deren Nutzung durch Instagram erhalten.</p> <p>Weitere Informationen hierzu finden Sie in der Datenschutzerkl??rung von Instagram: <a href=\"https://instagram.com/about/legal/privacy/\" target=\"_blank\">https://instagram.com/about/legal/privacy/</a>.</p> <h3>Tumblr Plugin</h3> <p>Unsere Seiten nutzen Schaltfl??chen des Dienstes Tumblr. Anbieter ist die Tumblr, Inc., 35 East 21st St, 10th Floor, New York, NY 10010, USA.</p> <p>Diese Schaltfl??chen erm??glichen es Ihnen, einen Beitrag oder eine Seite bei Tumblr zu teilen oder dem Anbieter bei Tumblr zu folgen. Wenn Sie eine unserer Websites mit Tumblr-Button aufrufen, baut der Browser eine direkte Verbindung mit den Servern von Tumblr auf. Wir haben keinen Einfluss auf den Umfang der Daten, die Tumblr mit Hilfe dieses Plugins erhebt und ??bermittelt. Nach aktuellem Stand werden die IP-Adresse des Nutzers sowie die URL der jeweiligen Website ??bermittelt.</p> <p>Weitere Informationen hierzu finden sich in der Datenschutzerkl??rung von Tumblr unter: <a href=\"https://www.tumblr.com/policy/de/privacy\" target=\"_blank\">https://www.tumblr.com/policy/de/privacy</a>.</p> <h3>LinkedIn Plugin</h3> <p>Unsere Website nutzt Funktionen des Netzwerks LinkedIn. Anbieter ist die LinkedIn Corporation, 2029 Stierlin Court, Mountain View, CA 94043, USA. </p> <p>Bei jedem Abruf einer unserer Seiten, die Funktionen von LinkedIn enth??lt, wird eine Verbindung zu Servern von LinkedIn aufgebaut. LinkedIn wird dar??ber informiert, dass Sie unsere Internetseiten mit Ihrer IP-Adresse besucht haben. Wenn Sie den \"Recommend-Button\" von LinkedIn anklicken und in Ihrem Account bei LinkedIn eingeloggt sind, ist es LinkedIn m??glich, Ihren Besuch auf unserer Internetseite Ihnen und Ihrem Benutzerkonto zuzuordnen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt der ??bermittelten Daten sowie deren Nutzung durch LinkedIn haben.</p> <p>Weitere Informationen hierzu finden Sie in der Datenschutzerkl??rung von LinkedIn unter: <a href=\"https://www.linkedin.com/legal/privacy-policy\" target=\"_blank\">https://www.linkedin.com/legal/privacy-policy</a>.</p> <h3>XING Plugin</h3> <p>Unsere Website nutzt Funktionen des Netzwerks XING. Anbieter ist die XING AG, Dammtorstra??e 29-32, 20354 Hamburg, Deutschland.</p> <p>Bei jedem Abruf einer unserer Seiten, die Funktionen von XING enth??lt, wird eine Verbindung zu Servern von XING hergestellt. Eine Speicherung von personenbezogenen Daten erfolgt dabei nach unserer Kenntnis nicht. Insbesondere werden keine IP-Adressen gespeichert oder das Nutzungsverhalten ausgewertet.</p> <p>Weitere Information zum Datenschutz und dem XING Share-Button finden Sie in der Datenschutzerkl??rung von XING unter: <a href=\"https://www.xing.com/app/share?op=data_protection\" target=\"_blank\">https://www.xing.com/app/share?op=data_protection</a>.</p> <h3>Pinterest Plugin</h3> <p>Auf unserer Seite verwenden wir Social Plugins des sozialen Netzwerkes Pinterest, das von der Pinterest Inc., 808 Brannan Street, San Francisco, CA 94103-490, USA (\"Pinterest\") betrieben wird.</p> <p>Wenn Sie eine Seite aufrufen, die ein solches Plugin enth??lt, stellt Ihr Browser eine direkte Verbindung zu den Servern von Pinterest her. Das Plugin ??bermittelt dabei Protokolldaten an den Server von Pinterest in die USA. Diese Protokolldaten enthalten m??glicherweise Ihre IP-Adresse, die Adresse der besuchten Websites, die ebenfalls Pinterest-Funktionen enthalten, Art und Einstellungen des Browsers, Datum und Zeitpunkt der Anfrage, Ihre Verwendungsweise von Pinterest sowie Cookies.</p> <p>Weitere Informationen zu Zweck, Umfang und weiterer Verarbeitung und Nutzung der Daten durch Pinterest sowie Ihre diesbez??glichen Rechte und M??glichkeiten zum Schutz Ihrer Privatsph??re finden Sie in den Datenschutzhinweisen von Pinterest: <a href=\"https://about.pinterest.com/de/privacy-policy\" target=\"_blank\">https://about.pinterest.com/de/privacy-policy</a>.</p>", 0),
                ("Analyse Tools und Werbung", "eRecht24", "https://www.e-recht24.de", "<h3>Google Analytics</h3> <p>Diese Website nutzt Funktionen des Webanalysedienstes Google Analytics. Anbieter ist die Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA.</p> <p>Google Analytics verwendet so genannte \"Cookies\". Das sind Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie erm??glichen. Die durch den Cookie erzeugten Informationen ??ber Ihre Benutzung dieser Website werden in der Regel an einen Server von Google in den USA ??bertragen und dort gespeichert.</p> <p>Die Speicherung von Google-Analytics-Cookies erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse an der Analyse des Nutzerverhaltens, um sowohl sein Webangebot als auch seine Werbung zu optimieren.</p> <p><strong>IP Anonymisierung</strong></p> <p>Wir haben auf dieser Website die Funktion IP-Anonymisierung aktiviert. Dadurch wird Ihre IP-Adresse von Google innerhalb von Mitgliedstaaten der Europ??ischen Union oder in anderen Vertragsstaaten des Abkommens ??ber den Europ??ischen Wirtschaftsraum vor der ??bermittlung in die USA gek??rzt. Nur in Ausnahmef??llen wird die volle IP-Adresse an einen Server von Google in den USA ??bertragen und dort gek??rzt. Im Auftrag des Betreibers dieser Website wird Google diese Informationen benutzen, um Ihre Nutzung der Website auszuwerten, um Reports ??ber die Websiteaktivit??ten zusammenzustellen und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen gegen??ber dem Websitebetreiber zu erbringen. Die im Rahmen von Google Analytics von Ihrem Browser ??bermittelte IP-Adresse wird nicht mit anderen Daten von Google zusammengef??hrt.</p>  <p><strong>Browser Plugin</strong></p> <p>Sie k??nnen die Speicherung der Cookies durch eine entsprechende Einstellung Ihrer Browser-Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht s??mtliche Funktionen dieser Website vollumf??nglich werden nutzen k??nnen. Sie k??nnen dar??ber hinaus die Erfassung der durch den Cookie erzeugten und auf Ihre Nutzung der Website bezogenen Daten (inkl. Ihrer IP-Adresse) an Google sowie die Verarbeitung dieser Daten durch Google verhindern, indem Sie das unter dem folgenden Link verf??gbare Browser-Plugin herunterladen und installieren: <a href=\"https://tools.google.com/dlpage/gaoptout?hl=de\" target=\"_blank\">https://tools.google.com/dlpage/gaoptout?hl=de</a>.</p> <p><strong>Widerspruch gegen Datenerfassung</strong></p> <p>Sie k??nnen die Erfassung Ihrer Daten durch Google Analytics verhindern, indem Sie auf folgenden Link klicken. Es wird ein Opt-Out-Cookie gesetzt, der die Erfassung Ihrer Daten bei zuk??nftigen Besuchen dieser Website verhindert: <a href=\"javascript:gaOptout();\">Google Analytics deaktivieren</a>.</p> <p>Mehr Informationen zum Umgang mit Nutzerdaten bei Google Analytics finden Sie in der Datenschutzerkl??rung von Google: <a href=\"https://support.google.com/analytics/answer/6004245?hl=de\" target=\"_blank\">https://support.google.com/analytics/answer/6004245?hl=de</a>.</p><p><strong>Auftragsdatenverarbeitung</strong></p> <p>Wir haben mit Google einen Vertrag zur Auftragsdatenverarbeitung abgeschlossen und setzen die strengen Vorgaben der deutschen Datenschutzbeh??rden bei der Nutzung von Google Analytics vollst??ndig um.</p> <p><strong>Demografische Merkmale bei Google Analytics</strong></p> <p>Diese Website nutzt die Funktion ???demografische Merkmale??? von Google Analytics. Dadurch k??nnen Berichte erstellt werden, die Aussagen zu Alter, Geschlecht und Interessen der Seitenbesucher enthalten. Diese Daten stammen aus interessenbezogener Werbung von Google sowie aus Besucherdaten von Drittanbietern. Diese Daten k??nnen keiner bestimmten Person zugeordnet werden. Sie k??nnen diese Funktion jederzeit ??ber die Anzeigeneinstellungen in Ihrem Google-Konto deaktivieren oder die Erfassung Ihrer Daten durch Google Analytics wie im Punkt ???Widerspruch gegen Datenerfassung??? dargestellt generell untersagen.</p>  <h3>etracker</h3> <p>Unsere Website nutzt den Analysedienst etracker. Anbieter ist die etracker GmbH, Erste Brunnenstra??e 1, 20459 Hamburg, Deutschland. Aus den Daten k??nnen unter einem Pseudonym Nutzungsprofile erstellt werden. Dazu k??nnen Cookies eingesetzt werden. Bei Cookies handelt es sich um kleine Textdateien, die lokal im Zwischenspeicher Ihres Internet-Browsers gespeichert werden. Die Cookies erm??glichen es, Ihren Browser wieder zu erkennen. Die mit den etracker-Technologien erhobenen Daten werden ohne die gesondert erteilte Zustimmung des Betroffenen nicht genutzt, Besucher unserer Website pers??nlich zu identifizieren und werden nicht mit personenbezogenen Daten ??ber den Tr??ger des Pseudonyms zusammengef??hrt.</p> <p>etracker-Cookies verbleiben auf Ihrem Endger??t, bis Sie sie l??schen.</p> <p>Die Speicherung von etracker-Cookies erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse an der anonymisierten Analyse des Nutzerverhaltens, um sowohl sein Webangebot als auch seine Werbung zu optimieren.</p> <p>Der Datenerhebung und -speicherung k??nnen Sie jederzeit mit Wirkung f??r die Zukunft widersprechen. Um einer Datenerhebung und -speicherung Ihrer Besucherdaten f??r die Zukunft zu widersprechen, k??nnen Sie unter nachfolgendem Link ein Opt-Out-Cookie von etracker beziehen, dieser bewirkt, dass zuk??nftig keine Besucherdaten Ihres Browsers bei etracker erhoben und gespeichert werden: <a href=\"https://www.etracker.de/privacy?et=V23Jbb\" target=\"_blank\">https://www.etracker.de/privacy?et=V23Jbb</a>.</p> <p>Dadurch wird ein Opt-Out-Cookie mit dem Namen \"cntcookie\" von etracker gesetzt. Bitte l??schen Sie diesen Cookie nicht, solange Sie Ihren Widerspruch aufrecht erhalten m??chten. Weitere Informationen finden Sie in den Datenschutzbestimmungen von etracker: <a href=\"https://www.etracker.com/de/datenschutz.html\" target=\"_blank\">https://www.etracker.com/de/datenschutz.html</a>.</p> <p><strong>Abschluss eines Vertrags ??ber Auftragsdatenverarbeitung</strong></p> <p>Wir haben mit etracker einen Vertrag zur Auftragsdatenverarbeitung abgeschlossen und setzen die strengen Vorgaben der deutschen Datenschutzbeh??rden bei der Nutzung von etracker vollst??ndig um.</p> <h3>Matomo (ehemals Piwik)</h3> <p>Diese Website benutzt den Open Source Webanalysedienst Matomo. Matomo verwendet so genannte \"Cookies\". Das sind Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie erm??glichen. Dazu werden die durch den Cookie erzeugten Informationen ??ber die Benutzung dieser Website auf unserem Server gespeichert. Die IP-Adresse wird vor der Speicherung anonymisiert.</p> <p>Matomo-Cookies verbleiben auf Ihrem Endger??t, bis Sie sie l??schen.</p> <p>Die Speicherung von Matomo-Cookies erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse an der anonymisierten Analyse des Nutzerverhaltens, um sowohl sein Webangebot als auch seine Werbung zu optimieren.</p> <p>Die durch den Cookie erzeugten Informationen ??ber die Benutzung dieser Website werden nicht an Dritte weitergegeben. Sie k??nnen die Speicherung der Cookies durch eine entsprechende Einstellung Ihrer Browser-Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht s??mtliche Funktionen dieser Website vollumf??nglich werden nutzen k??nnen.</p> <p>Wenn Sie mit der Speicherung und Nutzung Ihrer Daten nicht einverstanden sind, k??nnen Sie die Speicherung und Nutzung hier deaktivieren. In diesem Fall wird in Ihrem Browser ein Opt-Out-Cookie hinterlegt, der verhindert, dass Matomo Nutzungsdaten speichert. Wenn Sie Ihre Cookies l??schen, hat dies zur Folge, dass auch das Matomo Opt-Out-Cookie gel??scht wird. Das Opt-Out muss bei einem erneuten Besuch unserer Seite wieder aktiviert werden.</p> <p><em><strong><a style=\"color:#F00;\" href=\"https://matomo.org/docs/privacy/\" rel=\"nofollow\" target=\"_blank\">[Hier Matomo iframe-Code einf??gen] (Klick f??r die Anleitung)</a></strong></em></p> <h3>WordPress Stats</h3> <p>Diese Website nutzt das WordPress Tool Stats, um Besucherzugriffe statistisch auszuwerten. Anbieter ist die Automattic Inc., 60 29th Street #343, San Francisco, CA 94110-4929, USA.</p> <p>WordPress Stats verwendet Cookies, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website erlauben. Die durch die Cookies generierten Informationen ??ber die Benutzung unserer Website werden auf Servern in den USA gespeichert. Ihre IP-Adresse wird nach der Verarbeitung und vor der Speicherung anonymisiert.</p> <p>???WordPress-Stats???-Cookies verbleiben auf Ihrem Endger??t, bis Sie sie l??schen. </p> <p>Die Speicherung von ???WordPress Stats???-Cookies erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse an der anonymisierten Analyse des Nutzerverhaltens, um sowohl sein Webangebot als auch seine Werbung zu optimieren.</p> <p>Sie k??nnen Ihren Browser so einstellen, dass Sie ??ber das Setzen von Cookies informiert werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies f??r bestimmte F??lle oder generell ausschlie??en sowie das automatische L??schen der Cookies beim Schlie??en des Browser aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalit??t unserer Website eingeschr??nkt sein. </p> <p>Sie k??nnen der Erhebung und Nutzung Ihrer Daten f??r die Zukunft widersprechen, indem Sie mit einem Klick auf diesen Link einen Opt-Out-Cookie in Ihrem Browser setzen: <a href=\"https://www.quantcast.com/opt-out/\" target=\"_blank\">https://www.quantcast.com/opt-out/</a>.</p> <p>Wenn Sie die Cookies auf Ihrem Rechner l??schen, m??ssen Sie den Opt-Out-Cookie erneut setzen.</p> <h3>Google AdSense</h3> <p>Diese Website benutzt Google AdSense, einen Dienst zum Einbinden von Werbeanzeigen der Google Inc. (\"Google\"). Anbieter ist die Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA.</p> <p>Google AdSense verwendet sogenannte \"Cookies\", Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website erm??glichen. Google AdSense verwendet auch so genannte Web Beacons (unsichtbare Grafiken). Durch diese Web Beacons k??nnen Informationen wie der Besucherverkehr auf diesen Seiten ausgewertet werden.</p> <p>Die durch Cookies und Web Beacons erzeugten Informationen ??ber die Benutzung dieser Website (einschlie??lich Ihrer IP-Adresse) und Auslieferung von Werbeformaten werden an einen Server von Google in den USA ??bertragen und dort gespeichert. Diese Informationen k??nnen von Google an Vertragspartner von Google weiter gegeben werden. Google wird Ihre IP-Adresse jedoch nicht mit anderen von Ihnen gespeicherten Daten zusammenf??hren.</p> <p>Die Speicherung von AdSense-Cookies erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse an der Analyse des Nutzerverhaltens, um sowohl sein Webangebot als auch seine Werbung zu optimieren.</p> <p>Sie k??nnen die Installation der Cookies durch eine entsprechende Einstellung Ihrer Browser Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht s??mtliche Funktionen dieser Website voll umf??nglich nutzen k??nnen. Durch die Nutzung dieser Website erkl??ren Sie sich mit der Bearbeitung der ??ber Sie erhobenen Daten durch Google in der zuvor beschriebenen Art und Weise und zu dem zuvor benannten Zweck einverstanden.</p> <h3>Google Analytics Remarketing</h3> <p>Unsere Websites nutzen die Funktionen von Google Analytics Remarketing in Verbindung mit den ger??te??bergreifenden Funktionen von Google AdWords und Google DoubleClick. Anbieter ist die Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA.</p> <p>Diese Funktion erm??glicht es die mit Google Analytics Remarketing erstellten Werbe-Zielgruppen mit den ger??te??bergreifenden Funktionen von Google AdWords und Google DoubleClick zu verkn??pfen. Auf diese Weise k??nnen interessenbezogene, personalisierte Werbebotschaften, die in Abh??ngigkeit Ihres fr??heren Nutzungs- und Surfverhaltens auf einem Endger??t (z.B. Handy) an Sie angepasst wurden auch auf einem anderen Ihrer Endger??te (z.B. Tablet oder PC) angezeigt werden.</p> <p>Haben Sie eine entsprechende Einwilligung erteilt, verkn??pft Google zu diesem Zweck Ihren Web- und App-Browserverlauf mit Ihrem Google-Konto. Auf diese Weise k??nnen auf jedem Endger??t auf dem Sie sich mit Ihrem Google-Konto anmelden, dieselben personalisierten Werbebotschaften geschaltet werden.</p> <p>Zur Unterst??tzung dieser Funktion erfasst Google Analytics google-authentifizierte IDs der Nutzer, die vor??bergehend mit unseren Google-Analytics-Daten verkn??pft werden, um Zielgruppen f??r die ger??te??bergreifende Anzeigenwerbung zu definieren und zu erstellen.</p> <p>Sie k??nnen dem ger??te??bergreifenden Remarketing/Targeting dauerhaft widersprechen, indem Sie personalisierte Werbung in Ihrem Google-Konto deaktivieren; folgen Sie hierzu diesem Link: <a href=\"https://www.google.com/settings/ads/onweb/\" target=\"_blank\">https://www.google.com/settings/ads/onweb/</a>.</p> <p>Die Zusammenfassung der erfassten Daten in Ihrem Google-Konto erfolgt ausschlie??lich auf Grundlage Ihrer Einwilligung, die Sie bei Google abgeben oder widerrufen k??nnen (Art. 6 Abs. 1 lit. a DSGVO). Bei Datenerfassungsvorg??ngen, die nicht in Ihrem Google-Konto zusammengef??hrt werden (z.B. weil Sie kein Google-Konto haben oder der Zusammenf??hrung widersprochen haben) beruht die Erfassung der Daten auf Art. 6 Abs. 1 lit. f DSGVO. Das berechtigte Interesse ergibt sich daraus, dass der Websitebetreiber ein Interesse an der anonymisierten Analyse der Websitebesucher zu Werbezwecken hat.</p> <p>Weitergehende Informationen und die Datenschutzbestimmungen finden Sie in der Datenschutzerkl??rung von Google unter: <a href=\"https://www.google.com/policies/technologies/ads/\" target=\"_blank\">https://www.google.com/policies/technologies/ads/</a>.</p> <h3>Google AdWords und Google Conversion-Tracking</h3> <p>Diese Website verwendet Google AdWords. AdWords ist ein Online-Werbeprogramm der Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, United States (???Google???).</p> <p>Im Rahmen von Google AdWords nutzen wir das so genannte Conversion-Tracking. Wenn Sie auf eine von Google geschaltete Anzeige klicken wird ein Cookie f??r das Conversion-Tracking gesetzt. Bei Cookies handelt es sich um kleine Textdateien, die der Internet-Browser auf dem Computer des Nutzers ablegt. Diese Cookies verlieren nach 30 Tagen ihre G??ltigkeit und dienen nicht der pers??nlichen Identifizierung der Nutzer. Besucht der Nutzer bestimmte Seiten dieser Website und das Cookie ist noch nicht abgelaufen, k??nnen Google und wir erkennen, dass der Nutzer auf die Anzeige geklickt hat und zu dieser Seite weitergeleitet wurde.</p> <p>Jeder Google AdWords-Kunde erh??lt ein anderes Cookie. Die Cookies k??nnen nicht ??ber die Websites von AdWords-Kunden nachverfolgt werden. Die mithilfe des Conversion-Cookies eingeholten Informationen dienen dazu, Conversion-Statistiken f??r AdWords-Kunden zu erstellen, die sich f??r Conversion-Tracking entschieden haben. Die Kunden erfahren die Gesamtanzahl der Nutzer, die auf ihre Anzeige geklickt haben und zu einer mit einem Conversion-Tracking-Tag versehenen Seite weitergeleitet wurden. Sie erhalten jedoch keine Informationen, mit denen sich Nutzer pers??nlich identifizieren lassen. Wenn Sie nicht am Tracking teilnehmen m??chten, k??nnen Sie dieser Nutzung widersprechen, indem Sie das Cookie des Google Conversion-Trackings ??ber ihren Internet-Browser unter Nutzereinstellungen leicht deaktivieren. Sie werden sodann nicht in die Conversion-Tracking Statistiken aufgenommen.</p> <p>Die Speicherung von ???Conversion-Cookies??? erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse an der Analyse des Nutzerverhaltens, um sowohl sein Webangebot als auch seine Werbung zu optimieren.</p> <p>Mehr Informationen zu Google AdWords und Google Conversion-Tracking finden Sie in den Datenschutzbestimmungen von Google: <a href=\"https://www.google.de/policies/privacy/\" target=\"_blank\">https://www.google.de/policies/privacy/</a>.</p> <p>Sie k??nnen Ihren Browser so einstellen, dass Sie ??ber das Setzen von Cookies informiert werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies f??r bestimmte F??lle oder generell ausschlie??en sowie das automatische L??schen der Cookies beim Schlie??en des Browser aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalit??t dieser Website eingeschr??nkt sein.</p> <h3>Google reCAPTCHA</h3> <p>Wir nutzen ???Google reCAPTCHA??? (im Folgenden ???reCAPTCHA???) auf unseren Websites. Anbieter ist die Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA (???Google???).</p> <p>Mit reCAPTCHA soll ??berpr??ft werden, ob die Dateneingabe auf unseren Websites (z.B. in einem Kontaktformular) durch einen Menschen oder durch ein automatisiertes Programm erfolgt. Hierzu analysiert reCAPTCHA das Verhalten des Websitebesuchers anhand verschiedener Merkmale. Diese Analyse beginnt automatisch, sobald der Websitebesucher die Website betritt. Zur Analyse wertet reCAPTCHA verschiedene Informationen aus (z.B. IP-Adresse, Verweildauer des Websitebesuchers auf der Website oder vom Nutzer get??tigte Mausbewegungen). Die bei der Analyse erfassten Daten werden an Google weitergeleitet.</p> <p>Die reCAPTCHA-Analysen laufen vollst??ndig im Hintergrund. Websitebesucher werden nicht darauf hingewiesen, dass eine Analyse stattfindet.</p> <p>Die Datenverarbeitung erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse daran, seine Webangebote vor missbr??uchlicher automatisierter Aussp??hung und vor SPAM zu sch??tzen.</p> <p>Weitere Informationen zu Google reCAPTCHA sowie die Datenschutzerkl??rung von Google entnehmen Sie folgenden Links: <a href=\"https://www.google.com/intl/de/policies/privacy/\" target=\"_blank\">https://www.google.com/intl/de/policies/privacy/</a> und <a href=\"https://www.google.com/recaptcha/intro/android.html\" target=\"_blank\">https://www.google.com/recaptcha/intro/android.html</a>.</p> <h3>Facebook Pixel</h3> <p>Unsere Website nutzt zur Konversionsmessung das Besucheraktions-Pixel von Facebook, Facebook Inc., 1601 S. California Ave, Palo Alto, CA 94304, USA (???Facebook???).</p> <p>So kann das Verhalten der Seitenbesucher nachverfolgt werden, nachdem diese durch Klick auf eine Facebook-Werbeanzeige auf die Website des Anbieters weitergeleitet wurden. Dadurch k??nnen die Wirksamkeit der Facebook-Werbeanzeigen f??r statistische und Marktforschungszwecke ausgewertet werden und zuk??nftige Werbema??nahmen optimiert werden.</p> <p>Die erhobenen Daten sind f??r uns als Betreiber dieser Website anonym, wir k??nnen keine R??ckschl??sse auf die Identit??t der Nutzer ziehen. Die Daten werden aber von Facebook gespeichert und verarbeitet, sodass eine Verbindung zum jeweiligen Nutzerprofil m??glich ist und Facebook die Daten f??r eigene Werbezwecke, entsprechend der <a href=\"https://www.facebook.com/about/privacy/\" target=\"_blank\">Facebook-Datenverwendungsrichtlinie</a> verwenden kann. Dadurch kann Facebook das Schalten von Werbeanzeigen auf Seiten von Facebook sowie au??erhalb von Facebook erm??glichen. Diese Verwendung der Daten kann von uns als Seitenbetreiber nicht beeinflusst werden.</p> <p>In den Datenschutzhinweisen von Facebook finden Sie weitere Hinweise zum Schutz Ihrer Privatsph??re: <a href=\"https://www.facebook.com/about/privacy/\" target=\"_blank\">https://www.facebook.com/about/privacy/</a>.</p> <p>Sie k??nnen au??erdem die Remarketing-Funktion ???Custom Audiences??? im Bereich Einstellungen f??r Werbeanzeigen unter <a href=\"https://www.facebook.com/ads/preferences/?entry_product=ad_settings_screen\" target=\"_blank\">https://www.facebook.com/ads/preferences/?entry_product=ad_settings_screen</a> deaktivieren. Dazu m??ssen Sie bei Facebook angemeldet sein.</p> <p>Wenn Sie kein Facebook Konto besitzen, k??nnen Sie nutzungsbasierte Werbung von Facebook auf der Website der European Interactive Digital Advertising Alliance deaktivieren: <a href=\"http://www.youronlinechoices.com/de/praferenzmanagement/\" target=\"_blank\">http://www.youronlinechoices.com/de/praferenzmanagement/</a>.</p>", 0),
                ("Newsletter", "eRecht24", "https://www.e-recht24.de", "<h3>Newsletterdaten</h3> <p>Wenn Sie den auf der Website angebotenen Newsletter beziehen m??chten, ben??tigen wir von Ihnen eine E-Mail-Adresse sowie Informationen, welche uns die ??berpr??fung gestatten, dass Sie der Inhaber der angegebenen E-Mail-Adresse sind und mit dem Empfang des Newsletters einverstanden sind. Weitere Daten werden nicht bzw. nur auf freiwilliger Basis erhoben. Diese Daten verwenden wir ausschlie??lich f??r den Versand der angeforderten Informationen und geben diese nicht an Dritte weiter.</p> <p>Die Verarbeitung der in das Newsletteranmeldeformular eingegebenen Daten erfolgt ausschlie??lich auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Die erteilte Einwilligung zur Speicherung der Daten, der E-Mail-Adresse sowie deren Nutzung zum Versand des Newsletters k??nnen Sie jederzeit widerrufen, etwa ??ber den \"Austragen\"-Link im Newsletter. Die Rechtm????igkeit der bereits erfolgten Datenverarbeitungsvorg??nge bleibt vom Widerruf unber??hrt.</p> <p>Die von Ihnen zum Zwecke des Newsletter-Bezugs bei uns hinterlegten Daten werden von uns bis zu Ihrer Austragung aus dem Newsletter gespeichert und nach der Abbestellung des Newsletters gel??scht. Daten, die zu anderen Zwecken bei uns gespeichert wurden (z.B. E-Mail-Adressen f??r den Mitgliederbereich) bleiben hiervon unber??hrt.</p>", 0),
                ("Plugins und Tools", "eRecht24", "https://www.e-recht24.de", "<h3>YouTube</h3> <p>Unsere Website nutzt Plugins der von Google betriebenen Seite YouTube. Betreiber der Seiten ist die YouTube, LLC, 901 Cherry Ave., San Bruno, CA 94066, USA.</p> <p>Wenn Sie eine unserer mit einem YouTube-Plugin ausgestatteten Seiten besuchen, wird eine Verbindung zu den Servern von YouTube hergestellt. Dabei wird dem YouTube-Server mitgeteilt, welche unserer Seiten Sie besucht haben.</p> <p>Wenn Sie in Ihrem YouTube-Account eingeloggt sind, erm??glichen Sie YouTube, Ihr Surfverhalten direkt Ihrem pers??nlichen Profil zuzuordnen. Dies k??nnen Sie verhindern, indem Sie sich aus Ihrem YouTube-Account ausloggen.</p> <p>Die Nutzung von YouTube erfolgt im Interesse einer ansprechenden Darstellung unserer Online-Angebote. Dies stellt ein berechtigtes Interesse im Sinne von Art. 6 Abs. 1 lit. f DSGVO dar.</p> <p>Weitere Informationen zum Umgang mit Nutzerdaten finden Sie in der Datenschutzerkl??rung von YouTube unter: <a href=\"https://www.google.de/intl/de/policies/privacy\" target=\"_blank\">https://www.google.de/intl/de/policies/privacy</a>.</p> <h3>Vimeo</h3> <p>Unsere Website nutzt Plugins des Videoportals Vimeo. Anbieter ist die Vimeo Inc., 555 West 18th Street, New York, New York 10011, USA.</p> <p>Wenn Sie eine unserer mit einem Vimeo-Plugin ausgestatteten Seiten besuchen, wird eine Verbindung zu den Servern von Vimeo hergestellt. Dabei wird dem Vimeo-Server mitgeteilt, welche unserer Seiten Sie besucht haben. Zudem erlangt Vimeo Ihre IP-Adresse. Dies gilt auch dann, wenn Sie nicht bei Vimeo eingeloggt sind oder keinen Account bei Vimeo besitzen. Die von Vimeo erfassten Informationen werden an den Vimeo-Server in den USA ??bermittelt.</p> <p>Wenn Sie in Ihrem Vimeo-Account eingeloggt sind, erm??glichen Sie Vimeo, Ihr Surfverhalten direkt Ihrem pers??nlichen Profil zuzuordnen. Dies k??nnen Sie verhindern, indem Sie sich aus Ihrem Vimeo-Account ausloggen.</p> <p>Weitere Informationen zum Umgang mit Nutzerdaten finden Sie in der Datenschutzerkl??rung von Vimeo unter: <a href=\"https://vimeo.com/privacy\" target=\"_blank\">https://vimeo.com/privacy</a>.</p> <h3>Google Web Fonts</h3> <p>Diese Seite nutzt zur einheitlichen Darstellung von Schriftarten so genannte Web Fonts, die von Google bereitgestellt werden. Beim Aufruf einer Seite l??dt Ihr Browser die ben??tigten Web Fonts in ihren Browsercache, um Texte und Schriftarten korrekt anzuzeigen.</p> <p>Zu diesem Zweck muss der von Ihnen verwendete Browser Verbindung zu den Servern von Google aufnehmen. Hierdurch erlangt Google Kenntnis dar??ber, dass ??ber Ihre IP-Adresse unsere Website aufgerufen wurde. Die Nutzung von Google Web Fonts erfolgt im Interesse einer einheitlichen und ansprechenden Darstellung unserer Online-Angebote. Dies stellt ein berechtigtes Interesse im Sinne von Art. 6 Abs. 1 lit. f DSGVO dar.</p> <p>Wenn Ihr Browser Web Fonts nicht unterst??tzt, wird eine Standardschrift von Ihrem Computer genutzt.</p> <p>Weitere Informationen zu Google Web Fonts finden Sie unter <a href=\"https://developers.google.com/fonts/faq\" target=\"_blank\">https://developers.google.com/fonts/faq</a> und in der Datenschutzerkl??rung von Google: <a href=\"https://www.google.com/policies/privacy/\" target=\"_blank\">https://www.google.com/policies/privacy/</a>.</p> <h3>Google Maps</h3> <p>Diese Seite nutzt ??ber eine API den Kartendienst Google Maps. Anbieter ist die Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA.</p> <p>Zur Nutzung der Funktionen von Google Maps ist es notwendig, Ihre IP Adresse zu speichern. Diese Informationen werden in der Regel an einen Server von Google in den USA ??bertragen und dort gespeichert. Der Anbieter dieser Seite hat keinen Einfluss auf diese Daten??bertragung.</p> <p>Die Nutzung von Google Maps erfolgt im Interesse einer ansprechenden Darstellung unserer Online-Angebote und an einer leichten Auffindbarkeit der von uns auf der Website angegebenen Orte. Dies stellt ein berechtigtes Interesse im Sinne von Art. 6 Abs. 1 lit. f DSGVO dar.</p> <p>Mehr Informationen zum Umgang mit Nutzerdaten finden Sie in der Datenschutzerkl??rung von Google: <a href=\"https://www.google.de/intl/de/policies/privacy/\" target=\"_blank\">https://www.google.de/intl/de/policies/privacy/</a>.</p> <h3>SoundCloud</h3> <p>Auf unseren Seiten k??nnen Plugins des sozialen Netzwerks SoundCloud (SoundCloud Limited, Berners House, 47-48 Berners Street, London W1T 3NF, Gro??britannien.) integriert sein. Die SoundCloud-Plugins erkennen Sie an dem SoundCloud-Logo auf den betroffenen Seiten.</p> <p>Wenn Sie unsere Seiten besuchen, wird nach Aktivierung des Plugin eine direkte Verbindung zwischen Ihrem Browser und dem SoundCloud-Server hergestellt. SoundCloud erh??lt dadurch die Information, dass Sie mit Ihrer IP-Adresse unsere Seite besucht haben. Wenn Sie den ???Like-Button??? oder ???Share-Button??? anklicken w??hrend Sie in Ihrem SoundCloud- Benutzerkonto eingeloggt sind, k??nnen Sie die Inhalte unserer Seiten mit Ihrem SoundCloud-Profil verlinken und/oder teilen. Dadurch kann SoundCloud Ihrem Benutzerkonto den Besuch unserer Seiten zuordnen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt der ??bermittelten Daten sowie deren Nutzung durch SoundCloud erhalten. Weitere Informationen hierzu finden Sie in der Datenschutzerkl??rung von SoundCloud unter: <a href=\"https://soundcloud.com/pages/privacy\" target=\"_blank\">https://soundcloud.com/pages/privacy</a>.</p> <p>Wenn Sie nicht w??nschen, dass SoundCloud den Besuch unserer Seiten Ihrem SoundCloud- Benutzerkonto zuordnet, loggen Sie sich bitte aus Ihrem SoundCloud-Benutzerkonto aus bevor Sie Inhalte des SoundCloud-Plugins aktivieren.</p> <h3>Spotify</h3> <p>Auf unseren Seiten sind Funktionen des Musik-Dienstes Spotify eingebunden. Anbieter ist die Spotify AB, Birger Jarlsgatan 61, 113 56 Stockholm in Schweden. Die Spotify Plugins erkennen Sie an dem gr??nen Logo auf unserer Seite. Eine ??bersicht ??ber die Spotify-Plugins finden Sie unter: <a href=\"https://developer.spotify.com\" target=\"_blank\">https://developer.spotify.com</a>.</p> <p>Dadurch kann beim Besuch unserer Seiten ??ber das Plugin eine direkte Verbindung zwischen Ihrem Browser und dem Spotify-Server hergestellt werden. Spotify erh??lt dadurch die Information, dass Sie mit Ihrer IP-Adresse unsere Seite besucht haben. Wenn Sie den Spotify Button anklicken w??hrend Sie in Ihrem Spotify-Account eingeloggt sind, k??nnen Sie die Inhalte unserer Seiten auf Ihrem Spotify Profil verlinken. Dadurch kann Spotify den Besuch unserer Seiten Ihrem Benutzerkonto zuordnen.</p> <p>Weitere Informationen hierzu finden Sie in der Datenschutzerkl??rung von Spotify: <a href=\"https://www.spotify.com/de/legal/privacy-policy/\" target=\"_blank\">https://www.spotify.com/de/legal/privacy-policy/</a>.</p> <p>Wenn Sie nicht w??nschen, dass Spotify den Besuch unserer Seiten Ihrem Spotify-Nutzerkonto zuordnen kann, loggen Sie sich bitte aus Ihrem Spotify-Benutzerkonto aus.</p>", 0),
                ("Online Marketing und Partnerprogramme", "eRecht24", "https://www.e-recht24.de", "<h3>Amazon Partnerprogramm</h3> <p>Die Betreiber der Seiten nehmen am Amazon EU- Partnerprogramm teil. Auf unseren Seiten werden durch Amazon Werbeanzeigen und Links zur Seite von Amazon.de eingebunden, an denen wir ??ber Werbekostenerstattung Geld verdienen k??nnen. Amazon setzt dazu Cookies ein, um die Herkunft der Bestellungen nachvollziehen zu k??nnen. Dadurch kann Amazon erkennen, dass Sie den Partnerlink auf unserer Website geklickt haben.</p> <p>Die Speicherung von ???Amazon-Cookies??? erfolgt auf Grundlage von Art. 6 lit. f DSGVO. Der Websitebetreiber hat hieran ein berechtigtes Interesse, da nur durch die Cookies die H??he seiner Affiliate-Verg??tung feststellbar ist.</p> <p>Weitere Informationen zur Datennutzung durch Amazon erhalten Sie in der Datenschutzerkl??rung von Amazon: <a href=\"https://www.amazon.de/gp/help/customer/display.html/ref=footer_privacy?ie=UTF8&nodeId=3312401\" target=\"_blank\">https://www.amazon.de/gp/help/customer/display.html/ref=footer_privacy?ie=UTF8&nodeId=3312401</a>.</p>", 0),
                ("Zahlungsanbieter", "eRecht24", "https://www.e-recht24.de", "<h3>PayPal</h3> <p>Auf unserer Website bieten wir u.a. die Bezahlung via PayPal an. Anbieter dieses Zahlungsdienstes ist die PayPal (Europe) S.??.r.l. et Cie, S.C.A., 22-24 Boulevard Royal, L-2449 Luxembourg (im Folgenden ???PayPal???).</p> <p>Wenn Sie die Bezahlung via PayPal ausw??hlen, werden die von Ihnen eingegebenen Zahlungsdaten an PayPal ??bermittelt.</p> <p>Die ??bermittlung Ihrer Daten an PayPal erfolgt auf Grundlage von Art. 6 Abs. 1 lit. a DSGVO (Einwilligung) und Art. 6 Abs. 1 lit. b DSGVO (Verarbeitung zur Erf??llung eines Vertrags). Sie haben die M??glichkeit, Ihre Einwilligung zur Datenverarbeitung jederzeit zu widerrufen. Ein Widerruf wirkt sich auf die Wirksamkeit von in der Vergangenheit liegenden Datenverarbeitungsvorg??ngen nicht aus.</p> <h3>Klarna</h3> <p>Auf unserer Website bieten wir u.a. die Bezahlung mit den Diensten von Klarna an. Anbieter ist die Klarna AB, Sveav??gen 46, 111 34 Stockholm, Schweden (im Folgenden ???Klarna???).</p> <p>Klarna bietet verschiedene Zahlungsoptionen an (z.B. Ratenkauf). Wenn Sie sich f??r die Bezahlung mit Klarna entscheiden (Klarna-Checkout-L??sung), wird Klarna verschiedene personenbezogene Daten von Ihnen erheben. Details hierzu k??nnen Sie in der Datenschutzerkl??rung von Klarna unter folgendem Link nachlesen: <a href=\"https://www.klarna.com/de/datenschutz/\" target=\"_blank\">https://www.klarna.com/de/datenschutz/</a>.</p> <p>Klarna nutzt Cookies, um die Verwendung der Klarna-Checkout-L??sung zu optimieren. Die Optimierung der Checkout-L??sung stellt ein berechtigtes Interesse im Sinne von Art. 6 Abs. 1 lit. f DSGVO dar. Cookies sind kleine Textdateien, die auf Ihrem Endger??t gespeichert werden und keinen Schaden anrichten. Sie verbleiben auf Ihrem Endger??t bis Sie sie l??schen. Details zum Einsatz von Klarna-Cookies entnehmen Sie folgendem Link: <a href=\"https://cdn.klarna.com/1.0/shared/content/policy/cookie/de_de/checkout.pdf\" target=\"_blank\">https://cdn.klarna.com/1.0/shared/content/policy/cookie/de_de/checkout.pdf</a>.</p> <p>Die ??bermittlung Ihrer Daten an Klarna erfolgt auf Grundlage von Art. 6 Abs. 1 lit. a DSGVO (Einwilligung) und Art. 6 Abs. 1 lit. b DSGVO (Verarbeitung zur Erf??llung eines Vertrags). Sie haben die M??glichkeit, Ihre Einwilligung zur Datenverarbeitung jederzeit zu widerrufen. Ein Widerruf wirkt sich auf die Wirksamkeit von in der Vergangenheit liegenden Datenverarbeitungsvorg??ngen nicht aus.</p> <h3>Sofort??berweisung</h3> <p>Auf unserer Website bieten wir u.a. die Bezahlung mittels ???Sofort??berweisung??? an. Anbieter dieses Zahlungsdienstes ist die Sofort GmbH, Theresienh??he 12, 80339 M??nchen (im Folgenden ???Sofort GmbH???).</p> <p>Mit Hilfe des Verfahrens ???Sofort??berweisung??? erhalten wir in Echtzeit eine Zahlungsbest??tigung von der Sofort GmbH und k??nnen unverz??glich mit der Erf??llung unserer Verbindlichkeiten beginnen.</p> <p>Wenn Sie sich f??r die Zahlungsart ???Sofort??berweisung??? entschieden haben, ??bermitteln Sie die PIN und eine g??ltige TAN an die Sofort GmbH, mit der diese sich in Ihr Online-Banking-Konto einloggen kann. Sofort GmbH ??berpr??ft nach dem Einloggen automatisch Ihren Kontostand und f??hrt die ??berweisung an uns mit Hilfe der von Ihnen ??bermittelten TAN durch. Anschlie??end ??bermittelt sie uns unverz??glich eine Transaktionsbest??tigung. Nach dem Einloggen werden au??erdem Ihre Ums??tze, der Kreditrahmen des Dispokredits und das Vorhandensein anderer Konten sowie deren Best??nde automatisiert gepr??ft.</p> <p>Neben der PIN und der TAN werden auch die von Ihnen eingegebenen Zahlungsdaten sowie Daten zu Ihrer Person an die Sofort GmbH ??bermittelt. Bei den Daten zu Ihrer Person handelt es sich um Vor- und Nachname, Adresse, Telefonnummer(n), Email-Adresse, IP-Adresse und ggf. weitere zur Zahlungsabwicklung erforderliche Daten. Die ??bermittlung dieser Daten ist notwendig, um Ihre Identit??t zweifelsfrei zu festzustellen und Betrugsversuchen vorzubeugen.</p> <p>Die ??bermittlung Ihrer Daten an die Sofort GmbH erfolgt auf Grundlage von Art. 6 Abs. 1 lit. a DSGVO (Einwilligung) und Art. 6 Abs. 1 lit. b DSGVO (Verarbeitung zur Erf??llung eines Vertrags). Sie haben die M??glichkeit, Ihre Einwilligung zur Datenverarbeitung jederzeit zu widerrufen. Ein Widerruf wirkt sich auf die Wirksamkeit von in der Vergangenheit liegenden Datenverarbeitungsvorg??ngen nicht aus.</p> <p>Details zur Zahlung mit Sofort??berweisung entnehmen Sie folgenden Links: <a href=\"https://www.sofort.de/datenschutz.html\" target=\"_blank\">https://www.sofort.de/datenschutz.html</a> und <a href=\"https://www.klarna.com/sofort/\" target=\"_blank\">https://www.klarna.com/sofort/</a>.</p>", 0);');
                break;
            case "2.1.9":
                // New installs of 2.1.8 and 2.1.9 still created the old statistic settings and not the new "statistic_visibleStats".
                // Check if new statistic setting is existing. If not create the new one and delete the old ones.
                $databaseConfig = new \Ilch\Config\Database($this->db());
                $visibilitySettings = $databaseConfig->get('statistic_visibleStats');
                if (empty($visibilitySettings)) {
                    $databaseConfig->set('statistic_visibleStats', '1,1,1,1,1,1', 0);
                }

                // Remove the no longer needed settings of the statistic module
                $this->db()->queryMulti("DELETE FROM `[prefix]_config` WHERE `key` = 'statistic_site';
                             DELETE FROM `[prefix]_config` WHERE `key` = 'statistic_visits';
                             DELETE FROM `[prefix]_config` WHERE `key` = 'statistic_browser';
                             DELETE FROM `[prefix]_config` WHERE `key` = 'statistic_os';");

                // Add "locked" column
                $this->db()->query('ALTER TABLE `[prefix]_users` ADD COLUMN `locked` TINYINT(1) NOT NULL DEFAULT 0;');
                break;
            case "2.1.11":
                // restore noavatar.jpg if it is missing due to a previous bug.
                if (file_exists(ROOT_PATH.'/static/img/noavatar.jpg')) {
                    unlink(ROOT_PATH.'/_q2E9CeHhA5cTNKpa/noavatar.jpg');
                } else {
                    rename(ROOT_PATH.'/_q2E9CeHhA5cTNKpa/noavatar.jpg', ROOT_PATH.'/static/img/noavatar.jpg');
                }
                rmdir(ROOT_PATH.'/_q2E9CeHhA5cTNKpa');
                break;
            case "2.1.12":
                mkdir(ROOT_PATH.'/cache');
                break;
            case "2.1.13":
                // Add new needed column "type" for the notifications.
                $this->db()->query('ALTER TABLE `[prefix]_admin_notifications` ADD COLUMN `type` VARCHAR(255) NOT NULL;');

                // Change datatype of the column gender of the users table.
                $this->db()->query('ALTER TABLE `[prefix]_users` MODIFY COLUMN `gender` TINYINT(1) NOT NULL DEFAULT 0;');
                break;
            case "2.1.15":
                set_time_limit(300);
                // Change VARCHAR length for new table character.
                $this->db()->queryMulti('ALTER TABLE `[prefix]_config` MODIFY COLUMN `key` VARCHAR(191) NOT NULL;
                ALTER TABLE `[prefix]_modules` MODIFY COLUMN `key` VARCHAR(191) NOT NULL;
                ALTER TABLE `[prefix]_groups_access` MODIFY COLUMN `module_key` VARCHAR(191) DEFAULT 0;');

                // Convert all core and system module tables to new character and collate
                $this->db()->queryMulti('ALTER TABLE `[prefix]_admin_notifications` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_admin_notifications_permission` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_admin_updateservers` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_articles` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_articles_cats` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_articles_content` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_auth_providers` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_auth_providers_modules` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_auth_tokens` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_backup` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_boxes` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_boxes_content` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_comments` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_config` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_contact_receivers` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_cookie_stolen` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_emails` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_groups` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_groups_access` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_imprint` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_logs` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_media` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_media_cats` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_menu` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_menu_items` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_modules` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_modules_boxes_content` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_modules_content` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_modules_folderrights` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_modules_php_extensions` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_pages` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_pages_content` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_privacy` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_profile_content` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_profile_fields` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_profile_trans` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_users_auth_providers` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_users_dialog` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_users_dialog_reply` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_users_gallery_imgs` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_users_gallery_items` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_users_groups` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_users_media` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_user_menu` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_user_menu_settings_links` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_visits_online` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ALTER TABLE `[prefix]_visits_stats` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');

                // Change now no longer used smilies module to an optional module and set a few needed values so it can
                // be uninstalled like a normal module. This is done so that the user can backup maybe needed smilies.
                $this->db()->query("UPDATE `[prefix]_modules` SET `system` = '0', `version` = '1.0' WHERE `key` = 'smilies';");

                $databaseConfig = new \Ilch\Config\Database($this->db());
                $databaseConfig->set('comment_box_comments_limit', '5');
                break;
            case "2.1.16":
                // Add comments box to list of boxes.
                $configClass = \Modules\Comment\Config\Config::class;
                $config = new $configClass($this->getTranslator());
                $boxMapper = new \Modules\Admin\Mappers\Box();

                if (isset($config->config['boxes'])) {
                    $boxModel = new \Modules\Admin\Models\Box();
                    $boxModel->setModule($config->config['key']);
                    foreach ($config->config['boxes'] as $key => $value) {
                        $boxModel->addContent($key, $value);
                    }
                    $boxMapper->install($boxModel);
                }

                replaceVendorDirectory();
                break;
            case "2.1.17":
                removeDir(ROOT_PATH.'/vendor');
                // Delete possible rest of update to 2.1.17.
                if (file_exists(ROOT_PATH.'/_vendor')) {
                    removeDir(ROOT_PATH.'/_vendor');
                }

                rename(ROOT_PATH.'/__vendor', ROOT_PATH.'/vendor');
                break;
            case "2.1.18":
                // Add "expires" column to let the confirm code expire after a specific time.
                $this->db()->query('ALTER TABLE `[prefix]_users` ADD COLUMN `expires` DATETIME AFTER `selector`;');

                replaceVendorDirectory();
                break;
            case "2.1.19":
                // Remove no longer used column.
                $this->db()->query('ALTER TABLE `[prefix]_media` DROP COLUMN `cat_name`;');

                // Clear visits_online and add new session_id column
                $this->db()->truncate('[prefix]_visits_online');
                $this->db()->query('ALTER TABLE `[prefix]_visits_online` ADD COLUMN `session_id` VARCHAR(255) NOT NULL DEFAULT \'\' AFTER `user_id`;');

                replaceVendorDirectory();
                break;
            case "2.1.20":
                // Add target column to menu_items
                $this->db()->query('ALTER TABLE `[prefix]_menu_items` ADD COLUMN `target` VARCHAR(50) NULL DEFAULT NULL AFTER `href`;');

                replaceVendorDirectory();
                break;
            case "2.1.21":
                // Convert old value of smtp_secure (phpmailer) to a valid one if neccessary.
                $databaseConfig = new \Ilch\Config\Database($this->db());
                $smtpSecureSetting = $databaseConfig->get('smtp_secure');
                if (!empty($smtpSecureSetting)) {
                    switch($smtpSecureSetting) {
                        case "TLS":
                        case "STARTTLS":
                            $databaseConfig->set('smtp_secure', 'tls');
                            break;
                        case "SSL":
                            $databaseConfig->set('smtp_secure', 'ssl');
                    }
                }

                replaceVendorDirectory();
                break;
            case "2.1.23":
                replaceVendorDirectory();
                break;
            case "2.1.24":
                // Add possible missing boxes.
                $moduleMapper = new \Modules\Admin\Mappers\Module();
                $boxMapper = new \Modules\Admin\Mappers\Box();

                $installedModules = $moduleMapper->getModules();
                $boxes = $boxMapper->getBoxList('de_DE');
                foreach (glob(ROOT_PATH.'/application/modules/*') as $modulesPath) {
                    $installed = false;
                    $key = basename($modulesPath);
                    foreach($installedModules as $installedModule) {
                        if ($installedModule->getKey() == $key) {
                            $installed = true;
                            break;
                        }
                    }

                    if (!$installed) {
                        continue;
                    }

                    $configClass = '\\Modules\\'.ucfirst($key).'\\Config\\Config';
                    if (class_exists($configClass)) {
                        $config = new $configClass($this->getTranslator());
                        if (!empty($config->config) && isset($config->config['boxes'])) {
                            $boxModel = new \Modules\Admin\Models\Box();
                            $boxModel->setModule($config->config['key']);
                            foreach ($config->config['boxes'] as $key => $value) {
                                $boxFound = false;
                                foreach ($boxes as $box) {
                                    if ($box->getKey() == $key) {
                                        $boxFound = true;
                                        break;
                                    }
                                }

                                if (!$boxFound) {
                                    $boxModel->addContent($key, $value);
                                }
                            }

                            if (!empty($boxModel->getContent())) {
                                $boxMapper->install($boxModel);
                            }
                        }
                    }
                }
                break;
            case "2.1.25":
                // Add extension blacklist and the "disable purifier" setting to the database.
                $databaseConfig = new \Ilch\Config\Database($this->db());
                $databaseConfig->set('media_extensionBlacklist', 'html htm xht xhtml php php2 php3 php4 php5 phtml pwml inc asp aspx ascx jsp cfm cfc pl bat exe com dll vbs js reg cgi htaccess asis sh shtml shtm phtm');
                $databaseConfig->set('disable_purifier', '0');

                // Remove forbidden file extensions.
                $targets = ['media_ext_file', 'media_ext_img', 'media_ext_video'];
                $blacklist = explode(' ', $databaseConfig->get('media_extensionBlacklist'));
                foreach ($targets as $target) {
                    $array = explode(' ', $databaseConfig->get($target));
                    $array = array_diff($array, $blacklist);
                    $databaseConfig->set($target, implode(' ', $array));
                }

                replaceVendorDirectory();
                break;
            case "2.1.26":
                // Add commentsDisabled column to table of articles
                $this->db()->query('ALTER TABLE `[prefix]_articles` ADD COLUMN `commentsDisabled` TINYINT(1) NOT NULL DEFAULT 0 AFTER `top`;');

                // Add articles_templates table
                $this->db()->queryMulti('CREATE TABLE IF NOT EXISTS `[prefix]_articles_templates` (
                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `author_id` INT(11) NOT NULL,
                  `content` MEDIUMTEXT NOT NULL,
                  `description` MEDIUMTEXT NOT NULL,
                  `keywords` VARCHAR(255) NOT NULL,
                  `locale` VARCHAR(255) NOT NULL,
                  `title` VARCHAR(255) NOT NULL,
                  `teaser` VARCHAR(255) NOT NULL,
                  `perma` VARCHAR(255) NOT NULL,
                  `img` VARCHAR(255) NOT NULL,
                  `img_source` VARCHAR(255) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;');

                // Remove forbidden file extensions.
                $databaseConfig = new \Ilch\Config\Database($this->db());
                $targets = ['avatar_filetypes', 'usergallery_filetypes'];
                $blacklist = explode(' ', $databaseConfig->get('media_extensionBlacklist'));
                foreach ($targets as $target) {
                    $array = explode(' ', $databaseConfig->get($target));
                    $array = array_diff($array, $blacklist);
                    $databaseConfig->set($target, implode(' ', $array));
                }

                replaceVendorDirectory();

                // Remove no longer needed files
                unlink(APPLICATION_PATH.'/modules/media/static/js/jquery.fileupload.js');
                unlink(APPLICATION_PATH.'/modules/media/static/js/jquery.iframe-transport.js');
                unlink(APPLICATION_PATH.'/modules/media/static/js/jquery.ui.widget.js');
                unlink(APPLICATION_PATH.'/modules/media/static/js/jquery.knob.js');
                break;
            case "2.1.27":
                replaceVendorDirectory();
                break;
            case "2.1.28":
                // Add disable_purifier with default value 0 if not existing.
                // On new installs it wasn't created before and this lead to confusion on users.
                $databaseConfig = new \Ilch\Config\Database($this->db());
                $disablePurifier = $databaseConfig->get('disable_purifier');

                if ($disablePurifier === null) {
                    $databaseConfig->set('disable_purifier', '0');
                }

                replaceVendorDirectory();

                // Remove no longer needed file
                unlink(APPLICATION_PATH.'/libraries/Ilch/Session.php');
                break;
            case "2.1.30":
                replaceVendorDirectory();
                break;
            case "2.1.31":
                $this->db()->query('CREATE TABLE IF NOT EXISTS `[prefix]_admin_layoutadvsettings` (
                    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `layoutKey` VARCHAR(255) NOT NULL,
                    `key` VARCHAR(255) NOT NULL,
                    `value` TEXT NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;');

                replaceVendorDirectory();
                break;
            case "2.1.32":
                // Lowercase table name as it caused problems on different os (case sensitive or insensitive)
                $this->db()->query('ALTER TABLE `[prefix]_admin_layoutAdvSettings` RENAME TO `[prefix]_admin_layoutadvsettings`;');
                break;
            case "2.1.33":
                replaceVendorDirectory();
                break;
            case "2.1.34":
                replaceVendorDirectory();
                break;
            case "2.1.36":
                // Remove no longer needed file
                unlink(APPLICATION_PATH.'/libraries/Ilch/Event.php');

                // Update comment keys in the comments table to end with a slash.
                $sqlCommands = '';
                $counter = 0;
                $comments = $this->db()->select(['id', 'key'])
                    ->from('comments')
                    ->execute()
                    ->fetchRows();

                if (!empty($comments)) {
                    foreach($comments as $comment) {
                        $key = '';
                        if (!(\strlen($comment['key']) - (strrpos($comment['key'], '/')) === 0)) {
                            // Add missing slash at the end to usually terminate the id.
                            // This is needed for example so that id 11 doesn't get counted as id 1.
                            $key = $comment['key'] . '/';
                        }

                        // Run commands if we already have 50. This is done to limit the size of the sql command string.
                        // There might be limits defined by for example in case of mysql in "max_allowed_packet".
                        if (($counter === 50) && !empty($sqlCommands)) {
                            $this->db()->queryMulti($sqlCommands);
                            $counter = 0;
                            $sqlCommands = '';
                        }

                        $sqlCommands .= 'UPDATE `'.$this->db()->getPrefix().'comments` SET `key` = \''.$key.'\' WHERE `id` = '.$comment['id'].';';
                        $counter++;
                    }

                    if (!empty($sqlCommands)) {
                        $this->db()->queryMulti($sqlCommands);
                    }
                }

                replaceVendorDirectory();
                break;
            case "2.1.39":
                // Change updateserver to the first one if the current one is the second one.
                // Don't change the server if that is not the case to avoid problems with maybe the rare case of an own
                // updateservers with own certificate.
                $databaseConfig = new \Ilch\Config\Database($this->db());
                if ($databaseConfig->get('updateserver') === 'https://www.blackcoder.de/ilch-us/stable/') {
                    $databaseConfig->set('updateserver', 'https://ilch2.de/development/updateserver/stable/');
                }

                // Remove the second updateserver.
                $this->db()->query("DELETE FROM `[prefix]_admin_updateservers` WHERE `url` = 'https://www.blackcoder.de/ilch-us/stable/';");
                break;
            case "2.1.40":
                $groupMapper = new \Modules\User\Mappers\Group();
                $groups = $groupMapper->getGroupList();
                
                $moduleMapper = new \Modules\Admin\Mappers\Module();
                $modules = $moduleMapper->getModules();

                $pageMapper = new \Modules\Admin\Mappers\Page();
                $pages = $pageMapper->getPageList();

                $articleMapper = new \Modules\Article\Mappers\Article();
                $articles = $articleMapper->getArticles();

                $boxMapper = new \Modules\Admin\Mappers\Box();
                $boxes = $boxMapper->getSelfBoxList('');

                $accessTypes = [
                    'module' => $modules,
                    'page' => $pages,
                    'article' => $articles,
                    'box' => $boxes,
                ];

                foreach ($groups as $key => $group) {
                    if ($group->getId() !== 1) {
                        $groupAccessList[$group->getId()] = $groupMapper->getGroupAccessList($group->getId());
                    }
                }

                foreach($groupAccessList as $groupid => $groupData) {
                    foreach ($groupData['entries'] as $type => $accessData) {
                        $TypeData = $accessTypes[$type];
                        foreach ($TypeData as $TypeDataModel) {
                            if ($type === 'module') {
                                $value = $TypeDataModel->getKey();
                            } else {
                                $value = $TypeDataModel->getId();
                            }
                            if (!isset($accessData[$value])) {
                                $groupMapper->saveAccessData($groupid, $value, 1, $type);
                            }
                        }
                    }
                }
                break;
            case "2.1.41":
                replaceVendorDirectory();
                break;
            case "2.1.42":
                // Update Captcha
                $databaseConfig = new \Ilch\Config\Database($this->db());
                $databaseConfig->set('captcha', '0');
                $databaseConfig->set('captcha_apikey', '');
                $databaseConfig->set('captcha_seckey', '');
                
                replaceVendorDirectory();
                break;
            case "2.1.43":
                // Create new table for articles read access.
                $this->db()->queryMulti('CREATE TABLE `[prefix]_articles_access` (
                    `article_id` INT(11) NOT NULL,
                    `group_id` INT(11) NOT NULL,
                    PRIMARY KEY (`article_id`, `group_id`) USING BTREE,
                    INDEX `FK_[prefix]_articles_access_[prefix]_groups` (`group_id`) USING BTREE,
                    CONSTRAINT `FK_[prefix]_articles_access_[prefix]_articles` FOREIGN KEY (`article_id`) REFERENCES `[prefix]_articles` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE,
                    CONSTRAINT `FK_[prefix]_articles_access_[prefix]_groups` FOREIGN KEY (`group_id`) REFERENCES `[prefix]_groups` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');

                // Convert data from old read_access column of table articles to the new articles_access table.
                $readAccessRows = $this->db()->select(['id', 'read_access'])
                    ->from(['articles'])
                    ->execute()
                    ->fetchRows();

                $existingGroups = $this->db()->select('id')
                    ->from(['groups'])
                    ->execute()
                    ->fetchList();

                $sql = 'INSERT INTO [prefix]_articles_access (article_id, group_id) VALUES';
                $sqlWithValues = $sql;
                $rowCount = 0;

                foreach ($readAccessRows as $readAccessRow) {
                    $readAccessArray = [];
                    $readAccessArray[$readAccessRow['id']] = explode(',', $readAccessRow['read_access']);
                    foreach ($readAccessArray as $articleId => $groupIds) {
                        // There is a limit of 1000 rows per insert, but according to some benchmarks found online
                        // the sweet spot seams to be around 25 rows per insert. So aim for that.
                        if ($rowCount >= 25) {
                            $sqlWithValues = rtrim($sqlWithValues, ',') . ';';
                            $this->db()->queryMulti($sqlWithValues);
                            $rowCount = 0;
                            $sqlWithValues = $sql;
                        }

                        // Don't try to add a groupId that doesn't exist in the groups table as this would
                        // lead to an error (foreign key constraint).
                        $groupIds = array_intersect($existingGroups, $groupIds);
                        $rowCount += \count($groupIds);

                        foreach ($groupIds as $groupId) {
                            $sqlWithValues .= '(' . $articleId . ',' . $groupId . '),';
                        }
                    }
                }

                // Insert remaining rows.
                $sqlWithValues = rtrim($sqlWithValues, ',') . ';';
                $this->db()->queryMulti($sqlWithValues);

                // Delete old read_access column of table articles.
                $this->db()->query('ALTER TABLE `[prefix]_articles` DROP COLUMN `read_access`;');

                // Add constraint to articles_content after deleting orphaned rows in it (rows with an article id not
                // existing in the articles table) as this would lead to an error.
                $idsArticles = $this->db()->select('id')
                    ->from('articles')
                    ->execute()
                    ->fetchList();

                $idsArticlesContent = $this->db()->select('article_id')
                    ->from('articles_content')
                    ->execute()
                    ->fetchList();

                $orphanedRows = array_diff($idsArticlesContent ?? [], $idsArticles ?? []);
                if (count($orphanedRows) > 0) {
                    $this->db()->delete()->from('articles_content')
                        ->where(['article_id' => $orphanedRows])
                        ->execute();
                }

                $this->db()->query('ALTER TABLE `[prefix]_articles_content` ADD CONSTRAINT `FK_[prefix]_articles_content_[prefix]_articles` FOREIGN KEY (`article_id`) REFERENCES `[prefix]_articles` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE;');

                // Add new updateserver if not exist.
                if (!$this->db()->select('url', 'admin_updateservers', ['url' => 'https://www.ilch.de/ilch2_updates/stable/'])->execute()->getNumRows()) {
                    $this->db()->insert('admin_updateservers')
                        ->values(['url' => 'https://www.ilch.de/ilch2_updates/stable/', 'operator' => 'ilch', 'country' => 'Germany'])
                        ->execute();
                }

                // Change updateserver to the new one if the current one is the old one.
                // Don't change the server if that is not the case to avoid problems with maybe the rare case of an own
                // updateservers with own certificate.
                $databaseConfig = new \Ilch\Config\Database($this->db());
                if ($databaseConfig->get('updateserver') === 'https://ilch2.de/development/updateserver/stable/') {
                    $databaseConfig->set('updateserver', 'https://www.ilch.de/ilch2_updates/stable/');
                }

                // Remove the old updateserver.
                $this->db()->query("DELETE FROM `[prefix]_admin_updateservers` WHERE `url` = 'https://ilch2.de/development/updateserver/stable/';");

                replaceVendorDirectory();
                break;
        }

        return 'Update function executed.';
    }
}

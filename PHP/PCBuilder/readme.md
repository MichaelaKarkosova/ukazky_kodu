Tento web je poměrně zastaralý, nicméně hlavní část (index.php) byla přepsána do OOP.
Web běží na http://www.misakarkosova.eu/
Web slouží k porovnávání kompatibility komponent - kontroluje, zda procesor pasuje do desky, zda ramky sedí nebo jestli nemá grafická karta nižší verzi PCI-E než deska.
Web má ještě další části - po kliku na tlačítko "Hodnocení zdroje" se dostaneme na stránku, kde lze zadat odkaz na zdroj z czc.cz a systém nám zhodnotí kvalitu zdroje. 
Další část je pod tlačítkem "přidat komponentu". Zde můžeme jednoduše přidat komponentu do seznamu, abychom ji pak mohli vybrat na hlavním webu. Systém by měl sebrat informace z odkazu na czc a komponentu s nimi přidat. Zda je komponenta přidána si můžeme ověřit na hlavní stránce webu.


Vzhled webu prosím moc neřešte - šlo o experimentální vzhled a jsem spíš na backend. Codebase tohoto projektu je přibližně 4 roky stará (až na index.php, který byl přepsán).
Jelikož je kod starší, je možné, že přidávání a hodnocení zdrojů nemusí fungovat úplně na 100% - některé informace možná nebudou z czc získány. 

# VSPJ-RSP-Jedu
##### Repozitář skupiny Jedu předmětu ŘSP, VSPJ.

Zprovozněná verze se nachází **[zde](https://alpha.kts.vspj.cz/~hak01/RSP/index.html)**

### Účty zprovozněné verze
Následující účty existují v ukázkové verzi, jsou zapsané ve formě: **Oprávnění (login/heslo)**
- Admin (admin/admin)
- Šéfredaktor (sefredaktor/sefredaktor)
- Redaktor (redaktor/redaktor)
- Recenzent (recenzent/recenzent)
- Recenzent (recenzent2/recenzent2)
- Autor (autor/autor)
- Autor (autor2/autor2)

## Administrátorská dokumentace

### Požadavky na systém
- **Apache** web server
- **PHP** (alespoň verze 7.4)
- **MySQ**L Databáze
- RWX práva celému projektu

### Instalace
- Ve své databázi vytvořte potřebné tabulky, SQL query pro vytvoření najdete v **Resources/database_create.sql**
- V tabulce `uzivatel` manuálně vytvořte uživatele s oprávněním **admin**, pro vygenerování md5 hesla použijte např. http://www.md5.cz/
- Přesuňte na svůj webový server celý obsah složky **Source**
- V souboru **Source/components/connect.php** upravte údaje dle vaší databáze

### Provoz
Registrovat účet s oprávěním Autor může kdokoli, ovšem vytvářet/přidělovat jiné role může pouze uživatel s rolí Admin. Vytvoření nového uživatele jako admin naleznete v menu, popř. můžete upravit již existující účet a roli přiřadit.

Administrátorský účet je jediný, který dokáže mazat záznamy - např. příspěvky, uživatele.

Pro vytvoření nových tématických čísel časopisu je třeba číslo manuálně zadat do databáze.

## Uživatelská dokumentace

Všechny role mají společnou záložku **Moje agenda**, ve které uvidí v tabulkové formě všechny jim relevantní informace.

### Autor
Pro vytvoření nového příspěvku zvolte položku **Nový příspěvek** v menu. Následně vyplňte detaily, můžete také nahrát první verzi svého textu.
- *Text by měl být ve formátu .txt, jelikož je systém zobrazuje texty pouze v přímé textové formě*

Vámi vytvořené příspěvky můžete následně sledovat v záložce **Moje agenda**, kde také naleznete recenze svých příspěvků.

### Redaktor
V záložce **Moje agenda** můžete nalézt všechny příspěvky, zadané do systému, a také vámi zadané recenze. Tyto příspěvky můžete prohlížet a upravovat, popř. také vybrat recenzenty, kteří tento příspěvek dostanou za úkol do určitého data zrecenzovat.

### Šéfredaktor
V záložce **Moje agenda** uvidite všechny příspěvky i recenze.

### Recenzent
Redaktorem vám přidělené recenze uvidíte v záložce **Moje agenda**, u kterých také uvidíte k jakému příspěvku se vztahují. Příspěvek si můžete prohlédnout, a následně mu zadat hodnocení, pomocí možnosti **zvolit hodnocení** v detailu příspěvku, či v kontextovém menu v tabulkovém zobrazení.


*Vytvořil tým Jedu*
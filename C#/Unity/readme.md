main.cs - Skript" umožňuje Unity "agentovi" následovat hráče, pokousat ho, zabít nebo ho pronásledovat. K tomu dojde, když se dostane příliš blízko. Další funkce je zabíjení hráče, když se přiblíží k sopce a zvedání teploty vlivem tepla. Unity používá C#.

Openchat.cs - otevírá chat po kliknutí na UI tlačítko 

energyLose - loď ztrácí palivo v závislosti na rychlosti letu. Aktualizuje se vzhled UI prvků a snižuje se jejich hodnota.

DataSaver- slouží k ukládání dat do souboru. Zajištuje také, že s daty není možné manipulovat ručně. Encoduje data do binaru, kontroluje checksum a tím zjištuje, zda jsou validní. Do tohoto souboru se ukládají informace:
- Peníze hráče
- Množství benzínu v autě
- Cena auta
- Název auta
- SPZ hráče
- Checksum (kontrolní součet)

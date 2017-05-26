# Anax-lite

Databasen består av två tabeller, users och content. Det finns en enda trigger som används för att sätta current timestamp på published om man inte anger något annat.

Alla tabeller har surrogata primära nycklar, ett id. Dessa är AUTO_INCREMENT.
Så att allting är ganska simpel och enkel.

## Updates

Nu lag jag till lite funktionalitet.

Needed stuff tabellen används för att ha koll på lager. Blir det färre än 5 varor av något typ då skrivs det till tabellen.

Stock är själva lager. Den innehåller allt man har i lager.

Category är en tabell som innehåller de olika kategorier av varor.

Cart är varukorgen.

OrderRow är en tabell som innehåller orderdata

Odder innehåller olika orders.

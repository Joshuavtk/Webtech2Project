# Adviesrapport

In dit document zal ik mijn framework vergelijken met Laravel en ASP.NET Core MVC. Ik heb zelf alleen veel ervaring met
Laravel dus de meeste vergelijkingen komen zijn daarmee.

### Codekwaliteit

Ik heb zelf vaak dat de business logic en delen van het framework in hetzelfde bestand zitten wat slecht is voor
leesbaarheid en voor te developen want je weet niet zeker aan welke onderdelen je wel kan zitten en welke niet.

### Routing

Momenteel werkt mijn routing door alle routes in de `/public/index.php` te zetten en er is nog geen specifiek bestand
voor wat verwarrend kan zijn. Mijn framework ondersteund om bij een route een functie, view of een functie van een
controller mee te geven wat aardig uitgebreid is.

Laravel en ASP.NET bieden bij zijn routing ook de functionaliteit om als je een array terug geeft er een JSON-response
van te maken wat zeer handig kan zijn voor als je een API calls wilt ondersteunen.

### Templating

Mijn framework mist nog een hoop functionaliteit bij de templates en heeft op het moment alleen simpele injection van
andere templates en op een onhandige manier wordt data meegegeven aan templates.

Laravel heeft zeer nuttige functionaliteit zoals links naar andere pagina's laten genereren die mee kunnen veranderen
maakt niet uit in welke subfolder je zit. Ook heeft Laravel een stuk makkelijkere syntax om data in je template te
zetten d.m.v Blade.

### Dependency Injection

Mijn framework gebruikt momenteel wel Dependency injection, maar ik heb nog nergens de container gebruikt en doe het
altijd handmatig.

Ik kan door zo snel te googelen ook geen DI-Container vinden voor ASP.NET en voor Laravel heb ik dat zelf nog nooit 
gebruikt.

### Database
Ik gebruik momenteel Models die standaard functionaliteiten hebben van de `DatabaseModel.php` en `Model.php`, maar dit 
mist nog wel aardig wat functionaliteit zoals het kunnen opbouwen van query's groter dan alleen een WHERE clause.

Met Laravel kan je Eloquent gebruiken om simpel uitgebreide dingen te doen met je Models. ASP.NET gebruikt standaard de 
Entity Framework.
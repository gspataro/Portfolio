---
name: Portfolio
description: Il codice sorgente del mio portfolio.
github: https://github.com/gspataro/Portfolio
link: https://gspataro.github.io
version: '2.0'
category: website
technologies:
    - PHP
    - TailwindCSS
    - HTML
    - Javascript
---

Il mio portfolio è un esempio concreto dei miei esperimenti. Si tratta di un sito web statico e ho colto questa sfida per poter creare un generatore interamente
personalizzato. Questo generatore converte i dati markdown/json in delle pagine HTML applicandole a dei template definiti.

## Sviluppo

La sfida più grande è stata quella di gestire i dati in maniera flessibile e automatica, non volevo trovarmi nella condizione di dover aggiungere una pagina alla
volta. Così ho creato un sistema basato su un file chiamato blueprint.json che contiene tutte le informazioni per la generazione automatica del sito, l'unica cosa che vanno forniti sono i template e i file markdown/json.

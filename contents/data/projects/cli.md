---
name: CLI
description: Componente PHP per la creazione di script eseguibili via riga di comando.
github: https://github.com/gspataro/CLI
version: '2.0.1'
category: component
technologies:
    - PHP
---

GSpataro/CLI è un componente PHP per la creazione di script eseguibili via riga di comando.

<figure>
    <img src="{{media('cli-main.png', 'original')}}" alt="Esempio di uno script creato con GSpataro/CLI">
    <figcaption>Esempio di uno script creato con GSpataro/CLI</figcaption>
</figure>

## Sviluppo

Questo componente nasce dal voler apprendere e approfondire il funzionamento di PHP per la gestione di script eseguibili da terminale. Le principali fonti di ispirazione sono Artisan, componente del framework Laravel, e Console, componente del framework Symfony.

Le sfide che mi si sono poste davanti sono:

- Gestione di input e output con possibilità di personalizzazione degli stream STDIN e STDOUT per poter creare ambienti di test automatizzati
- Utilizzo di una sintassi semplificata per aggiungere comandi sia in forma di callback che di classe con una gestione avanzata delle opzioni e degli argomenti
- Creazione di tabelle come output

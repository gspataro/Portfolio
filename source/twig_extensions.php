<?php

$twig->addFunction(new \Twig\TwigFunction("data", function ($query) use ($dataBuilder) {
    return $dataBuilder->get($query);
}));

$twig->addFunction(new \Twig\TwigFunction(
    "lang",
    function ($context, string $query, string $fileName) use ($locales) {
        $langKey = $context['lang']['current'];
        $lang = $locales->getLanguage($langKey);

        return $lang->get($query, $fileName);
    },
    ['needs_context' => true]
));

$twig->addFunction(new \Twig\TwigFunction("link", function ($context, $path) use ($blueprint) {
    $urlPrefix = $context['lang']['current'] != $blueprint['default_language'] ?
        "/{$context['lang']['current']}" :
        "";

    return "{$urlPrefix}/{$path}";
}, ["needs_context" => true]));

$twig->addFunction(new \Twig\TwigFunction("parsedown", function ($context, $fileName) use ($parsedown) {
    $lang = $context['lang']['current'];

    if (is_file(DIR_DATA . "/markdown/{$fileName}_{$lang}.md")) {
        $raw = file_get_contents(DIR_DATA . "/markdown/{$fileName}_{$lang}.md");
    } elseif (is_file(DIR_DATA . "/markdown/{$fileName}.md")) {
        $raw = file_get_contents(DIR_DATA . "/markdown/{$fileName}.md");
    } else {
        return;
    }

    return $parsedown->toHtml($raw);
}, ["needs_context" => true]));

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
    $filePath = DIR_DATA . "/markdown/{$fileName}.md";

    if (!is_file($filePath)) {
        return "markdown:{$fileName}";
    }

    $rawMarkdown = file_get_contents($filePath);

    if (!str_starts_with($rawMarkdown, "@localize;")) {
        return $parsedown->toHtml($rawMarkdown);
    }

    $langKey = $context['lang']['current'];
    $rawLocalizedMarkdown = getStringBetween($rawMarkdown, "@start:{$langKey};", "@end:{$langKey};");

    if (is_null($rawLocalizedMarkdown)) {
        return "markdown:{$langKey}:{$fileName}";
    }

    return $parsedown->toHtml($rawLocalizedMarkdown);
}, ["needs_context" => true]));

<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigPluralizeExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction("pluralize", [$this, "pluralize"]),
        ];
    }

    public function pluralize(int $count, string $one, string $many, string|null $none): string
    {
        $none = $none ?? $many;

        $string = match ($count) {
            0 => $none,
            1 => $one,
            default => $many,
        };

        return sprintf($string, $count);
    }
}
// extension à Twig pour mettre une phrase en fonction d'un nombre pour l'utiliser par exemple
// {{pluralize(article.commentaires | length, "un commentaire", "%d commentaires", "aucun commentaire")}}
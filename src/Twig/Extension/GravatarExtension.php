<?php
namespace App\Twig\Extension;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GravatarExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        // Il est possible de définir plusieurs fonction Twig
        return [
            new TwigFunction('gravatar', [$this, 'getGravatarUri']),
        ];
    }

    public function getGravatarUri($email, $size='80', $rating='g'): string
    {
        $url = 'https://gravatar.com/avatar/%s?size=%u&rating=%s';
        $hash = md5(strtolower(trim($email)));
        return sprintf($url, $hash, (int) $size, $rating);
    }
}

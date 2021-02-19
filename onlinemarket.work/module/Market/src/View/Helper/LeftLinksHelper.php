<?php
namespace Market\View\Helper;
use Laminas\View\Helper\AbstractHtmlElement;
/**
 * View helper to produce an HTML list of links to online market categories
 */
class LeftLinksHelper extends AbstractHtmlElement
{
    /**
     * Produces mixed output depending on logic you place inside __invoke()
     *
     * @param array $values : online market categories
     * @param string $urlPrefix
     * @return string $html
     */
    public function __invoke(array $values, string $urlPrefix)
    {
        $html = '';
        if (isset($values) && is_array($values)) {
            $html .= '<ul  style="list-style-type: none;">' . PHP_EOL;
            foreach ($values as $item) {
                $html .= str_replace('//',
                    '/',
                    sprintf("<li><a href=\"%s/%s\">%s</a></li>\n",
                    $urlPrefix, $item, $item)
                );
            }
            $html .= '</ul>' . PHP_EOL;
        }
        return $html;
    }
}

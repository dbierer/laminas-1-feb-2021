<?php
namespace Market\Controller\Plugin;
use DateTime;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
class TimePlugin extends AbstractPlugin
{
    /**
     * Produces mixed output depending on logic you place inside __invoke()
     *
     * @param string $param
     * @param mixed $default
     * @return mixed
     */
    public function __invoke($param = null, $default = null)
    {
		$date = new DateTime();
        return $date->format('l, d M Y T');
    }
}

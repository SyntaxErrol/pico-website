<?php

/**
 * Pico assets modification time plugin
 *
 * Registers a Twig filter to add a asset's modification time. Pass a path
 * to a file and it will return its corresponding URL with a time suffix.
 *
 * Example:
 *
 * ```twig
 * <link rel="stylesheet" type="text/css" href="{{ ("themes/" ~ config.theme ~ "/style.css")|asset }}"/>
 * ```
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 0.0.1
 */
class PicoAssetsModPlugin extends AbstractPicoPlugin
{
    const API_VERSION = 2;

    public function onTwigRegistered(Twig_Environment &$twig)
    {
        $pico = $this->getPico();
        $twig->addFilter(new Twig_SimpleFilter('asset', function ($file) use ($pico) {
            $file = str_replace('\\', '/', $file);
            $fileParts = explode('/', $file);

            $assetParts = array();
            foreach ($fileParts as $filePart) {
                if (($filePart === '') || ($filePart === '.')) {
                    continue;
                } elseif ($filePart === '..') {
                    array_pop($assetParts);
                    continue;
                }
                $assetParts[] = $filePart;
            }

            $asset = implode('/', $assetParts);
            $timeSuffix = is_file($pico->getRootDir() . $asset) ? '?v=' . filemtime($pico->getRootDir() . $asset) : '';
            return $pico->getBaseUrl() . $asset . $timeSuffix;
        }));
    }
}
